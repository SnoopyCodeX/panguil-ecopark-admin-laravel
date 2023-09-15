<?php

use App\Http\Controllers\api\GeofenceController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\Auth\AuthController;
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

Route::post('login', [AuthController::class, 'apiLogin']);
Route::post('register', [AuthController::class, 'apiRegister']);
Route::get('check-authentication', [AuthController::class, 'apiCheckAuthentication']);

Route::prefix('system-admin')->group(function() {
    Route::get('geofences', [GeofenceController::class, 'getGeofences'])->name('system-admin.geofences');
    Route::post('geofences/save', [GeofenceController::class, 'saveGeofence'])->name('system-admin.geofences.save');
    Route::post('geofences/{id}/update', [GeofenceController::class, 'updateGeofence'])->name('system-admin.geofences.update');
    Route::post('geofences/{id}/delete', [GeofenceController::class, 'deleteGeofence'])->name('system-admin.geofences.delete');
});

Route::middleware(['jwt.auth', 'jwt.not_revoked'])->prefix('system-client')->group(function() {
    Route::get('geofences', [GeofenceController::class, 'getGeofences']);
});

Route::middleware(['jwt.auth', 'jwt.not_revoked'])->prefix('user')->group(function() {
    Route::post('logout', [AuthController::class, 'apiLogout']);

    Route::get('{id}/contacts', [UserController::class, 'getContacts']);
    Route::post('{id}/contacts/add', [UserController::class, 'addNewContact']);
    Route::post('{id}/contacts/{contactId}/update', [UserController::class, 'updateContact']);
    Route::post('{id}/contacts/send-custom-message', [UserController::class, 'sendCustomMessage']);
});
