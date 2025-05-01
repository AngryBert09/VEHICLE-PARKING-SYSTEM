<?php

// routes/api.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;

// API Route to fetch notifications for the authenticated user
Route::middleware('auth:sanctum')->get('/notifications', [NotificationController::class, 'index']);
