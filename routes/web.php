<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;

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
    Route::get('/{page}', [AdminController::class, 'showPage']);
});
