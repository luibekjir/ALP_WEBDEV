<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\EventController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/aboutus', [HomeController::class, 'about']);

Route::get('/gallery', [GalleryController::class, 'index']);
Route::post('/gallery', [GalleryController::class, 'store']) ->name('gallery.store');

Route::get('/product', [ProductController::class, 'index']);
Route::post('/product', [ProductController::class, 'store'])->name('product.store');


Route::get('/event', [EventController::class, 'index']);
Route::post('/event', [EventController::class, 'store'])->name('event.store');

// Route::get('/', [HomeController::class, 'index'])->middleware('admin');

Route::get('/login', [UserController::class, 'login']);

Route::post('/login', [UserController::class, 'authLogin'])->name('login');

Route::get('/register', [UserController::class, 'register']);

Route::post('/register', [UserController::class, 'create'])->name('regist.user');

Route::get('/forgot-password', [UserController::class, 'forgotPassword']);

Route::post('/forgot-password', [UserController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('reset-password/{token}', [UserController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [UserController::class, 'reset'])->name('password.update');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'profile']);
    Route::get('/profile/{user}', [UserController::class, 'showProfile'])->name('profile.show');
    Route::get('/profile/{user}/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/{user}', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::get('/profile/{user}/change-password', [UserController::class, 'changePasswordForm'])->name('profile.change-password');
    Route::post('/profile/{user}/change-password', [UserController::class, 'updatePassword'])->name('profile.update-password');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
});


