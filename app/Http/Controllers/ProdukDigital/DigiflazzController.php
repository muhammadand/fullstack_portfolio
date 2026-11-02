<?php

namespace App\Http\Controllers\ProdukDigital;

use App\Http\Controllers\Controller;
use App\Services\DigiflazzService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
        $amount = $request->input('amount');
        $bank = $request->input('Bank', $request->input('bank'));
        $ownerName = $request->input('owner_name');

        if (empty($amount) || empty($bank) || empty($ownerName)) {
            return response()->json([
                'success' => false,
                'message' => 'Parameter amount, Bank, dan owner_name wajib diisi.',
            ], 422);
        }

        $result = DigiflazzService::requestDeposit(
            amount: (int) $amount,
            bank: (string) $bank,
            ownerName: (string) $ownerName
        );

        return response()->json($result, $result['http_status'] ?? 200);
    }
}
