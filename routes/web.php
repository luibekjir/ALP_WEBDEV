<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);

Route::get('/about', [HomeController::class, 'about']);

// Route::get('/', [HomeController::class, 'index'])->middleware('admin');

Route::get('/login', [UserController::class, 'login']);

Route::get('/register', [UserController::class, 'register']);

Route::get('/forgot-password', [UserController::class, 'forgotPassword']);
