<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReservationsController extends Controller
{
    public function index(Request $request)
    {
        $page = 'reservations';

        if($request->ajax()) {
            $reservations = Reservation::query();

            return DataTables::eloquent($reservations)->toJson();
        }

        return view("admin.reservations", compact(['page']));
    }
}
