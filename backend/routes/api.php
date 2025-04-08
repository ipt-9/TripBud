<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardConroller;
use App\Http\Controllers\SettingsConroller;
use App\Http\Controllers\ChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register/user', [AuthController::class, 'register']);
Route::post('/login/user', [AuthController::class, 'login']);

Route::get('/check-auth', [AuthController::class, 'checkAuth']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->get('/dashboard', [DashboardConroller::class, 'index']);

Route::middleware('auth:sanctum')->get('/settings', [SettingsConroller::class, '']);
Route::middleware('auth:sanctum')->get('/settings/cancelChanges', [SettingsConroller::class, 'cancelChanges']);
Route::middleware('auth:sanctum')->put('/settings/updateChanges', [SettingsConroller::class, 'updateChanges']);

Route::middleware('auth:sanctum')->put('/settings/account/profile', [SettingsConroller::class, '']);
Route::middleware('auth:sanctum')->put('/settings/account/profile/updateImage', [SettingsConroller::class, 'updateImage']);
Route::middleware('auth:sanctum')->delete('/settings/account/profile/deleteImage', [SettingsConroller::class, 'deleteImage']);

Route::middleware('auth:sanctum')->get('/settings/account/payment', [SettingsConroller::class, '']);
Route::middleware('auth:sanctum')->put('/settings/account/payment/editMethod', [SettingsConroller::class, 'editMethod']);
Route::middleware('auth:sanctum')->delete('/settings/account/payment/deleteMethod', [SettingsConroller::class, 'deleteMethod']);

Route::middleware('auth:sanctum')->get('/settings/plans', [SettingsConroller::class, '']);
Route::middleware('auth:sanctum')->put('/settings/plans/changePlan', [SettingsConroller::class, 'changePlan']);

Route::middleware('auth:sanctum')->get('/settings/support', [SettingsConroller::class, '']);


Route::middleware('auth:sanctum')->get('/chat', [ChatController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/messages', [ChatController::class, 'fetchMessages']);
    Route::post('/messages', [ChatController::class, 'sendMessage']);
});
