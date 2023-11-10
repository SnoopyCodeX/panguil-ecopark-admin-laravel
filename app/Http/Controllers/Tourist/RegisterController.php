<?php

namespace App\Http\Controllers\Tourist;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Tourist\RegisterRequest;
use App\Models\Tourist;
use Hash;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        $page = 'register';

        return view('tourist.register', compact('page'));
    }

    public function register(RegisterRequest $request)
    {
        $request->validated();

        $credentials = $request->safe()->all();
        $credentials['name'] = $credentials['first_name'] . " " . $credentials['last_name'];
        $credentials['password'] = Hash::make($credentials['password']);

        $tourist = Tourist::create([
            ...$credentials
        ]);

        return back()->with('success', 'Account has been successfully registered!');
    }
}
