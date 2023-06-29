<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssignTourGuidesController extends Controller
{
    public function index(Request $request)
    {
        $page = 'assign-tour-guide';

        return view("admin.assign-tour-guide", compact('page'));
    }
}
