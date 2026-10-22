<?php

use App\Http\Controllers\TravellController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Travel & Shuttle Routes (Ciamis - Bandung)
|--------------------------------------------------------------------------
|
| Rute terpisah untuk modul website travel:
| - Landing page & cek jadwal keberangkatan
| - Form pemesanan tiket shuttle & sewa mobil (charter)
|
*/

Route::prefix('travell')->name('travell.')->group(function () {
    Route::get('/', [TravellController::class, 'index'])->name('index');
    Route::post('/book', [TravellController::class, 'storeBooking'])->name('book');
    Route::post('/qris/generate', [TravellController::class, 'generateQris'])->name('qris.generate');
    Route::get('/status/{code}', [TravellController::class, 'checkStatus'])->name('status');
    Route::post('/my-tickets', [TravellController::class, 'myTickets'])->name('my_tickets');
    Route::post('/pay/{code}', [TravellController::class, 'payBooking'])->name('pay');
    Route::post('/customer/login', [TravellController::class, 'loginCustomer'])->name('customer.login');
    Route::get('/customer/profile', [TravellController::class, 'customerProfile'])->name('customer.profile');
});
