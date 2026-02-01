<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Menu routes
Route::get('/menu', [MenuController::class, 'index'])->name('menu');

// Cart routes
Route::get('/keranjang', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');

// Order flow routes (NEW)
Route::post('/proceed-to-confirmation', [CartController::class, 'proceedToConfirmation'])->name('proceed.confirmation');
Route::get('/konfirmasi-pesanan', [CartController::class, 'confirmation'])->name('order.confirmation');
Route::post('/proceed-to-payment', [CartController::class, 'proceedToPayment'])->name('proceed.payment');
Route::get('/detail-pembayaran', [CartController::class, 'paymentDetail'])->name('payment.detail');
Route::post('/process-payment', [CartController::class, 'processPayment'])->name('process.payment');

// Other routes
Route::get('/tentang-kami', function () {
    return view('about');
})->name('about');

Route::get('/kontak', function () {
    return view('contact');
})->name('contact');

Route::get('/pesan', function () {
    return redirect()->route('menu');
})->name('order');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Login routes (guest only)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [App\Http\Controllers\Admin\AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('login.post');
    });

    // Protected admin routes
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');
        
        // Menu management (CRUD)
        Route::get('/menu', [App\Http\Controllers\Admin\MenuController::class, 'index'])->name('menu');
        Route::get('/menu/create', [App\Http\Controllers\Admin\MenuController::class, 'create'])->name('menu.create');
        Route::post('/menu', [App\Http\Controllers\Admin\MenuController::class, 'store'])->name('menu.store');
        Route::get('/menu/{id}/edit', [App\Http\Controllers\Admin\MenuController::class, 'edit'])->name('menu.edit');
        Route::put('/menu/{id}', [App\Http\Controllers\Admin\MenuController::class, 'update'])->name('menu.update');
        Route::delete('/menu/{id}', [App\Http\Controllers\Admin\MenuController::class, 'destroy'])->name('menu.destroy');
        Route::post('/menu/{id}/toggle', [App\Http\Controllers\Admin\MenuController::class, 'toggleAvailability'])->name('menu.toggle');
        
        // Orders management
        Route::get('/orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders');
        Route::get('/orders/history', [App\Http\Controllers\Admin\OrderController::class, 'history'])->name('orders.history');
        Route::get('/orders/{id}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{id}/confirm', [App\Http\Controllers\Admin\OrderController::class, 'confirm'])->name('orders.confirm');
        Route::post('/orders/{id}/complete', [App\Http\Controllers\Admin\OrderController::class, 'complete'])->name('orders.complete');
        Route::post('/orders/{id}/cancel', [App\Http\Controllers\Admin\OrderController::class, 'cancel'])->name('orders.cancel');
        Route::delete('/orders/{id}', [App\Http\Controllers\Admin\OrderController::class, 'destroy'])->name('orders.destroy');
    });
});

