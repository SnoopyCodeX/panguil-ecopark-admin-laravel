<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function page(Request $request)
    {
        $page = $request->route('page') ?? 'dashboard';

        if (!view()->exists("admin.$page")) {
            return view('error.404');
        }

        return view("admin.$page", compact('page'));
    }
}

