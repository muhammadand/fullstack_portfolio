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

// Redirect 301 dari URL lama agar SEO tidak hilang
Route::redirect('/top-up', '/top-up-game', 301);
