<?php

namespace App\Http\Controllers\Tourist;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tourist\CancelOrUpdateReservationRequest;
use App\Http\Requests\Tourist\CreateReservationRequest;
use App\Models\Tourist\AvailableReservation;
use App\Models\TouristReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index()
    {
        $page = 'reservations';

        $kubos = AvailableReservation::where('type', '=', 'kubo')->get();
        $cottages = AvailableReservation::where('type', '=', 'cottage')->get();

        return view('tourist.reservations', compact('page', 'kubos', 'cottages'));
    }

    public function create(CreateReservationRequest $request)
    {
        $request->validated();

        $data = $request->safe()->all();

        $existingReservationDate = TouristReservation::where('reserve_date', '=', $data['reserve_date'])
            ->where('arrival_time', '=', $data['arrival_time'])
            ->where('reservation_id', '=', $data['reservation_id'])
            ->get();

        if(!$existingReservationDate->isEmpty()) {
            return back()->with('error', 'Another tourist has already reserved this spot on this date and time, please choose another date.');
        }

        $data['user_id'] = Auth::guard('tourist')->id();
        TouristReservation::create([
            ...$data
        ]);

        return back()->with('success', 'Reservation has been created successfully! You can check it in your reservations list.');
    }

    public function update(CancelOrUpdateReservationRequest $request)
    {
        $request->validated();

        $sentRequest = $request->safe()->all();

        switch($sentRequest['action']) {
            case 'cancel_reservation':
                $reservation = TouristReservation::find($request['tourist_reservation_id']);

                if(!$reservation->get()->isEmpty()) {
                    $reservation->delete();

                    return back()->with('success', 'Successfully cancelled you reservation!');
                } else {
                    return back()->with('error', 'Cannot the reservation that you want to cancel.');
                }
                break;

            case 'update_reservation':
                $reservation = TouristReservation::find($request['tourist_reservation_id']);

                if(!$reservation->get()->isEmpty()) {
                    $reservation->update([
                        'number_of_adults' => $sentRequest['number_of_adults'],
                        'number_of_children' => $sentRequest['number_of_children'],
                        'reserve_date' => $sentRequest['reserve_date'],
                        'arrival_time' => $sentRequest['arrival_time'],
                        'phone_number' => $sentRequest['phone_number']
                    ]);

                    return back()->with('success', 'Successfully updated your reservation!');
                } else {
                    return back()->with('error', 'Cannot find the reservation that you want to update.');
                }
                break;
        }
    }
}
