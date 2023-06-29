<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservationsController extends Controller
{
    public function index(Request $request)
    {
        $page = 'reservations';

        return view("admin.reservations", compact('page'));
    }
}
