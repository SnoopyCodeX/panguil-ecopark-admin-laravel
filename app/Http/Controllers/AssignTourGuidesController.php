<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignTourGuideRequest;
use App\Models\TouristsToGuide;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AssignTourGuidesController extends Controller
{
    public function index(Request $request)
    {
        $page = 'assign-tour-guide';

        return view("admin.assign-tour-guide", compact('page'));
    }

    public function store(AssignTourGuideRequest $request)
    {
        $validated = $request->validated();

        $safeData = $request->safe()->all();
        $touristToGuide = new TouristsToGuide();
        $touristToGuide->tour_guide_name = $safeData['tour_guide_name'];
        $touristToGuide->assigned_datetime = Carbon::parse(Str::replaceFirst('/', '', $safeData['assigned_datetime']))->format('Y-m-d h:i:s');
        $touristToGuide->tourist_name = $safeData['tourist_name'];
        $touristToGuide->age = intval($safeData['age']);
        $touristToGuide->gender = $safeData['gender'];
        $touristToGuide->contact_number = $safeData['cellphone_number'];

        $touristToGuide->save();

        return redirect()->back()->with('success', 'Added new tourist to guide successfully!');
    }
}
