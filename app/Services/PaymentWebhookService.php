<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\GoogleCardOrder;
use App\Models\Order;
use App\Models\PaymentCallback;
use App\Models\WalletDeposit;
use App\Services\DigiflazzFulfillmentService;
use App\Services\TopupOrderMailer;
use Illuminate\Support\Facades\Log;

class PaymentWebhookService
{
    /**
     * Status transaksi yang dianggap sukses / terbayar lunas.
     */
    public const SUCCESS_STATUSES = ['settlement', 'capture', 'success', 'paid'];

    /**
     * Status transaksi yang dianggap kedaluwarsa.
     */
    public const EXPIRED_STATUSES = ['expire', 'expired'];

    /**
     * Status transaksi yang dianggap gagal atau dibatalkan.
     */
    public const FAILED_STATUSES = ['cancel', 'deny', 'failure', 'failed'];

    /**
     * Tangani webhook notifikasi dari payment gateway (Midtrans, ScalifyPay, dll.)
     *
     * @param array $payload
     * @param string|null $ip
     * @param string|null $userAgent
     * @return array [ 'status' => int, 'data' => array ]
     */
    public function handle(array $payload, ?string $ip = null, ?string $userAgent = null): array
    {
        $startTime = microtime(true);

        Log::info('Payment Webhook Received', [
            'ip' => $ip,
            'user_agent' => $userAgent,
            'payload' => $payload,
        ]);

        try {
            // 1. Ekstraksi dan normalisasi payload dari berbagai format gateway
            $extracted = $this->extractPayload($payload);
            $orderNumber = $extracted['order_number'];
            $transactionId = $extracted['transaction_id'];
            $transactionStatus = $extracted['transaction_status'];
            $statusCode = $extracted['status_code'];
            $grossAmount = $extracted['gross_amount'];
            $signatureKey = $extracted['signature_key'];

            if (empty($orderNumber)) {
                Log::warning('Payment Webhook rejected: missing order identifier', ['payload' => $payload]);
                return [
                    'status' => 422,
                    'data' => [
                        'success' => false,
                        'message' => 'Order identifier is missing.',
                    ],
                ];
            }

            // 2. Verifikasi Signature Midtrans jika server key dan signature key tersedia
            if (!$this->verifySignature($orderNumber, $statusCode, $grossAmount, $signatureKey)) {
                Log::warning("Payment Webhook: Invalid signature for Order #{$orderNumber}");
                return [
                    'status' => 403,
                    'data' => [
                        'success' => false,
                        'message' => 'Invalid signature key.',
                    ],
                ];
            }

            // 3. Simpan riwayat webhook mentah ke database (Immutable Audit Trail)
            $callback = PaymentCallback::create([
                'order_number' => (string) $orderNumber,
                'transaction_id' => $transactionId ? (string) $transactionId : null,
                'transaction_status' => $transactionStatus ? (string) $transactionStatus : null,
                'raw_response' => $payload,
            ]);

            // 4. Fast Smart Routing: proses order berdasarkan awalan prefix kode
            $dispatchResult = $this->dispatchOrder(
                (string) $orderNumber,
                $transactionId ? (string) $transactionId : null,
                $transactionStatus ? strtolower((string) $transactionStatus) : null,
                $payload
            );

            $executionMs = round((microtime(true) - $startTime) * 1000, 2);

            Log::info("Payment Webhook Processed in {$executionMs}ms for Order #{$orderNumber}", [
                'type' => $dispatchResult['type'] ?? 'unknown',
                'action' => $dispatchResult['action'] ?? 'none',
            ]);

            return [
                'status' => 200,
                'data' => [
                    'success' => true,
                    'message' => 'Payment callback stored successfully.',
                    'execution_time_ms' => $executionMs,
                    'data' => array_merge([
                        'callback_id' => $callback->id,
                        'order_number' => $orderNumber,
                        'transaction_id' => $transactionId,
                        'transaction_status' => $transactionStatus,
                    ], $dispatchResult['response_data'] ?? []),
                ],
            ];
        } catch (\Throwable $e) {
            Log::error('Payment Webhook Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'payload' => $payload,
            ]);

            return [
                'status' => 500,
                'data' => [
                    'success' => false,
                    'message' => 'Internal server error while processing webhook: ' . $e->getMessage(),
                ],
            ];
        }
    }

    /**
     * Ekstraksi dan normalisasi atribut payload webhook
     */
    public function extractPayload(array $payload): array
    {
        return [
            'order_number' => $payload['order_id'] ?? $payload['order_number'] ?? $payload['orderNo'] ?? null,
            'transaction_id' => $payload['transaction_id'] ?? $payload['id'] ?? $payload['payment_id'] ?? null,
            'transaction_status' => $payload['transaction_status'] ?? $payload['status'] ?? $payload['payment_status'] ?? null,
            'status_code' => $payload['status_code'] ?? null,
            'gross_amount' => $payload['gross_amount'] ?? $payload['amount'] ?? null,
            'signature_key' => $payload['signature_key'] ?? $payload['signature'] ?? null,
        ];
    }

    /**
     * Verifikasi Signature SHA-512 Midtrans
     */
    public function verifySignature(?string $orderNumber, ?string $statusCode, $grossAmount, ?string $signatureKey): bool
    {
        $serverKey = config('services.midtrans.server_key', env('MIDTRANS_SERVER_KEY'));

        // Jika server key atau parameter verifikasi tidak ada, lewati validasi (kompatibel dev/gateway non-midtrans)
        if (empty($serverKey) || empty($signatureKey) || empty($statusCode) || empty($grossAmount)) {
            return true;
        }

        $expectedSignature = hash('sha512', $orderNumber . $statusCode . $grossAmount . $serverKey);

        return hash_equals($expectedSignature, $signatureKey);
    }

    /**
     * Dispatch pesanan secara efisien menggunakan prefix indexing
     */
    public function dispatchOrder(string $orderNumber, ?string $transactionId, ?string $status, array $payload): array
    {
        // 1. Prefix 'DEP-' -> Wallet Deposit (PPOB & Affiliate Balance)
        if (str_starts_with($orderNumber, 'DEP-')) {
            return $this->processWalletDeposit($orderNumber, $transactionId, $status, $payload);
        }

        // 2. Prefix 'GCO-' atau Google Card Order
        if (str_starts_with($orderNumber, 'GCO-')) {
            return $this->processGoogleCardOrder($orderNumber, $transactionId, $status, $payload);
        }

        // 3. Prefix 'RVN-' / 'CHR-' -> Booking Travel
        if (str_starts_with($orderNumber, 'RVN-') || str_starts_with($orderNumber, 'CHR-')) {
            return $this->processBookingOrder($orderNumber, $transactionId, $status, $payload);
        }

        // 3b. Order produk digital (top up game, pulsa, listrik, ...) -> lihat Order::ORDER_NO_PREFIXES
        if (Order::hasKnownPrefix($orderNumber)) {
            return $this->processDigitalOrder($orderNumber, $transactionId, $status, $payload);
        }

        // 4. Fallback jika order_number tidak memiliki prefix standar
        return $this->fallbackDispatch($orderNumber, $transactionId, $status, $payload);
    }

    /**
     * Proses Wallet Deposit secara atomik dan idempoten
     */
    protected function processWalletDeposit(string $orderNumber, ?string $transactionId, ?string $status, array $payload): array
    {
        $deposit = WalletDeposit::where('deposit_no', $orderNumber)->first();

        if (!$deposit && !empty($transactionId)) {
            $deposit = WalletDeposit::where('payment_reference', $transactionId)->first();
        }

        if (!$deposit) {
            return [
                'type' => 'wallet_deposit',
                'action' => 'not_found',
                'response_data' => [
                    'order_updated' => false,
                    'wallet_deposit' => null,
                ],
            ];
        }

        $action = 'none';

        if ($status && in_array($status, self::SUCCESS_STATUSES)) {
            $paid = $deposit->markAsPaid($transactionId, $payload);
            $action = $paid ? 'paid' : 'already_paid';
            Log::info("WalletDeposit #{$deposit->deposit_no} paid! Credited Rp {$deposit->amount} to Affiliate #{$deposit->affiliate_id} wallet.");
        } elseif ($status && in_array($status, self::EXPIRED_STATUSES)) {
            $deposit->markAsExpired($payload);
            $action = 'expired';
            Log::info("WalletDeposit #{$deposit->deposit_no} marked as expired.");
        } elseif ($status && in_array($status, self::FAILED_STATUSES)) {
            $deposit->markAsFailed("Gateway status: {$status}", $payload);
            $action = 'failed';
            Log::info("WalletDeposit #{$deposit->deposit_no} marked as failed.");
        }

        return [
            'type' => 'wallet_deposit',
            'action' => $action,
            'response_data' => [
                'order_updated' => true,
                'wallet_deposit' => [
                    'id' => $deposit->id,
                    'deposit_no' => $deposit->deposit_no,
                    'status' => $deposit->payment_status,
                    'amount' => (float) $deposit->amount,
                ],
            ],
        ];
    }

    /**
     * Proses Google Card Order
     */
    protected function processGoogleCardOrder(string $orderNumber, ?string $transactionId, ?string $status, array $payload): array
    {
        $cardOrder = GoogleCardOrder::where('order_id', $orderNumber)->first();

        if (!$cardOrder && !empty($transactionId)) {
            $cardOrder = GoogleCardOrder::where('transaction_id', $transactionId)->first();
        }

        if (!$cardOrder) {
            return [
                'type' => 'google_card_order',
                'action' => 'not_found',
                'response_data' => [
                    'order_updated' => false,
                    'review_card' => null,
                ],
            ];
        }

        $createdCard = null;
        $action = 'none';

        if ($status && in_array($status, self::SUCCESS_STATUSES)) {
            $createdCard = $cardOrder->markAsPaid($transactionId, $payload);
            $action = 'paid';
            Log::info("GoogleCardOrder #{$orderNumber} paid! Created & activated ReviewCard: {$createdCard->serial_number}");
        }

        return [
            'type' => 'google_card_order',
            'action' => $action,
            'response_data' => [
                'order_updated' => true,
                'review_card' => $createdCard ? [
                    'id' => $createdCard->id,
                    'serial_number' => $createdCard->serial_number,
                    'slug' => $createdCard->slug,
                    'scan_url' => $createdCard->scan_url,
                    'google_review_url' => $createdCard->google_review_url,
                ] : null,
            ],
        ];
    }

    /**
     * Proses Order produk digital (idempoten): lunas -> kirim ke Digiflazz lewat DigiflazzFulfillmentService.
     */
    protected function processDigitalOrder(string $orderNumber, ?string $transactionId, ?string $status, array $payload): array
    {
        $order = Order::where('order_no', $orderNumber)->first();

        if (!$order) {
            return ['type' => 'digital_order', 'action' => 'not_found', 'response_data' => ['order_updated' => false]];
        }

        $action = 'none';

        if ($status && in_array($status, self::SUCCESS_STATUSES)) {
            // Nominal dari gateway (bila ada) harus sama dengan total order.
            $gross = $payload['gross_amount'] ?? $payload['amount'] ?? null;
            if ($gross !== null && (int) round((float) $gross) !== (int) round((float) $order->total_amount)) {
                Log::warning("Topup Order #{$orderNumber}: amount mismatch (gateway {$gross} vs order {$order->total_amount}).");
                $action = 'amount_mismatch';
            } else {
                $action = $order->markAsPaid($transactionId) ? 'paid' : 'already_paid';

                // Email "pembayaran diterima" hanya saat baru lunas (webhook ulang tidak mengirim lagi).
                if ($action === 'paid') {
                    TopupOrderMailer::send($order, 'paid');
                }

                // Lunas -> kirim ke Digiflazz. Dipanggil juga saat webhook diulang (already_paid) agar
                // order yang tadinya gagal terhubung ke supplier bisa dicoba lagi; klaim atomik mencegah kirim ganda.
                if ($order->status === Order::STATUS_PROCESSING && $order->provider_ref_id === null) {
                    app(DigiflazzFulfillmentService::class)->send($order);
                }
            }
        } elseif ($status && in_array($status, self::EXPIRED_STATUSES)) {
            $order->markAsExpired();
            $action = 'expired';
        } elseif ($status && in_array($status, self::FAILED_STATUSES)) {
            $order->markAsFailed();
            $action = 'failed';
        }

        return [
            'type' => 'digital_order',
            'action' => $action,
            'response_data' => [
                'order_updated' => true,
                'digital_order' => [
                    'order_no' => $order->order_no,
                    'payment_status' => $order->payment_status,
                    'status' => $order->status,
                ],
            ],
        ];
    }

    /**
     * Proses Travel Booking Order
     */
    protected function processBookingOrder(string $orderNumber, ?string $transactionId, ?string $status, array $payload): array
    {
        $booking = Booking::where('booking_code', $orderNumber)->first();

        if (!$booking) {
            return [
                'type' => 'booking_order',
                'action' => 'not_found',
                'response_data' => ['order_updated' => false],
            ];
        }

        $action = 'none';

        if ($status && in_array($status, self::SUCCESS_STATUSES)) {
            $booking->update([
                'payment_status' => Booking::PAYMENT_PAID ?? 'paid',
                'status' => 'confirmed',
            ]);
            $action = 'paid';
            Log::info("Booking #{$booking->booking_code} marked as paid & confirmed.");
        }

        return [
            'type' => 'booking_order',
            'action' => $action,
            'response_data' => [
                'order_updated' => true,
                'booking' => [
                    'id' => $booking->id,
                    'booking_code' => $booking->booking_code,
                    'payment_status' => $booking->payment_status,
                ],
            ],
        ];
    }

    /**
     * Fallback pencarian multi-model jika order_number tidak memiliki prefix standar
     */
    protected function fallbackDispatch(string $orderNumber, ?string $transactionId, ?string $status, array $payload): array
    {
        // Coba cari di WalletDeposit lebih dulu
        $depositResult = $this->processWalletDeposit($orderNumber, $transactionId, $status, $payload);
        if (($depositResult['action'] ?? '') !== 'not_found') {
            return $depositResult;
        }

        // Coba cari di GoogleCardOrder (dengan query json fallback jika belum ketemu)
        $cardOrder = GoogleCardOrder::where('order_id', $orderNumber)
            ->orWhere(function ($q) use ($orderNumber, $transactionId) {
                if (!empty($transactionId)) {
                    $q->where('transaction_id', $transactionId);
                }
                if (!empty($orderNumber)) {
                    $q->orWhere('raw_response->midtrans_order_id', $orderNumber)
                        ->orWhere('raw_response->payment_details->order_id', $orderNumber);
                }
            })
            ->first();

        if ($cardOrder) {
            $createdCard = null;
            if ($status && in_array($status, self::SUCCESS_STATUSES)) {
                $createdCard = $cardOrder->markAsPaid($transactionId, $payload);
            }
            return [
                'type' => 'google_card_order',
                'action' => $createdCard ? 'paid' : 'checked',
                'response_data' => [
                    'order_updated' => true,
                    'review_card' => $createdCard ? [
                        'id' => $createdCard->id,
                        'serial_number' => $createdCard->serial_number,
                        'slug' => $createdCard->slug,
                        'scan_url' => $createdCard->scan_url,
                        'google_review_url' => $createdCard->google_review_url,
                    ] : null,
                ],
            ];
        }

        // Coba cari di Booking
        $bookingResult = $this->processBookingOrder($orderNumber, $transactionId, $status, $payload);
        if (($bookingResult['action'] ?? '') !== 'not_found') {
            return $bookingResult;
        }

        return [
            'type' => 'unknown',
            'action' => 'none',
            'response_data' => [
                'order_updated' => false,
            ],
        ];
    }
}
