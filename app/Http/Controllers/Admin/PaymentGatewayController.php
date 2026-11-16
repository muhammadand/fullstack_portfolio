<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\AppSettingLog;
use App\Services\ScalifyPayService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Pengaturan Scalify Pay (QRIS): pilih mode sandbox / production. API key tetap di .env;
 * yang disimpan hanya mode aktif (app_settings) dan setiap perubahan tercatat di app_setting_logs.
 */
class PaymentGatewayController extends Controller
{
    public function index()
    {
        $mode = ScalifyPayService::mode();
        $modes = collect([ScalifyPayService::MODE_SANDBOX, ScalifyPayService::MODE_PRODUCTION])->mapWithKeys(fn ($m) => [$m => [
            'ready' => ScalifyPayService::getApiKey($m) !== '',
            'key' => self::mask(ScalifyPayService::getApiKey($m)),
            'url' => ScalifyPayService::getBaseUrl($m),
            'env' => $m === ScalifyPayService::MODE_PRODUCTION ? 'SCALIFY_PAY_PRODUCTION_API_KEY' : 'SCALIFY_PAY_SANDBOX_API_KEY',
        ]])->all();
        $logs = AppSettingLog::where('key', ScalifyPayService::MODE_SETTING_KEY)->latest('id')->limit(10)->get();

        return view('admin.payment_gateway.index', compact('mode', 'modes', 'logs'));
    }

    public function updateMode(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'mode' => ['required', Rule::in([ScalifyPayService::MODE_SANDBOX, ScalifyPayService::MODE_PRODUCTION])],
        ]);

        if (ScalifyPayService::getApiKey($data['mode']) === '') {
            $env = $data['mode'] === ScalifyPayService::MODE_PRODUCTION ? 'SCALIFY_PAY_PRODUCTION_API_KEY' : 'SCALIFY_PAY_SANDBOX_API_KEY';

            return back()->with('error', "API key mode {$data['mode']} belum diisi. Tambahkan {$env} di .env dulu.");
        }

        AppSetting::put(ScalifyPayService::MODE_SETTING_KEY, $data['mode']);

        return back()->with('success', 'Scalify Pay sekarang memakai mode ' . ($data['mode'] === ScalifyPayService::MODE_PRODUCTION ? 'Production (pembayaran sungguhan).' : 'Sandbox (uji coba).'));
    }

    /** "pk_live_4f52fee5_sk_live_d108…" -> "pk_live_4f52••••••••" (tidak pernah tampil utuh). */
    private static function mask(string $key): string
    {
        return $key === '' ? '' : substr($key, 0, 12) . '••••••••';
    }
}
