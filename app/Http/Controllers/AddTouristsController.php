<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddNewTouristRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AddTouristsController extends Controller
{
    public function index(Request $request)
    {
        $page = 'add-tourist';

        return view("admin.add-tourist", compact('page'));
    }

    public function store(AddNewTouristRequest $request)
    {
        $validated = $request->validated();

        $touristName = $request->safe()->only(['tourist_name'])['tourist_name'];
        $gender = $request->safe()->only(['gender'])['gender'];
        $age = $request->safe()->only(['age'])['age'];
        $cellphoneNumber = $request->safe()->only(['cellphone_number'])['cellphone_number'];
        $assignDatetime = $request->safe()->only(['assign_datetime'])['assign_datetime'];

        $user = new User();
        $user->name = $touristName;
        $user->email = '_';
        $user->password = '_';
        $user->gender = $gender;
        $user->age = $age;
        $user->cellphone_number = $cellphoneNumber;
        $user->assign_datetime = Carbon::parse(Str::replaceFirst('/', '', $assignDatetime))->format('Y-m-d h:i:s');
        $user->type = 'tourist';
        $user->save();

        return redirect()->back()->with('success', 'Added new tourist successfully!');
    }
}
