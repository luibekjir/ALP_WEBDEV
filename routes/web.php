<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

Route::get('/', [HomeController::class, 'about']);
Route::get('/aboutus', [HomeController::class, 'about']);

Route::get('/gallery', [GalleryController::class, 'index']);
Route::get('/gallery/{gallery}', [GalleryController::class, 'show'])->name('gallery.show');
Route::post('/gallery/store', [GalleryController::class, 'store'])->name('gallery.store')->middleware('admin');

Route::get('/product', [ProductController::class, 'index']);
Route::post('/product', [ProductController::class, 'store'])->name('product.store')->middleware('admin');


Route::get('/event', [EventController::class, 'index']);
Route::post('/event', [EventController::class, 'store'])->name('event.store')->middleware('admin');

// Route::get('/', [HomeController::class, 'index'])->middleware('admin');

Route::get('/login', [UserController::class, 'login']);

Route::post('/post-login', [UserController::class, 'authLogin'])->name('login');

Route::get('/register', [UserController::class, 'register']);

Route::post('/register', [UserController::class, 'create'])->name('regist.user');

Route::get('/forgot-password', [UserController::class, 'forgotPassword']);

Route::post('/forgot-password', [UserController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('reset-password/{token}', [UserController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [UserController::class, 'reset'])->name('password.update');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'profile']);
    Route::put('/profile/{user}', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/{user}/change-password', [UserController::class, 'changePasswordForm'])->name('profile.change-password');
    
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    // Gallery comments
    Route::post('/gallery/{gallery}/comment', [GalleryController::class, 'storeComment'])->name('gallery.comment');
    Route::delete('/gallery/{comment}/delete-comment', [GalleryController::class, 'deleteComment'])->name('gallery.delete-comment');

    // Route::get('/orders/create/{product}', [OrderController::class, 'create'])->name('orders.create');
    // Route::post('/orders/{product}', [OrderController::class, 'store'])->name('orders.store');
});

Route::middleware('auth')->group(function () {

    // Tambah produk ke cart (Beli / tombol +)
    Route::post('/cart/add/{product}', [CartController::class, 'add'])
        ->name('cart.add');

    // Lihat cart
    Route::get('/cart', [CartController::class, 'index'])
        ->name('cart.index');

    // Kurangi quantity (tombol −)
    Route::patch('/cart/{cart}', [CartController::class, 'update'])
        ->name('cart.update');

    // Hapus item dari cart
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])
        ->name('cart.destroy');

});

Route::middleware('auth')->group(function () {

    // 1️⃣ Terima cart_ids dari cart (POST)
    Route::post('/checkout', [CheckoutController::class, 'prepare'])
        ->name('checkout.prepare');

    // 2️⃣ Tampilkan halaman checkout (GET)
    Route::get('/checkout', [CheckoutController::class, 'index'])
        ->name('checkout.index');

    Route::post('/checkout/confirm', [CheckoutController::class, 'store'])
        ->name('checkout.confirm');
});


Route::middleware('auth')->group(function () {
    Route::get('/orders/{order}', [OrderController::class, 'show'])
        ->name('orders.detail');
});



