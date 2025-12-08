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
Route::post('/gallery', [GalleryController::class, 'store']) ->name('gallery.store');

Route::get('/product', [ProductController::class, 'index']);
Route::post('/product', [ProductController::class, 'store'])->name('product.store');


Route::get('/event', [EventController::class, 'index']);
Route::post('/event', [EventController::class, 'store'])->name('event.store');

// Route::get('/', [HomeController::class, 'index'])->middleware('admin');

Route::get('/login', [UserController::class, 'login']);
