<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddTouristsController extends Controller
{
    public function index(Request $request)
    {
        $page = 'add-tourist';

        return view("admin.add-tourist", compact('page'));
    }
}
