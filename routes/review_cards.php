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
    Route::get('/create', [ReviewCardController::class, 'create'])->name('create');
    Route::post('/', [ReviewCardController::class, 'store'])->name('store');
    Route::post('/batch-generate', [ReviewCardController::class, 'batchGenerate'])->name('batch_generate');
    Route::get('/{review_card}', [ReviewCardController::class, 'show'])->name('show');
    Route::get('/{review_card}/edit', [ReviewCardController::class, 'edit'])->name('edit');
    Route::put('/{review_card}', [ReviewCardController::class, 'update'])->name('update');
    Route::delete('/{review_card}', [ReviewCardController::class, 'destroy'])->name('destroy');
    Route::post('/{id}/toggle-status', [ReviewCardController::class, 'toggleStatus'])->name('toggle_status');
});

// Public Scan Gateway: domain.com/r/{slug}
Route::get('r/{slug}', [ReviewCardController::class, 'scanRedirect'])->name('review_cards.scan');
