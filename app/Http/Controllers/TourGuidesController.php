<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TourGuidesController extends Controller
{
    public function index(Request $request)
    {
        $page = 'tour-guides';

        return view("admin.tour-guides", compact('page'));
    }
}
