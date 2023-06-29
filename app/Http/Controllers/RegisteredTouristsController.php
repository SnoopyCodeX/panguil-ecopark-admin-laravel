<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisteredTouristsController extends Controller
{
    public function index(Request $request)
    {
        $page = 'registered-tourists';

        return view("admin.registered-tourists", compact('page'));
    }
}
