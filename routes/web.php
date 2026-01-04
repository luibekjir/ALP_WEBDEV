<?php

use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\GoogleCalendarController;
use App\Http\Controllers\OrderController;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Mail;

Route::get('/', [HomeController::class, 'about']);
Route::get('/aboutus', [HomeController::class, 'about']);

Route::get('/gallery', [GalleryController::class, 'index']);
Route::get('/gallery/{gallery}', [GalleryController::class, 'show'])->name('gallery.show');
Route::post('/gallery/store', [GalleryController::class, 'store'])->name('gallery.store')->middleware('admin');

Route::get('/product', [ProductController::class, 'index'])->name('product');
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

Route::middleware(['auth', 'admin'])->group(function () {

    Route::put('/gallery/{gallery}', [GalleryController::class, 'update'])
        ->name('gallery.update');
    Route::delete('/gallery/{gallery}', [GalleryController::class, 'destroy'])
        ->name('gallery.destroy');

    Route::put('/product/{product}', [ProductController::class, 'update'])
        ->name('product.update');
    Route::delete('/product/{product}', [ProductController::class, 'destroy'])
        ->name('product.destroy');

    Route::get('/admin/orders', [AdminOrderController::class, 'index'])
        ->name('admin.orders.index');

    Route::put('/event/{event}', [EventController::class, 'update'])->name('event.update');
    Route::delete('/event/{event}', [EventController::class, 'destroy'])->name('event.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'profile']);
    Route::put('/profile/{user}', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::get('/profile/change-password', [UserController::class, 'changePasswordForm'])->name('profile.change-password');
    Route::put('/profile/{user}/update-password', [UserController::class, 'updatePassword'])->name('profile.password-update');
    Route::delete('/profile/delete-account', [UserController::class, 'destroy'])->name('profile.destroy');

    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    // Gallery comments
    Route::post('/gallery/{gallery}/comment', [GalleryController::class, 'storeComment'])->name('gallery.comment');
    Route::delete('/gallery/{comment}/delete-comment', [GalleryController::class, 'deleteComment'])->name('gallery.delete-comment');

    // Route::get('/orders/create/{product}', [OrderController::class, 'create'])->name('orders.create');
    // Route::post('/orders/{product}', [OrderController::class, 'store'])->name('orders.store');

    // Route::get('/google/connect', [GoogleCalendarController::class, 'redirect'])
    //     ->name('google.redirect');

    // Route::get('/google/callback', [GoogleCalendarController::class, 'callback'])
    //     ->name('google.callback');

    Route::post('/event/{event}/register', [EventController::class, 'addToCalendar'])
    ->name('event.register');
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

    Route::post('/checkout/prepare', [OrderController::class, 'prepare'])
        ->name('checkout.prepare');
    Route::get('/checkout', [OrderController::class, 'index'])
        ->name('checkout.index');

    // BUY NOW
    Route::get('/checkout/buy-now/{product}', [ProductController::class, 'buyNow'])
        ->name('checkout.buy-now');

    Route::post('/checkout/buy-now/create-order/{product}', [OrderController::class, 'create'])
        ->name('create.order.buy-now');


    // FINAL SUBMIT
    Route::post('/checkout/confirm', [OrderController::class, 'store'])
        ->name('checkout.confirm');


    Route::get('/show-payment/{order}', function (Order $order) {
        return view('show-payment', compact('order'));
    })->name('show-payment');
    Route::post('/payment/cancel/{order}', [OrderController::class, 'cancel'])
        ->name('payment.cancel');
    Route::post('/payment/success/{order}', [OrderController::class, 'success'])
        ->name('payment.success');
});

Route::middleware('auth')->group(function () {
    Route::get('/orders/{order}', [OrderController::class, 'detail'])
        ->name('orders.detail');

});

Route::get('/test-email', function () {
    Mail::raw('EMAIL TEST DARI LARAVEL', function ($message) {
        $message->to('lnathaniel@student.ciputra.ac.id')
                ->subject('Test Email Laravel');
    });

    return 'EMAIL TERKIRIM (cek inbox / spam)';
});
