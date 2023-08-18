<?php

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

Route::middleware(['jwt.auth', 'jwt.not_revoked'])->prefix('user')->group(function() {
    Route::post('logout', [AuthController::class, 'apiLogout']);


});
