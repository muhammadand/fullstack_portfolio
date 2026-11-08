<?php

use App\Http\Controllers\TopupController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Top Up Game Routes (Public)
|--------------------------------------------------------------------------
|
| Landing page top up untuk customer (kategori Games + daftar brand).
| URL dibuat berbasis keyword pencarian ("top up game") agar mudah
| ditemukan di mesin pencari.
|
*/

Route::get('/top-up-game', [TopupController::class, 'index'])->name('topup.index');

Route::get('/top-up-game/{slug}', [TopupController::class, 'show'])
    ->where('slug', '[a-z0-9-]+')
    ->name('topup.show');

Route::post('/top-up-game/{slug}/checkout', [TopupController::class, 'checkout'])
    ->where('slug', '[a-z0-9-]+')
    ->middleware('throttle:20,1')
    ->name('topup.checkout');

Route::get('/top-up-game/pesanan/{orderNo}/status', [TopupController::class, 'status'])
    ->where('orderNo', 'TP-[A-Z0-9-]+')
    ->middleware('throttle:90,1')
    ->name('topup.order.status');

// Redirect 301 dari URL lama agar SEO tidak hilang
Route::redirect('/top-up', '/top-up-game', 301);

/*
|--------------------------------------------------------------------------
| Akun Customer (guard "customer")
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\CustomerAuthController;

Route::middleware('guest:customer')->group(function () {
    Route::get('/masuk', [CustomerAuthController::class, 'showLoginForm'])->name('customer.login');
    Route::post('/masuk', [CustomerAuthController::class, 'login'])->name('customer.login.post')->middleware('throttle:10,1');
    Route::get('/daftar', [CustomerAuthController::class, 'showRegisterForm'])->name('customer.register');
    Route::post('/daftar', [CustomerAuthController::class, 'register'])->name('customer.register.post')->middleware('throttle:10,1');
});

Route::middleware('auth:customer')->group(function () {
    Route::get('/akun', [\App\Http\Controllers\CustomerAccountController::class, 'account'])->name('customer.account');
    Route::get('/akun/tarik', [\App\Http\Controllers\CustomerAccountController::class, 'withdrawForm'])->name('customer.withdraw');
    Route::post('/akun/tarik', [\App\Http\Controllers\CustomerAccountController::class, 'storeWithdrawal'])->name('customer.withdraw.store')->middleware('throttle:5,1');
});
Route::post('/keluar', [CustomerAuthController::class, 'logout'])->name('customer.logout')->middleware('auth:customer');
