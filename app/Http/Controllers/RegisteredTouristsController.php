<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisteredTouristsController extends Controller
{
    /**
     * The name of the .blade.php
     * file to be rendered
     */
    protected string $view = 'registered-tourists';

    public function show(Request $request)
    {
        $page = $this->view;

        return view("admin.$page", compact('page'));
    }
}