<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddReservationRequest;
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
