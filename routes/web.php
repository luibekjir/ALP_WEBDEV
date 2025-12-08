<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\EventController;

Route::get('/', [HomeController::class, 'index']);

Route::get('/about', [HomeController::class, 'about']);

Route::get('/gallery', [GalleryController::class, 'index']);
Route::get('/gallery/create', [GalleryController::class, 'create']);
Route::post('/gallery', [GalleryController::class, 'store']);
Route::get('/gallery/{gallery}', [GalleryController::class, 'show']);
Route::get('/gallery/{gallery}/edit', [GalleryController::class, 'edit']);
Route::put('/gallery/{gallery}', [GalleryController::class, 'update']);
Route::delete('/gallery/{gallery}', [GalleryController::class, 'destroy']);



Route::get('/event', [EventController::class, 'index']);

// Route::get('/', [HomeController::class, 'index'])->middleware('admin');

Route::get('/login', [UserController::class, 'login']);
