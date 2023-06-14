<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function quickSummaries(Request $request)
    {
        if(!auth()->check())
            return response()->json(['message' => 'Invalid authorization token provided!']);

        $totalRegisteredTouristsCount = $this->__countRegisteredTourists();

        return response()->json(['total_registered_tourists' => $totalRegisteredTouristsCount]);
    }

    public function __countRegisteredTourists() : int
    {
        $totaRegisteredTourists = 0;
        $chunkSize = 1000;

        do {
            $count = User::where('type', 'tourist')
                        ->select('id')
                        ->orderBy('id')
                        ->offset($totaRegisteredTourists)
                        ->limit($chunkSize)
                        ->count();

            $totaRegisteredTourists += $count;
        } while($count > 0);

        return $totaRegisteredTourists;
    }
}
