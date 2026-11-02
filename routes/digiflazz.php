<?php

use App\Http\Controllers\ProdukDigital\DigiflazzController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Digiflazz API Routes
|--------------------------------------------------------------------------
|
| Rute khusus modul integrasi API Digiflazz (PPOB, Cek Saldo, Topup, Webhook).
| Terdaftar via routes/api.php dengan prefix /api/digiflazz.
|
*/

Route::prefix('digiflazz')->name('digiflazz.')->group(function () {
    Route::match(['get', 'post'], '/cek-saldo', [DigiflazzController::class, 'checkBalance'])->name('cek_saldo');
    Route::post('/price-list', [DigiflazzController::class, 'getPrice'])->name('price_list');
    Route::post('/deposit', [DigiflazzController::class, 'deposit'])->name('deposit');
});
