<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserLogoutRequest;
use App\Http\Requests\auth\UserRegisterRequest;
use App\Models\RevokedToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if(Auth::viaRemember()) {
            $request->session()->regenerate();

            return redirect('/admin/dashboard')->with('success', 'Logged In!');
        }

        return view('login');
    }

    public function loginPost(UserLoginRequest $loginRequest)
    {
        $loginRequest->validated();

        $credentials = $loginRequest->safe()->only(['email', 'password']);
        $remember = $loginRequest->safe()->only('remember_me')['remember_me'] ?? 'off';

        if(Auth::attempt($credentials, $remember == 'on')) {
            $loginRequest->session()->regenerate();
            return redirect('/admin/dashboard')->with('success', $loginRequest->all());
        }

        return back()->with('error', 'Failed to login, email or password is incorrect!')->withInput();
    }

    public function logout(UserLogoutRequest $request)
    {
        Auth::logout();
        Auth::forgetUser();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('/');
    }

    public function apiLogin(UserLoginRequest $loginRequest)
    {
        $loginRequest->validated();

        $credentials = $loginRequest->safe()->only(['email', 'password']);
        $remember = $loginRequest->safe()->only('remember_me')['remember_me'] ?? 'off';

        try {
            // Attempt to login the user using the credentials sent.
            // If the user wants to remember its session, set the
            // generated token's expiration date to 30 days. Otherwise,
            // just set to 1 day.

            if(!$token = JWTAuth::attempt($credentials, ['exp' => \Carbon\Carbon::now()->addDays($remember == 'on' ? 30 : 1)->timestamp])) {
                $user = User::where('email', $credentials['email'])->first();

                if(!$user)
                    return response()->json(['error' => 'Invalid email address'], 401);
                else if(!Hash::check($credentials['password'], $user->password)) {
                    return response()->json(['error' => 'Invalid password'], 401);
                }

                return response()->json(['error' => 'Invalid email or password'], 401);
            }
        } catch (JWTException $jwtException) {
            return response()->json(['error' => 'Could not create token'], 500);
        }

        $user = Auth::user();
        $user->photo = asset('uploads/profiles' . $user->photo);
        $user->authentication_token = $token;

        return response()->json([
            'user' => $user,
        ]);
    }

    public function apiRegister(UserRegisterRequest $registerRequest)
    {
        $registerRequest->validated();

        $credentials = $registerRequest->safe()->all();
        $credentials['password'] = Hash::make($credentials['password']);

        $user = User::create([
            ...$credentials,
            'assign_datetime' => \Carbon\Carbon::now()->format('Y-m-d h:i:s'),
            'type' => 'tourist',
        ]);

        return response()->json(['message' => 'Registered successfully!']);
    }

    public function apiLogout(Request $request)
    {
        $token = $request->bearerToken();

        // Add the token to the revoked tokens table
        RevokedToken::create([
            'token' => $token
        ]);

        return response()->json(['message' => 'Logged out']);
    }

    public function apiCheckAuthentication(Request $request)
    {
        try {
            JWTAuth::parseToken()->checkOrFail();
        } catch (TokenExpiredException $jwtTokenExpiredException) {
            return response()->json(['error' => 'Token has expired', 'is_authenticated' => false]);
        } catch (TokenInvalidException $jwtTokenInvalidException) {
            return response()->json(['error' => 'Invalid token was received', 'is_authenticated' => false]);
        } catch (JWTException $jwtException) {
            return response()->json(['error' => 'Token is not found or malformed', 'is_authenticated' => false]);
        }

        return response()->json(['is_authenticated' => true]);
    }
}
