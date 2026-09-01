<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ClientProposalController;

// Endpoint Webhook untuk menerima data dari Scraper WhatsApp
Route::post('/webhook/scraper-client', [ClientProposalController::class, 'handleWebhook']);

// Endpoint API untuk Bulk Insert Student Leads
use App\Http\Controllers\Api\StudentLeadApiController;

Route::post('/student-leads/bulk', [StudentLeadApiController::class, 'bulkStore']);

// Endpoint Manual & Cron: Kirim Push Notification Harian
use App\Models\Affiliate;
use App\Notifications\DailyAffiliateReminder;
use Illuminate\Support\Facades\Notification;

Route::get('/cron/send-daily-push', function (Request $request) {
    @set_time_limit(300);
    @ini_set('max_execution_time', '300');

    // Keamanan sederhana menggunakan query parameter
    if ($request->get('secret') !== 'cuan-tiap-hari') {
        return response()->json(['error' => 'Unauthorized. Butuh parameter ?secret=cuan-tiap-hari'], 401);
    }

    // Cari affiliate yang sudah Allow Notifications
    $affiliates = Affiliate::whereHas('pushSubscriptions')->get();

    if ($affiliates->isEmpty()) {
        return response()->json([
            'success' => true,
            'message' => 'Belum ada affiliate yang mengizinkan notifikasi.'
        ]);
    }

    $count = 0;
    $failed = 0;

    foreach ($affiliates as $affiliate) {
        try {
            $affiliate->notify(new DailyAffiliateReminder());
            $count++;
        } catch (\Throwable $e) {
            $failed++;
            \Illuminate\Support\Facades\Log::warning("Gagal kirim broadcast push ke Affiliate #{$affiliate->id}: " . $e->getMessage());
        }
    }

    return response()->json([
        'success' => true,
        'message' => "Notifikasi berhasil dikirim ke {$count} affiliate" . ($failed > 0 ? " ({$failed} gagal)" : "") . "!"
    ]);
});
