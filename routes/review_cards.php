<?php

use App\Http\Controllers\Admin\ReviewCardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Smart Google Review Cards Routes
|--------------------------------------------------------------------------
|
| Modul manajemen Google Review Cards (Dynamic QR Standee / Stiker):
| - Admin panel: list data, cetak kartu (PDF/PNG), batch generate massal
| - Public scan gateway: redirect 302 seketika ke Google Review bisnis
|
*/

// Admin Management Routes
Route::prefix('admin/review-cards')->name('admin.review_cards.')->group(function () {
    Route::get('/', [ReviewCardController::class, 'index'])->name('index');
    Route::get('/analytics', [ReviewCardController::class, 'analytics'])->name('analytics');
    Route::get('/create', [ReviewCardController::class, 'create'])->name('create');
    Route::post('/', [ReviewCardController::class, 'store'])->name('store');
    Route::post('/batch-generate', [ReviewCardController::class, 'batchGenerate'])->name('batch_generate');
    Route::get('/{review_card}', [ReviewCardController::class, 'show'])->name('show');
    Route::get('/{review_card}/edit', [ReviewCardController::class, 'edit'])->name('edit');
    Route::put('/{review_card}', [ReviewCardController::class, 'update'])->name('update');
    Route::delete('/{review_card}', [ReviewCardController::class, 'destroy'])->name('destroy');
    Route::post('/{id}/toggle-status', [ReviewCardController::class, 'toggleStatus'])->name('toggle_status');
    Route::post('/{id}/mark-sold', [ReviewCardController::class, 'markAsSold'])->name('mark_sold');

    // Admin Verification for Partner QRIS Orders
    Route::post('/orders/{orderId}/verify', [ReviewCardController::class, 'verifyOrderPayment'])->name('verify_order');
    Route::post('/orders/{orderId}/cancel', [ReviewCardController::class, 'cancelOrderPayment'])->name('cancel_order');
});

// Public Scan Gateway & Activation: domain.com/r/{slug}
Route::get('r/{slug}', [ReviewCardController::class, 'scanRedirect'])->name('review_cards.scan');
Route::post('r/{slug}/activate', [ReviewCardController::class, 'activateCard'])->name('review_cards.activate');
