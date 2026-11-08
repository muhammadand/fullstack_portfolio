<?php

namespace App\Services;

use App\Exceptions\CustomerBalanceException;
use App\Models\Customer;
use App\Models\CustomerBalanceMutation as Mutation;
use App\Models\CustomerWithdrawal;
use App\Models\Order;
use App\Models\OrderEvent;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Saldo customer top up.
 *
 *  - refundOrder():        top up yang sudah dibayar lalu gagal di Digiflazz -> saldo akun customer (hanya order milik akun).
 *  - requestWithdrawal():  customer tarik saldo ke e-wallet; saldo langsung dipotong (ditahan) selama diproses admin.
 *  - complete()/reject():  admin menandai sudah ditransfer, atau menolak (saldo dikembalikan).
 *
 * Semua perubahan saldo memakai lockForUpdate dan dicatat di customer_balance_mutations (append-only).
 */
class CustomerBalanceService
{
    /**
     * Kembalikan pembayaran top up yang gagal ke saldo customer. Idempoten: klaim refunded_at dan kredit
     * berada dalam satu transaksi, jadi webhook ganda tidak pernah me-refund dua kali.
     */
    public function refundOrder(Order $order, string $reason, string $actorType = OrderEvent::ACTOR_SYSTEM): bool
    {
        if ($order->isWalletPayment() || !$order->customer_id || !$order->isPaid()) {
            return false; // order partner (refund wallet partner), order tamu, atau belum dibayar
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

                $amount = (float) $order->total_amount;
                $mutation = $this->mutate(
                    $order->customer_id, Mutation::CREDIT, Mutation::ORDER_REFUND, $amount,
                    "Refund {$order->product_name} (#{$order->order_no})", $order
                );

                OrderEvent::record($order, OrderEvent::WALLET_REFUNDED, [
                    'actor_type' => $actorType,
                    'amount'     => $amount,
                    'context'    => [
                        'target'                   => 'customer_balance',
                        'customer_id'              => $order->customer_id,
                        'customer_balance_mutation' => $mutation->id,
                        'reason'                   => mb_substr($reason, 0, 255),
                        'balance_before'           => (string) $mutation->balance_before,
                        'balance_after'            => (string) $mutation->balance_after,
                    ],
                ]);

                return true;
            });
        } catch (\Throwable $e) {
            Log::critical("Order #{$order->order_no}: REFUND SALDO CUSTOMER GAGAL.", ['error' => $e->getMessage()]);
            OrderEvent::safeRecord($order, OrderEvent::REFUND_FAILED, [
                'actor_type' => $actorType,
                'amount'     => (float) $order->total_amount,
                'context'    => ['target' => 'customer_balance', 'reason' => mb_substr($reason, 0, 255), 'error' => mb_substr($e->getMessage(), 0, 500)],
            ]);
            $refunded = false;
        }

        $order->refresh();

        return $refunded;
    }

    /**
     * @throws CustomerBalanceException alasan aman ditampilkan ke customer
     */
    public function requestWithdrawal(Customer $customer, float $amount, string $ewallet, string $accountNo, string $accountName): CustomerWithdrawal
    {
        if ($amount < CustomerWithdrawal::MIN_AMOUNT) {
            throw new CustomerBalanceException('Minimal penarikan Rp ' . number_format(CustomerWithdrawal::MIN_AMOUNT, 0, ',', '.') . '.');
        }

        return DB::transaction(function () use ($customer, $amount, $ewallet, $accountNo, $accountName) {
            $locked = Customer::whereKey($customer->id)->lockForUpdate()->firstOrFail();

            if ($locked->withdrawals()->where('status', CustomerWithdrawal::STATUS_PENDING)->exists()) {
                throw new CustomerBalanceException('Masih ada penarikan yang sedang diproses. Tunggu sampai selesai dulu ya.');
            }
            if ((float) $locked->balance < $amount) {
                throw new CustomerBalanceException('Saldo tidak cukup.');
            }

            $fee = CustomerWithdrawal::feeFor($amount);

            $withdrawal = CustomerWithdrawal::create([
                'withdrawal_no' => 'WD-' . now()->format('ymd') . '-' . strtoupper(Str::random(6)),
                'customer_id'   => $locked->id,
                'amount'        => $amount,
                'fee'           => $fee,
                'net_amount'    => $amount - $fee,
                'ewallet'       => $ewallet,
                'account_no'    => $accountNo,
                'account_name'  => $accountName,
                'status'        => CustomerWithdrawal::STATUS_PENDING,
            ]);

            $this->mutate($locked->id, Mutation::DEBIT, Mutation::WITHDRAWAL, $amount,
                "Tarik saldo ke {$ewallet} {$accountNo} (#{$withdrawal->withdrawal_no})", $withdrawal, $locked);

            return $withdrawal;
        });
    }

    /** Admin sudah mentransfer net_amount ke e-wallet customer. */
    public function complete(CustomerWithdrawal $withdrawal, User $admin, ?string $reference = null, ?string $note = null): bool
    {
        return DB::transaction(function () use ($withdrawal, $admin, $reference, $note) {
            $claimed = CustomerWithdrawal::whereKey($withdrawal->id)->where('status', CustomerWithdrawal::STATUS_PENDING)->update([
                'status'             => CustomerWithdrawal::STATUS_COMPLETED,
                'transfer_reference' => $reference ? mb_substr($reference, 0, 100) : null,
                'admin_note'         => $note ? mb_substr($note, 0, 255) : null,
                'processed_by'       => $admin->id,
                'processed_at'       => now(),
                'updated_at'         => now(),
            ]);

            $withdrawal->refresh();

            return $claimed === 1;
        });
    }

    /** Admin menolak: saldo yang ditahan dikembalikan utuh ke customer. */
    public function reject(CustomerWithdrawal $withdrawal, User $admin, string $reason): bool
    {
        return DB::transaction(function () use ($withdrawal, $admin, $reason) {
            $claimed = CustomerWithdrawal::whereKey($withdrawal->id)->where('status', CustomerWithdrawal::STATUS_PENDING)->update([
                'status'       => CustomerWithdrawal::STATUS_REJECTED,
                'admin_note'   => mb_substr($reason, 0, 255),
                'processed_by' => $admin->id,
                'processed_at' => now(),
                'updated_at'   => now(),
            ]);

            if ($claimed !== 1) {
                return false;
            }

            $this->mutate($withdrawal->customer_id, Mutation::CREDIT, Mutation::WITHDRAWAL_REVERSAL, (float) $withdrawal->amount,
                "Penarikan #{$withdrawal->withdrawal_no} ditolak: " . mb_substr($reason, 0, 150), $withdrawal);

            $withdrawal->refresh();

            return true;
        });
    }

    /** Ubah saldo + catat mutasi. Wajib dipanggil di dalam DB::transaction. */
    private function mutate(int $customerId, string $type, string $category, float $amount, string $description, Model $reference, ?Customer $locked = null): Mutation
    {
        $locked ??= Customer::whereKey($customerId)->lockForUpdate()->firstOrFail();

        $before = (float) $locked->balance;
        $after = $type === Mutation::CREDIT ? $before + $amount : $before - $amount;

        if ($after < 0) {
            throw new \RuntimeException("Saldo customer #{$customerId} akan minus.");
        }

        // Kolom balance tidak fillable: hanya diubah lewat service ini.
        $locked->forceFill(['balance' => $after])->save();

        return Mutation::create([
            'customer_id'    => $customerId,
            'type'           => $type,
            'category'       => $category,
            'amount'         => $amount,
            'balance_before' => $before,
            'balance_after'  => $after,
            'reference_type' => $reference::class,
            'reference_id'   => $reference->getKey(),
            'description'    => mb_substr($description, 0, 255),
        ]);
    }
}
