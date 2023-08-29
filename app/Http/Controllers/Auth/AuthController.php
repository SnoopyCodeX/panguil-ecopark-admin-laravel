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
use Illuminate\Support\Str;
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

        // Check if the user's account is locked due to rate limiting
        if ($this->hasTooManyLoginAttempts($loginRequest)) {
            return back()->with('error', 'Too many login attempts, try again later after 5 minutes.')->withInput();
        }

        if(Auth::attempt($credentials, $remember == 'on')) {
            $loginRequest->session()->regenerate();
            return redirect('/admin/dashboard')->with('success', $loginRequest->all());
        }

        // Authentication failed, increment the rate limiter
        $this->incrementLoginAttempts($loginRequest);

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

        // Check if the user's account is locked due to rate limiting
        if ($this->hasTooManyLoginAttempts($loginRequest)) {
            return response()->json([
                'hasError' => true,
                'message' => 'Too many login attempts, try again later after 5 minutes.'
            ], 429);
        }

        try {
            // Attempt to login the user using the credentials sent.
            // If the user wants to remember its session, set the
            // generated token's expiration date to 30 days. Otherwise,
            // just set to 1 day.

            if(!$token = JWTAuth::attempt($credentials, ['exp' => \Carbon\Carbon::now()->addDays($remember == 'on' ? 30 : 1)->timestamp])) {
                $user = User::where('email', $credentials['email'])->first();

                // Authentication failed, increment the rate limiter
                $this->incrementLoginAttempts($loginRequest);

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

    protected function hasTooManyLoginAttempts(Request $request): bool
    {
        return $this->limiter()->tooManyAttempts(
            $this->throttleKey($request),
            $this->maxLoginAttempts()
        );
    }

    protected function incrementLoginAttempts(Request $request): void
    {
        $this->limiter()->hit(
            $this->throttleKey($request),
            $this->lockoutTime()
        );
    }

    protected function throttleKey(Request $request): string
    {
        return Str::lower($request->input('email')) . '|' . $request->ip();
    }

    protected function maxLoginAttempts(): int
    {
        return 3; // Adjust as needed
    }

    protected function lockoutTime(): int
    {
        return 60 * 5; // Time in minutes to lockout after too many attempts
    }

    protected function limiter() : \Illuminate\Cache\RateLimiter
    {
        return app(\Illuminate\Cache\RateLimiter::class);
    }
}
