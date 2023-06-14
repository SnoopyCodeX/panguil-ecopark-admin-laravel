<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:api')->group(function() {
    Route::get('/user', function(Request $request) {
        if(!auth()->check())
            return response()->json(['message' => 'Invalid authorization token provided!']);

        return response()->json(['sender' => $request->user()]);
    });

    Route::get('/admin/dashboard/quicksummaries', [DashboardController::class, 'quickSummaries']);
});
