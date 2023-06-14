<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

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
Route::middleware('guest')->group(function() {
    Route::get('/', [AuthController::class, 'login'])->name('/');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginPost'])->name('login');
});

Route::middleware('auth')->group(function() {
    Route::get('/admin', fn () => redirect('/admin/dashboard'));

    Route::get('/admin/account/logout', [AuthController::class, 'logout'])->name('admin.logout');
    Route::get('/admin/{page}', [AdminController::class, 'page']);
});
