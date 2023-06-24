<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssignTourGuidesController extends Controller
{
    /**
     * The name of the .blade.php
     * file to be rendered
     */
    protected string $view = 'assign-tour-guide';

    public function show(Request $request)
    {
        $page = $this->view;

        return view("admin.$page", compact('page'));
    }
}
