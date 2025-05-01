<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VehicleCategoryController;
use App\Http\Controllers\RatesController;
use App\Http\Controllers\ParkingLotController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\NotificationController;
use App\Models\User;

Route::get('/Dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('CheckAdmin:admin,attendant');
Route::get('/dashboard-user', [DashboardController::class, 'indexUser'])->name('DashboardUser')->middleware('CheckAdmin:customer');

Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup.form');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup.submit');

// Route to display the sign-in form
Route::get('/signin', [AuthController::class, 'showSigninForm'])->name('signin.form');
Route::post('/signin', [AuthController::class, 'signin'])->name('signin.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::resource('vehicle-categories', VehicleCategoryController::class)->middleware('CheckAdmin:admin');
Route::resource('rates', RatesController::class)->middleware('CheckAdmin:admin');
Route::resource('parking-lots', ParkingLotController::class)->middleware('CheckAdmin:admin,attendant');
Route::resource('parkings', ParkingController::class)->middleware('CheckAdmin:admin,attendant');
Route::resource('users', UserController::class)->middleware('CheckAdmin:admin');
Route::resource('bookings', BookController::class)->middleware('CheckAdmin:customer');

// routes/web.php
Route::get('/notifications', [NotificationController::class, 'index']);

Route::get('/messages', [ChatController::class, 'fetchMessages']);
Route::post('/messages', [ChatController::class, 'sendMessage']);

Route::get('/CONVOS', [ChatController::class, 'index']);
