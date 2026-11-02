<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DigiflazzService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PpobAdminController extends Controller
{
    /**
     * Halaman Utama Menu PPOB & Cek Saldo Digiflazz
     */
    public function index(): View
    {
        $username = config('services.digiflazz.username');
        $apiKey = config('services.digiflazz.api_key');
        $isProduction = str_starts_with((string) $apiKey, 'prod-');
        $webhookSecret = config('services.digiflazz.webhook_secret');

        // Ambil saldo awal secara server-side
        $balanceData = DigiflazzService::checkBalance();
        $balance = $balanceData['digiflazz_response']['data']['deposit'] ?? 0;
        $balanceStatus = $balanceData['success'] ?? false;
        $balanceMessage = $balanceData['digiflazz_response']['data']['message'] ?? ($balanceData['message'] ?? null);

        return view('admin.ppob.index', compact(
            'username',
            'apiKey',
            'isProduction',
            'webhookSecret',
            'balance',
            'balanceStatus',
            'balanceMessage',
            'balanceData'
        ));
    }
}

