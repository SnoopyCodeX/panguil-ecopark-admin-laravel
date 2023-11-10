<?php

namespace App\Http\Controllers\Tourist;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Tourist\LoginRequest;
use App\Http\Requests\Auth\UserLogoutRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        $page = 'login';

        return view('tourist.login', compact('page'));
    }

    public function login(LoginRequest $request)
    {
        $request->validated();

        $credentials = $request->safe()->all();

        // Check if the user's account is locked due to rate limiting
        if ($this->hasTooManyLoginAttempts($request)) {
            return back()->with('error', 'Too many login attempts, try again later after 5 minutes.')->withInput();
        }

        if(Auth::guard('tourist')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/home');
        }

        // Authentication failed, increment the rate limiter
        $this->incrementLoginAttempts($request);

        return back()->with('error', 'Failed to login, email or password is incorrect!')->withInput();
    }

    public function logout(UserLogoutRequest $request)
    {
        Auth::logout();
        Auth::guard('tourist')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
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
