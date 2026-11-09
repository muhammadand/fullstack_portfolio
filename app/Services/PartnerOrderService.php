<?php

namespace App\Services;

use App\Exceptions\PartnerOrderException;
use App\Models\Affiliate;
use App\Models\DigitalProduct;
use App\Models\Order;
use App\Models\OrderEvent;
use App\Models\Wallet;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Order produk digital oleh partner yang dibayar dengan saldo wallet (pulsa, paket data, PLN, ...).
 *
 * Alur:
 *   checkout()  -> [transaksi DB] buat order (paid/processing) + debit wallet + jejak audit
 *               -> kirim ke Digiflazz (DigiflazzFulfillmentService::send, format sama dengan top up)
 *   webhook Digiflazz -> DigiflazzFulfillmentService::applyWebhook
 *               -> sukses: email  |  gagal: refund() saldo lalu email
 *
 * Setiap perubahan uang & status dicatat di order_events (append-only, hash berantai).
 */
class PartnerOrderService
{
    public const MUTATION_ORDER = 'PPOB_ORDER';
    public const MUTATION_REFUND = 'PPOB_REFUND';

    public function __construct(private DigiflazzFulfillmentService $fulfillment)
    {
    }

    /**
     * @throws PartnerOrderException alasan aman ditampilkan ke partner
     */
    public function checkout(Affiliate $affiliate, DigitalProduct $product, string $source, string $customerNo, string $idempotencyKey, array $accountData = []): Order
    {
        if ($existing = $this->findByIdempotencyKey($affiliate, $idempotencyKey)) {
            return $existing; // double-tap / submit ulang: kembalikan order yang sama
        }

        if (!$product->isSellable()) {
            throw new PartnerOrderException('Produk sedang gangguan atau di luar jam operasional. Coba produk lain.');
        }

        $level = PpobCatalogService::levelFor($affiliate);
        $price = $level ? $product->priceFor($level) : (float) $product->cost_price;

        if ($price <= 0) {
            throw new PartnerOrderException('Harga produk belum tersedia. Coba lagi nanti.');
        }

        $wallet = $affiliate->getOrCreateWallet();

        try {
            $order = DB::transaction(function () use ($affiliate, $product, $source, $customerNo, $idempotencyKey, $accountData, $level, $price, $wallet) {
                // Kunci baris wallet: cek saldo & status secara konsisten sebelum debit.
                $locked = Wallet::whereKey($wallet->id)->lockForUpdate()->firstOrFail();

                if ($locked->status !== 'active') {
                    throw new PartnerOrderException('Wallet kamu sedang tidak aktif. Hubungi admin.');
                }
                if ((float) $locked->balance < $price) {
                    throw new PartnerOrderException('Saldo tidak cukup. Isi saldo dulu ya.');
                }

                $order = Order::create([
                    'order_no'           => Order::generateOrderNo(Order::prefixFor($source)),
                    'source'             => $source,
                    'affiliate_id'       => $affiliate->id,
                    'idempotency_key'    => $idempotencyKey,
                    'digital_product_id' => $product->id,
                    'customer_no'        => $customerNo,
                    // Top up game: ID akun per field (mis. user_id + zone_id), digabung jadi customer_no untuk Digiflazz.
                    'account_data'       => $accountData ?: null,
                    'email'              => $affiliate->email ? mb_strtolower(trim($affiliate->email)) : null,
                    'product_name'       => $product->name,
                    'sku_code'           => $product->sku_code,
                    'cost_price'         => $product->cost_price,
                    'price'              => $price,
                    'admin_fee'          => 0,
                    'total_amount'       => $price,
                    // Dibayar saldo = langsung lunas; status "processing" sampai hasil Digiflazz masuk.
                    'status'             => Order::STATUS_PROCESSING,
                    'payment_status'     => Order::PAYMENT_PAID,
                    'payment_method'     => Order::PAYMENT_METHOD_WALLET,
                    'paid_at'            => now(),
                ]);

                $mutation = $wallet->debit(
                    $price,
                    self::MUTATION_ORDER,
                    "Pembelian {$order->sourceLabel()} {$product->name} ke {$customerNo} (#{$order->order_no})",
                    $order
                );

                $order->update(['payment_reference' => $mutation->mutation_no]);

                $actor = ['actor_type' => OrderEvent::ACTOR_AFFILIATE, 'actor_id' => $affiliate->id];

                OrderEvent::record($order, OrderEvent::ORDER_CREATED, $actor + [
                    'status_to' => Order::STATUS_PROCESSING,
                    'amount'    => $price,
                    'context'   => [
                        'source'       => $source,
                        'product_id'   => $product->id,
                        'sku_code'     => $product->sku_code,
                        'product_name' => $product->name,
                        'customer_no'  => $customerNo,
                        'price_level'  => $level?->code,
                        'cost_price'   => (string) $product->cost_price,
                    ],
                ]);

                OrderEvent::record($order, OrderEvent::WALLET_DEBITED, $actor + [
                    'amount'             => $price,
                    'wallet_mutation_id' => $mutation->id,
                    'context'            => [
                        'mutation_no'    => $mutation->mutation_no,
                        'balance_before' => (string) $mutation->balance_before,
                        'balance_after'  => (string) $mutation->balance_after,
                    ],
                ]);

                return $order;
            });
        } catch (UniqueConstraintViolationException $e) {
            // Dua request dengan kunci idempoten yang sama bersamaan: yang kalah memakai order pemenang.
            if ($existing = $this->findByIdempotencyKey($affiliate, $idempotencyKey)) {
                return $existing;
            }

            throw $e;
        }

        // Setelah commit: kirim ke Digiflazz. Kegagalan jaringan tidak membatalkan order (status tetap processing).
        try {
            $this->fulfillment->send($order);
        } catch (\Throwable $e) {
            Log::error("Order #{$order->order_no}: exception saat kirim ke Digiflazz.", ['error' => $e->getMessage()]);
            OrderEvent::safeRecord($order, OrderEvent::PROVIDER_SEND_FAIL, [
                'context' => ['error' => mb_substr($e->getMessage(), 0, 500)],
            ]);
        }

        return $order->refresh();
    }

    /**
     * Kembalikan saldo order wallet yang gagal. Idempoten: klaim refunded_at dan kredit saldo berada
     * dalam satu transaksi, jadi webhook ganda tidak pernah me-refund dua kali.
     */
    public function refund(Order $order, string $reason, string $actorType = OrderEvent::ACTOR_SYSTEM): bool
    {
        if (!$order->isWalletPayment()) {
            return false;
        }

        try {
            $refunded = DB::transaction(function () use ($order, $reason, $actorType) {
                $claimed = Order::whereKey($order->id)
                    ->where('status', Order::STATUS_FAILED)
                    ->whereNull('refunded_at')
                    ->update(['refunded_at' => now(), 'updated_at' => now()]);

                if ($claimed !== 1) {
                    return false;
                }

                $wallet = Wallet::where('affiliate_id', $order->affiliate_id)->firstOrFail();
                $amount = (float) $order->total_amount;

                $mutation = $wallet->credit(
                    $amount,
                    self::MUTATION_REFUND,
                    "Refund {$order->sourceLabel()} {$order->product_name} ke {$order->customer_no} (#{$order->order_no})",
                    $order
                );

                OrderEvent::record($order, OrderEvent::WALLET_REFUNDED, [
                    'actor_type'         => $actorType,
                    'amount'             => $amount,
                    'wallet_mutation_id' => $mutation->id,
                    'context'            => [
                        'reason'         => mb_substr($reason, 0, 255),
                        'mutation_no'    => $mutation->mutation_no,
                        'balance_before' => (string) $mutation->balance_before,
                        'balance_after'  => (string) $mutation->balance_after,
                    ],
                ]);

                return true;
            });
        } catch (\Throwable $e) {
            Log::critical("Order #{$order->order_no}: REFUND GAGAL, saldo partner belum dikembalikan.", ['error' => $e->getMessage()]);
            OrderEvent::safeRecord($order, OrderEvent::REFUND_FAILED, [
                'actor_type' => $actorType,
                'amount'     => (float) $order->total_amount,
                'context'    => ['reason' => mb_substr($reason, 0, 255), 'error' => mb_substr($e->getMessage(), 0, 500)],
            ]);
            $refunded = false;
        }

        $order->refresh();

        return $refunded;
    }

    private function findByIdempotencyKey(Affiliate $affiliate, string $key): ?Order
    {
        return Order::where('affiliate_id', $affiliate->id)->where('idempotency_key', $key)->first();
    }
}
