<?php

use App\Http\Controllers\AddTouristsController;
use App\Http\Controllers\AssignTourGuidesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MapTrackingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisteredTouristsController;
use App\Http\Controllers\ReservationsController;
use App\Http\Controllers\TourGuidesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::middleware('guest')->controller(AuthController::class)->group(function() {
    Route::get('/', 'login')->name('/');
    Route::get('/login', 'login')->name('login');

    Route::post('/login', 'loginPost')->name('login');
});

Route::middleware('auth')->prefix('admin')->group(function() {
    Route::get('/', fn () => redirect('/admin/dashboard'));

    Route::get('/account/logout', [AuthController::class, 'logout'])->name('admin.logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/reservations', [ReservationsController::class, 'index'])->name('admin.reservations');

    Route::get('/registered-tourists', [RegisteredTouristsController::class, 'index'])->name('admin.registered-tourists');
    Route::get('/add-tourist', [AddTouristsController::class, 'index'])->name('admin.add-tourist');

    Route::get('/tour-guides', [TourGuidesController::class, 'index'])->name('admin.tour-guides');
    Route::get('/assign-tour-guide', [AssignTourGuidesController::class, 'index'])->name('admin.assign-tour-guide');

    Route::get('/tracking', [MapTrackingController::class, 'index'])->name('admin.map-tracking');

    Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile');
    Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('admin.profile.update');
});
