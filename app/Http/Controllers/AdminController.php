<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showPage(Request $request)
    {
        $page = $request->route('page') ?? 'dashboard';

        $controllers = [
            'dashboard' => DashboardController::class,
            'profile' => ProfileController::class,
            'reservations' => ReservationsController::class,
            'registered-tourists' => RegisteredTouristsController::class,
            'add-tourist' => AddTouristsController::class,
            'tour-guides' => TourGuidesController::class,
            'assign-tour-guide' => AssignTourGuidesController::class,
            'tracking' => MapTrackingController::class
        ];

        if (!isset($controllers[$page])) {
            return view('error.404');
        }

        return app($controllers[$page])->show($request);
    }
}

