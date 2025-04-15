<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardConroller;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\SettingsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register/user', [AuthController::class, 'register']);
Route::post('/login/user', [AuthController::class, 'login']);

Route::get('/check-auth', [AuthController::class, 'checkAuth']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->get('/dashboard', [DashboardConroller::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    // Main settings endpoints
    Route::get('/settings', [SettingsController::class, 'index']);
    Route::put('/settings/updateChanges', [SettingsController::class, 'updateChanges']);
    Route::get('/settings/cancelChanges', [SettingsController::class, 'cancelChanges']);

    // Temporary image changes (not committed until save is clicked)
    Route::put('/settings/account/profile/tempUpdateImage', [SettingsController::class, 'tempUpdateImage']);
    Route::delete('/settings/account/profile/tempDeleteImage', [SettingsController::class, 'tempDeleteImage']);

    // Reference data endpoints
    Route::get('/settings/plans', [SettingsController::class, 'getPlans']);
    Route::get('/settings/support', [SettingsController::class, 'getSupport']);
});

Route::middleware('auth:sanctum')->get('/chat', [ChatController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/messages', [ChatController::class, 'fetchMessages']);
    Route::post('/messages', [ChatController::class, 'sendMessage']);
});
