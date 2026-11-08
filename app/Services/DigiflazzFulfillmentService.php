<?php

namespace App\Services;

use App\Models\DigiflazzWebhook;
use App\Models\Order;
use App\Models\OrderEvent;
use Illuminate\Support\Facades\Log;

/**
 * Pemenuhan order produk digital lewat Digiflazz. Tidak terikat jenis produk: top up game, pulsa,
 * paket data, token listrik, dll. memakai payload yang sama, semuanya diambil dari Order:
 *   buyer_sku_code = sku_code, customer_no = customer_no, ref_id = order_no.
 *
 * Alur:  pembayaran lunas -> send()  ->  Digiflazz  ->  webhook -> applyWebhook() -> status order.
 * Status order HANYA ditentukan oleh applyWebhook(); balasan langsung dari transaction cuma dicatat.
 */
class DigiflazzFulfillmentService
{
    /**
     * Kirim order yang sudah lunas ke Digiflazz (transaction).
     *
     * Aman dipanggil berulang: hanya satu pemanggil yang "mengklaim" order lewat update atomik
     * provider_ref_id, dan ref_id yang sama juga tidak membuat transaksi ganda di sisi Digiflazz.
     */
    public function send(Order $order): void
    {
        $claimed = Order::whereKey($order->id)
            ->where('payment_status', Order::PAYMENT_PAID)
            ->whereNull('provider_ref_id')
            ->update(['provider_ref_id' => $order->order_no]);

        if ($claimed !== 1) {
            return; // sudah diklaim proses lain, atau belum lunas
        }

        // Klaim ditulis lewat query langsung; segarkan model agar update berikutnya (termasuk melepas klaim) terbaca berubah.
        $order->refresh();

        $result = DigiflazzService::transaction(
            (string) $order->sku_code,
            (string) $order->customer_no,
            $order->order_no
        );

        $data = $result['digiflazz_response']['data'] ?? null;

        // Tidak ada balasan yang bisa dibaca (jaringan/format): lepas klaim, status tetap "processing".
        if (!is_array($data) || !isset($data['status'])) {
            Log::warning("Order #{$order->order_no}: tidak ada balasan valid dari Digiflazz.", ['result' => $result]);
            $order->update([
                'provider_ref_id'  => null,
                'provider_message' => $result['message'] ?? 'Tidak ada balasan valid dari Digiflazz.',
            ]);
            OrderEvent::safeRecord($order, OrderEvent::PROVIDER_SEND_FAIL, [
                'context' => ['message' => mb_substr((string) ($result['message'] ?? 'Tidak ada balasan valid'), 0, 500)],
            ]);

            return;
        }

        // Status order TIDAK ditentukan dari balasan langsung ini (lihat applyWebhook). Hanya mencatat.
        $order->update([
            'sn'               => $data['sn'] ?: null,
            'provider_message' => $data['message'] ?? null,
        ]);
        OrderEvent::safeRecord($order, OrderEvent::PROVIDER_SENT, [
            'context' => [
                'ref_id'          => $order->order_no,
                'buyer_sku_code'  => $order->sku_code,
                'mode'            => DigiflazzService::mode(),
                'provider_status' => $data['status'] ?? null,
                'rc'              => $data['rc'] ?? null,
                'message'         => mb_substr((string) ($data['message'] ?? ''), 0, 255),
            ],
        ]);
    }

    /**
     * Terapkan hasil transaksi dari webhook Digiflazz ke order (ref_id = order_no).
     *
     * @return string success | failed | pending | ignored | not_order
     */
    public function applyWebhook(DigiflazzWebhook $webhook): string
    {
        if (empty($webhook->status) || !Order::hasKnownPrefix((string) $webhook->ref_id)) {
            return 'not_order'; // ping hook, atau transaksi modul lain
        }

        // Bila secret webhook diset, tanda tangan wajib valid agar status tidak bisa dipalsukan.
        $secretSet = !empty(config('services.digiflazz.webhook_secret'));
        if ($secretSet && $webhook->is_valid_signature !== true) {
            Log::warning("Digiflazz webhook {$webhook->ref_id} diabaikan: tanda tangan tidak valid.");

            return 'ignored';
        }
        if (!$secretSet) {
            Log::warning('DIGIFLAZZ_WEBHOOK_SECRET belum diisi: webhook Digiflazz diterima tanpa verifikasi tanda tangan.');
        }

        $order = Order::where('order_no', $webhook->ref_id)->first();

        if (!$order) {
            return 'not_order';
        }

        // SKU di webhook (bila ada) harus sama dengan order.
        if (!empty($webhook->buyer_sku_code) && $webhook->buyer_sku_code !== $order->sku_code) {
            Log::warning("Digiflazz webhook {$webhook->ref_id}: SKU tidak cocok ({$webhook->buyer_sku_code} vs {$order->sku_code}).");

            return 'ignored';
        }

        $statusBefore = $order->status;
        $result = $order->applyProviderResult($webhook->status, $webhook->sn, $webhook->message);

        $webhook->update(['is_processed' => true, 'processed_at' => now()]);

        if ($result !== 'ignored') {
            OrderEvent::safeRecord($order, OrderEvent::PROVIDER_RESULT, [
                'actor_type'  => OrderEvent::ACTOR_DIGIFLAZZ,
                'status_from' => $statusBefore,
                'status_to'   => $order->status,
                'context'     => [
                    'webhook_id'      => $webhook->id,
                    'provider_status' => $webhook->status,
                    'sn'              => $webhook->sn,
                    'message'         => mb_substr((string) $webhook->message, 0, 255),
                    'signature_valid' => $webhook->is_valid_signature,
                ],
            ]);
        }

        // Order gagal: kembalikan uang DULU agar email bisa menyebut refund.
        //  - dibayar saldo partner -> wallet partner
        //  - dibayar customer yang login -> saldo akun customer (order tamu tidak di-refund otomatis)
        if ($result === Order::STATUS_FAILED) {
            $reason = 'Digiflazz: ' . ($webhook->message ?: 'Gagal');
            $order->isWalletPayment()
                ? app(PartnerOrderService::class)->refund($order, $reason, OrderEvent::ACTOR_DIGIFLAZZ)
                : app(CustomerBalanceService::class)->refundOrder($order, $reason, OrderEvent::ACTOR_DIGIFLAZZ);
        }

        // Email hasil akhir hanya saat status benar-benar berubah (webhook ulang/terlambat = 'ignored').
        if (in_array($result, [Order::STATUS_SUCCESS, Order::STATUS_FAILED], true)) {
            TopupOrderMailer::send($order, $result);
        }

        Log::info("Digiflazz webhook {$order->order_no}: {$webhook->status} -> {$result}");

        return $result;
    }
}
