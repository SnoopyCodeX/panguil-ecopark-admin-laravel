<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RegisteredTouristsController extends Controller
{
    public function index(Request $request)
    {
        $page = 'registered-tourists';

        if($request->ajax()) {
            $registeredTourists = User::query()->where('type', 'tourist');

            return DataTables::eloquent($registeredTourists)->toJson();
        }

        return view("admin.registered-tourists", compact('page'));
    }
}
