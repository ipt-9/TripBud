<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/home', [CategoryController::class, 'index']);
Route::get('/register', [LoginController::class, 'register']);
Route::get('/login', [LoginController::class, 'login']);
Route::get('/why-us', [CategoryController::class, 'index']);
Route::get('/plans', [CategoryController::class, 'index']);

Route::get('/check-auth', [LoginController::class, 'checkAuth']);
Route::get('/logout', [LoginController::class, 'logout']);

Route::get('/dashboard', [CategoryController::class, 'index'])->middleware('auth:sanctum');
