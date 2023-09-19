<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SaveOrUpdateTouristLocationRequest;
use App\Models\TouristLocation;
use App\Models\User;
use Illuminate\Http\Request;

class TouristLocationController extends Controller
{
    public function getTouristLocation(Request $request, int $id) {
        $touristLocation = TouristLocation::find($id);

        if($touristLocation)
            return response()->json([
                'hasError' => false,
                'tourist_location' => $touristLocation
            ]);

        return response()->json([
            'hasError' => true,
            'message' => 'No recorded tourist location found for this user'
        ]);
    }

    public function saveOrUpdateTouristLocation(SaveOrUpdateTouristLocationRequest $request, int $id) {
        $user = User::find($id);

        if($user) {
            $validated = $request->validated();

            TouristLocation::updateOrCreate(
                ['user_id' => $validated['user_id']],
                [
                    'latitude' => $validated['latitude'],
                    'longitude' => $validated['longitude'],
                    'status' => $validated['status']
                ],
            );

            return response()->json([
                'hasError' => false,
                'message' => 'Tourist location has been saved successfully'
            ]);
        }

        return response()->json([
            'hasError' => true,
            'message' => 'Tourist with that id was not found in the database'
        ]);
    }
}
