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
    // Endpoint internal: wajib header X-Internal-Token (DIGIFLAZZ_INTERNAL_TOKEN). Tanpa token = 401.
    Route::middleware([\App\Http\Middleware\DigiflazzInternalToken::class, 'throttle:30,1'])->group(function () {
        Route::match(['get', 'post'], '/cek-saldo', [DigiflazzController::class, 'checkBalance'])->name('cek_saldo');
        Route::post('/price-list', [DigiflazzController::class, 'getPrice'])->name('price_list');
        Route::post('/deposit', [DigiflazzController::class, 'deposit'])->name('deposit');
        Route::post('/transaction', [DigiflazzController::class, 'transaction'])->name('transaction');
        Route::post('/webhook/ping/{hook_id?}', [DigiflazzController::class, 'pingWebhook'])->name('webhook.ping');
    });

    // Dipanggil oleh Digiflazz: tetap publik, diverifikasi lewat signature (DIGIFLAZZ_WEBHOOK_SECRET).
    Route::post('/webhook', [DigiflazzController::class, 'handleWebhook'])->name('webhook');
});
