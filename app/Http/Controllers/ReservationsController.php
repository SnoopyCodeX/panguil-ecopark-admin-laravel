<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddReservationRequest;
use App\Models\Reservation;
use App\Models\TouristReservation;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReservationsController extends Controller
{
    public function index(Request $request)
    {
        $page = 'reservations';

        // if($request->ajax()) {
        //     $reservations = Reservation::query();

        //     return DataTables::eloquent($reservations)->toJson();
        // }

        $reservations = TouristReservation::with(['reservationType', 'user'])->get();
        $reservations = $reservations->map(function($reservation) {
            return [
                'id' => $reservation->id,
                'reservation_type' => [
                    'id' => $reservation->reservationType->id,
                    ...$reservation->reservationType->toArray()
                ],
                'user' => [
                    'id' => $reservation->user->id,
                    ...$reservation->user->toArray()
                ],
                ...$reservation->toArray()
            ];
        });

        return view("admin.reservations", compact('page', 'reservations'));
    }

    public function addReservation(AddReservationRequest $request)
    {
        $validated = $request->validated();

        Reservation::create([
            'name' => $validated['name'],
            'gender' => $validated['gender'],
            'age' => $validated['age'],
            'contact_number' => $validated['contact_number'],
            'number_of_tourists' => $validated['number_of_tourist'],
            'assigned_tour_guide' => $validated['tour_guide_name'],
        ]);

        return redirect()->back()->with('success', 'Reservation added successfully!');
    }
}
