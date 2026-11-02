<?php

namespace App\Http\Controllers;

use App\Services\PaymentWebhookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentCallbackController extends Controller
{
    protected PaymentWebhookService $webhookService;

    public function __construct(PaymentWebhookService $webhookService)
    {
        $this->webhookService = $webhookService;
    }

    /**
     * Handle incoming webhook notification from Midtrans, ScalifyPay, or other gateways.
     * Clean, declarative delegation to PaymentWebhookService with audit trails and fast routing.
     */
    public function handleWebhook(Request $request): JsonResponse
    {
        $result = $this->webhookService->handle(
            $request->all(),
            $request->ip(),
            $request->userAgent()
        );

        return response()->json($result['data'], $result['status']);
    }

    /**
     * Alias method for webhook handler.
     */
    public function webhook(Request $request): JsonResponse
    {
        return $this->handleWebhook($request);
    }
}
