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
    /** Metode deposit saldo Digiflazz dari admin. */
    public const DEPOSIT_BANK = 'ShopeePay';

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
        $depositBank = self::DEPOSIT_BANK;

        // Ambil saldo awal secara server-side
        $balanceData = DigiflazzService::checkBalance();
        unset($balanceData['request_payload']); // jangan tampilkan username & sign di inspector
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
            'depositBank',
            'webhookSecret',
            'balance',
            'balanceStatus',
            'balanceMessage',
            'balanceData'
        ));
    }

    /**
     * Refresh saldo dari halaman admin (session login, bukan endpoint API publik).
     */
    public function balance(): \Illuminate\Http\JsonResponse
    {
        $result = DigiflazzService::checkBalance();
        unset($result['request_payload']); // jangan kirim username & sign ke browser

        return response()->json($result, $result['http_status'] ?? 200);
    }

    /**
     * Minta tiket deposit saldo Digiflazz via ShopeePay (service requestDeposit yang sudah ada).
     * Balasan Digiflazz (nominal unik, rekening tujuan) langsung ditampilkan ke admin, tidak disimpan.
     */
    public function deposit(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'amount'     => ['required', 'integer', 'min:10000', 'max:100000000'],
            'owner_name' => ['required', 'string', 'max:100'],
        ], [
            'amount.min'          => 'Nominal deposit minimal Rp 10.000.',
            'amount.max'          => 'Nominal deposit maksimal Rp 100.000.000.',
            'owner_name.required' => 'Nama pemilik akun ShopeePay wajib diisi.',
        ]);

        $result = DigiflazzService::requestDeposit((int) $data['amount'], self::DEPOSIT_BANK, trim($data['owner_name']));
        $reply = $result['digiflazz_response']['data'] ?? [];

        if (!($result['success'] ?? false) || ($reply['rc'] ?? null) !== '00') {
            return back()->withInput()->with('error', 'Tiket deposit gagal: ' . ($reply['message'] ?? $result['message'] ?? 'tidak ada balasan dari Digiflazz.'));
        }

        // Tidak pakai toast sukses: detail tiket tampil di modal (lihat admin/ppob/index).
        return back()
            ->with('deposit_ticket', [
                'amount'         => (int) ($reply['amount'] ?? $data['amount']),
                'account_no'     => $reply['account_no'] ?? null,
                'bank'           => $reply['bank'] ?? self::DEPOSIT_BANK,
                'payment_method' => $reply['payment_method'] ?? null,
                'notes'          => !empty($reply['notes']) ? $reply['notes'] : null,
            ]);
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

        $label = $data['mode'] === DigiflazzService::MODE_PRODUCTION ? 'Production' : 'Development';

        return back()->with('success', "Mode: {$label}.");
    }
}
