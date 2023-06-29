<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapTrackingController extends Controller
{
    public function index(Request $request)
    {
        $page = 'tracking';

        return view("admin.tracking", compact('page'));
    }
}
