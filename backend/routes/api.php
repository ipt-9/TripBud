<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardConroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/home', [CategoryController::class, 'index']);
//Route::get('/why-us', [CategoryController::class, 'index']);
//Route::get('/plans', [CategoryController::class, 'index']);
//Route::get('/register', [CategoryController::class, 'index']);
//Route::get('/login', [CategoryController::class, 'index']);


Route::post('/register/user', [AuthController::class, 'register']);
Route::post('/login/user', [AuthController::class, 'login']);

Route::get('/check-auth', [AuthController::class, 'checkAuth']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->get('/dashboard', [DashboardConroller::class, 'index']);
