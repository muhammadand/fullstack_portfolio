<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSettingLog;
use App\Services\DigiflazzService;
use App\Models\AppSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PpobAdminController extends Controller
{
    /**
     * Halaman Utama Menu PPOB & Cek Saldo Digiflazz
     */
    public function index(): View
    {
        $username = config('services.digiflazz.username');
        $mode = DigiflazzService::mode();
        $isProduction = $mode === DigiflazzService::MODE_PRODUCTION;
        $apiKey = DigiflazzService::getApiKey();
        $keyReady = [
            DigiflazzService::MODE_DEVELOPMENT => DigiflazzService::getApiKey(DigiflazzService::MODE_DEVELOPMENT) !== '',
            DigiflazzService::MODE_PRODUCTION  => DigiflazzService::getApiKey(DigiflazzService::MODE_PRODUCTION) !== '',
        ];
        $modeLogs = AppSettingLog::where('key', DigiflazzService::MODE_SETTING_KEY)->latest('id')->limit(5)->get();
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
            'mode',
            'keyReady',
            'modeLogs',
            'webhookSecret',
            'balance',
            'balanceStatus',
            'balanceMessage',
            'balanceData'
        ));
    }

    /**
     * Switch mode Digiflazz (development / production). Dicatat di app_setting_logs.
     */
    public function updateMode(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'mode' => ['required', Rule::in([DigiflazzService::MODE_DEVELOPMENT, DigiflazzService::MODE_PRODUCTION])],
        ]);

        if (DigiflazzService::getApiKey($data['mode']) === '') {
            $env = $data['mode'] === DigiflazzService::MODE_PRODUCTION ? 'DIGIFLAZZ_PROD_API_KEY' : 'DIGIFLAZZ_DEV_API_KEY';

            return back()->with('error', "API key untuk mode {$data['mode']} belum diisi. Tambahkan {$env} di .env dulu.");
        }

        AppSetting::put(DigiflazzService::MODE_SETTING_KEY, $data['mode']);

        $label = $data['mode'] === DigiflazzService::MODE_PRODUCTION ? 'Production (transaksi sungguhan)' : 'Development (testing)';

        return back()->with('success', "Mode Digiflazz sekarang: {$label}.");
    }
}

