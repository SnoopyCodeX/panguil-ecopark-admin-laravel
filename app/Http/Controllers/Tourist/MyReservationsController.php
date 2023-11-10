<?php

namespace App\Http\Controllers\Tourist;

use App\Http\Controllers\Controller;
use App\Models\TouristReservation;
use Auth;
use Illuminate\Http\Request;

class MyReservationsController extends Controller
{
    public function index()
    {
        $page = 'my_reservations';

        $myReservationsQueryResult = TouristReservation::where('user_id', '=', Auth::guard('tourist')->id())->with('reservationType')->get();
        $myReservations = $myReservationsQueryResult->map(function($reservation) {
            return [
                'id' => $reservation->id,
                'reservation_type' => $reservation->reservationType,
                ...$reservation->toArray()
            ];
        });

        return view('tourist.my_reservations', compact('page', 'myReservations'));
    }
}
