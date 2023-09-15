<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SaveGeofenceRequest;
use App\Http\Requests\Api\UpdateGeofenceRequest;
use App\Models\Geofence;
use Illuminate\Http\Request;

class GeofenceController extends Controller
{
    public function getGeofences(Request $request)
    {
        return Geofence::all();
    }

    public function saveGeofence(SaveGeofenceRequest $request)
    {
        $validated = $request->validated();

        Geofence::create([
            'geojson' => $validated['geojson']
        ]);

        return response()->json(['hasError' => false, 'message' => 'GeoJSON has been saved successfully!']);
    }

    public function updateGeofence(UpdateGeofenceRequest $request, int $id)
    {
        $geofence = Geofence::find($id);

        if(!$geofence)
            return response()->json(['hasError' => true, 'message' => 'GeoJSON does not exist in the database']);

        $validated = $request->validated();

        Geofence::where('id', $id)->update([
            'geojson' => $validated['geojson']
        ]);

        return response()->json([
            'hasError' => false,
            'message' => 'GeoJSON has been updated successfully'
        ]);
    }

    public function deleteGeofence(Request $request, int $id)
    {
        $geofence = Geofence::find($id);

        if(!$geofence)
            return response()->json(['hasError' => true, 'message' => 'GeoJSON does not exist in the database']);

        $geofence->delete();

        return response()->json([
            'hasError' => false,
            'message' => 'GeoJSON has been deleted successfully'
        ]);
    }
}
