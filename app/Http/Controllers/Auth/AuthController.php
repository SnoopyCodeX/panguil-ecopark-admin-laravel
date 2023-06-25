<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserLogoutRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /* public function registerPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Registered successfully!');
    } */

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
}
