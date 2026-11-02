<?php

namespace App\Http\Controllers\ProdukDigital;

use App\Http\Controllers\Controller;
use App\Services\DigiflazzService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DigiflazzController extends Controller
{
    /**
     * Endpoint API Cek Saldo Akun Digiflazz
     * GET / POST /api/digiflazz/cek-saldo
     */
    public function checkBalance(): JsonResponse
    {
        $result = DigiflazzService::checkBalance();

        return response()->json($result, $result['http_status'] ?? 200);
    }

    /**
     * Endpoint API Get Price List Digiflazz
     * POST /api/digiflazz/price-list
     */
    public function getPrice(Request $request): JsonResponse
    {
        $result = DigiflazzService::getPriceList(
            cmd: $request->input('cmd', 'prepaid'),
            codeFilter: $request->input('code'),
            category: $request->input('category'),
            brand: $request->input('brand')
        );

        return response()->json($result, $result['http_status'] ?? 200);
    }

    /**
     * Endpoint API Request Tiket Deposit Digiflazz
     * POST /api/digiflazz/deposit
     */
    public function deposit(Request $request): JsonResponse
    {
        // Normalisasi key bank (mendukung parameter 'Bank' kapital maupun 'bank' lowercase)
        $request->merge([
            'bank' => $request->input('Bank', $request->input('bank')),
        ]);

        $validator = Validator::make($request->all(), [
            'amount'     => ['required', 'numeric', 'min:10000'],
            'bank'       => ['required', 'string'],
            'owner_name' => ['required', 'string'],
        ], [
            'amount.required'     => 'Parameter amount (nominal deposit) wajib diisi.',
            'amount.min'          => 'Nominal deposit minimal Rp 10.000.',
            'bank.required'       => 'Parameter Bank / bank wajib diisi.',
            'owner_name.required' => 'Parameter owner_name wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal: ' . $validator->errors()->first(),
                'errors'  => $validator->errors(),
            ], 422);
        }

        $result = DigiflazzService::requestDeposit(
            amount: (int) $request->input('amount'),
            bank: (string) $request->input('bank'),
            ownerName: (string) $request->input('owner_name')
        );

        return response()->json($result, $result['http_status'] ?? 200);
    }

    /**
     * Endpoint API Transaksi / Top Up Digiflazz
     * POST /api/digiflazz/transaction atau POST /api/digiflazz/topup
     * Target: https://api.digiflazz.com/v1/transaction
     *
     * Format Request Payload ke Digiflazz:
     * {
     *   "username": "...",
     *   "buyer_sku_code": "xld25",
     *   "customer_no": "087800001233",
     *   "ref_id": "some1d",
     *   "sign": "md5(username + apiKey + ref_id)",
     *   "testing": false,
     *   "max_price": 25000,
     *   "cb_url": "https://...",
     *   "allow_dot": false
     * }
     */
    public function transaction(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'buyer_sku_code' => ['required', 'string'],
            'customer_no'    => ['required', 'string'],
            'ref_id'         => ['nullable', 'string'],
            'testing'        => ['nullable', 'boolean'],
            'max_price'      => ['nullable', 'integer'],
            'cb_url'         => ['nullable', 'string'],
            'allow_dot'      => ['nullable', 'boolean'],
        ], [
            'buyer_sku_code.required' => 'Parameter buyer_sku_code wajib diisi.',
            'customer_no.required'    => 'Parameter customer_no wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal: ' . $validator->errors()->first(),
                'errors'  => $validator->errors(),
            ], 422);
        }

        $result = DigiflazzService::transaction(
            buyerSkuCode: (string) $request->input('buyer_sku_code'),
            customerNo: (string) $request->input('customer_no'),
            refId: $request->input('ref_id'),
            testing: (bool) $request->boolean('testing'),
            maxPrice: $request->filled('max_price') ? (int) $request->input('max_price') : null,
            cbUrl: $request->input('cb_url'),
            allowDot: (bool) $request->boolean('allow_dot')
        );

        return response()->json($result, $result['http_status'] ?? 200);
    }

    /**
     * Endpoint Webhook Callback Digiflazz
     * POST /api/digiflazz/webhook
     *
     * Menerima dan menyimpan seluruh data webhook beserta special headers:
     * - X-Digiflazz-Event
     * - X-Hub-Signature
     * - User-Agent
     */
    public function handleWebhook(Request $request): JsonResponse
    {
        $webhook = DigiflazzService::saveWebhook($request);

        return response()->json([
            'success'    => true,
            'message'    => 'Digiflazz webhook received and saved successfully.',
            'webhook_id' => $webhook->id,
            'ref_id'     => $webhook->ref_id,
            'status'     => $webhook->status,
        ], 200);
    }

    /**
     * Endpoint API Trigger Tes Ping Webhook ke Digiflazz
     * POST /api/digiflazz/webhook/ping/{hook_id?}
     * Target: https://api.digiflazz.com/v1/report/hooks/{hook_id}/pings
     */
    public function pingWebhook(Request $request, ?string $hookId = null): JsonResponse
    {
        $hookId = $hookId ?: $request->input('hook_id');

        if (empty($hookId)) {
            return response()->json([
                'success' => false,
                'message' => 'Parameter hook_id wajib diisi (misal: 11aaabbb).',
            ], 422);
        }

        $result = DigiflazzService::pingWebhook((string) $hookId);

        return response()->json($result, $result['http_status'] ?? 200);
    }
}
