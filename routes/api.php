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
    // Keamanan sederhana menggunakan query parameter
    if ($request->get('secret') !== 'cuan-tiap-hari') {
        return response()->json(['error' => 'Unauthorized. Butuh parameter ?secret=cuan-tiap-hari'], 401);
    }

    // Cari affiliate yang sudah Allow Notifications
    $affiliates = Affiliate::whereHas('pushSubscriptions')->get();

    if ($affiliates->isEmpty()) {
        return response()->json(['message' => 'Belum ada affiliate yang mengizinkan notifikasi.']);
    }

    // Kirim notifikasi massal
    Notification::send($affiliates, new DailyAffiliateReminder());

    return response()->json([
        'success' => true,
        'message' => 'Notifikasi berhasil dikirim ke ' . $affiliates->count() . ' affiliate!'
    ]);
});
