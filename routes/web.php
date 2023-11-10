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
use App\Http\Controllers\Tourist\HomeController;
use App\Http\Controllers\Tourist\LoginController;
use App\Http\Controllers\Tourist\MyReservationsController;
use App\Http\Controllers\Tourist\RatingsAndReviewsController;
use App\Http\Controllers\Tourist\RegisterController;
use App\Http\Controllers\Tourist\ReservationController;

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
Route::middleware('web')->prefix('admin')->controller(AuthController::class)->group(function() {
    Route::get('/', 'login')->name('/');
    Route::get('/login', 'login')->name('login');

    Route::post('/login', 'loginPost')->name('login');
});

Route::middleware('auth')->prefix('admin')->group(function() {
    Route::get('/account/logout', [AuthController::class, 'logout'])->name('admin.logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/dashboard/reminders/add', [DashboardController::class, 'addReminder'])->name('admin.add-reminder');

    Route::get('/reservations', [ReservationsController::class, 'index'])->name('admin.reservations');
    Route::post('/reservations/add', [ReservationsController::class, 'addReservation'])->name('admin.add-reservation');

    Route::get('/registered-tourists', [RegisteredTouristsController::class, 'index'])->name('admin.registered-tourists');
    Route::get('/add-tourist', [AddTouristsController::class, 'index'])->name('admin.add-tourist');
    Route::post('/add-tourist/store', [AddTouristsController::class, 'store'])->name('admin.add-tourist.store');

    Route::get('/tour-guides', [TourGuidesController::class, 'index'])->name('admin.tour-guides');
    Route::get('/assign-tour-guide', [AssignTourGuidesController::class, 'index'])->name('admin.assign-tour-guide');
    Route::post('/assign-tour-guide/store', [AssignTourGuidesController::class, 'store'])->name('admin.assign-tour-guide.store');

    Route::get('/tracking', [MapTrackingController::class, 'index'])->name('admin.map-tracking');

    Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile');
    Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('admin.profile.update');
});

Route::middleware('web')->group(function() {
    Route::get('/', [HomeController::class, 'index'])->name('tourist.home');
    Route::get('/home', [HomeController::class, 'index'])->name('tourist.home');

    Route::middleware('guest:tourist')->get('/login', [LoginController::class, 'index'])->name('tourist.login');
    Route::middleware('guest:tourist')->post('/account/login', [LoginController::class, 'login'])->name('tourist.login.post');

    Route::middleware('guest:tourist')->get('/register', [RegisterController::class, 'index'])->name('tourist.register');
    Route::middleware('guest:tourist')->post('/account/register', [RegisterController::class, 'register'])->name('tourist.register.post');

    Route::middleware(['auth:tourist'])->get('/my_reservations', [MyReservationsController::class, 'index'])->name('tourist.my_reservations');
    Route::middleware(['auth:tourist'])->get('/my_account', function (Request $request) {})->name('tourist.my_account');
    Route::middleware(['auth:tourist'])->get('/account/logout', [LoginController::class, 'logout'])->name('tourist.logout');

    Route::get('/reservation', [ReservationController::class, 'index'])->name('tourist.reservation');
    Route::middleware(['auth:tourist'])->post('/reservation/create', [ReservationController::class, 'create'])->name('tourist.reservation.create');
    Route::middleware(['auth:tourist'])->post('/reservation/update', [ReservationController::class, 'update'])->name('tourist.reservation.update');

    Route::get('/tourist_attractions', function() {})->name('tourist.tourist_attractions');
    Route::get('/about_us', function() {})->name('tourist.about_us');
    Route::get('/ratings_and_reviews', [RatingsAndReviewsController::class, 'index'])->name('tourist.ratings_and_reviews');
});
