<?php

namespace App\Http\Controllers;

use App\Models\TouristsToGuide;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TourGuidesController extends Controller
{
    public function index(Request $request)
    {
        $page = 'tour-guides';

        if($request->ajax()) {
            $touristsToGuide = TouristsToGuide::query();

            return DataTables::eloquent($touristsToGuide)->toJson();
        }

        return view("admin.tour-guides", compact('page'));
    }
}
