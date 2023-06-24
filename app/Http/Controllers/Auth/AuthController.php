<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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

    public function loginPost(Request $request)
    {
        $remember = $request->remember_me == "on" ?: false;
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect('/admin/dashboard')->with('success', $request->all());
        }

        return back()->with('error', 'Failed to login, email or password is incorrect!')->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        Auth::forgetUser();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('/');
    }
}
