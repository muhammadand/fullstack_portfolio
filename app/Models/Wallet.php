<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property int $affiliate_id
 * @property float $balance
 * @property float $hold_balance
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Wallet extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'balance' => 'decimal:2',
        'hold_balance' => 'decimal:2',
    ];

    /**
     * Relasi ke Affiliate pemilik wallet
     */
    public function affiliate(): BelongsTo
    {
        return $this->belongsTo(Affiliate::class);
    }

    /**
     * Riwayat mutasi saldo wallet
     */
    public function mutations(): HasMany
    {
        return $this->hasMany(WalletMutation::class)->latest();
    }

    /**
     * Riwayat request deposit / top up
     */
    public function deposits(): HasMany
    {
        return $this->hasMany(WalletDeposit::class)->latest();
    }

    /**
     * Tambah saldo wallet secara atomik (dengan row lock) dan catat mutasi CREDIT
     */
    public function credit(float $amount, string $category = 'DEPOSIT', ?string $description = null, $reference = null): WalletMutation
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException('Nominal kredit harus lebih besar dari 0.');
        }

        return DB::transaction(function () use ($amount, $category, $description, $reference) {
            // Lock row wallet ini untuk menghindari race condition
            $lockedWallet = self::where('id', $this->id)->lockForUpdate()->firstOrFail();

            $balanceBefore = (float) $lockedWallet->balance;
            $balanceAfter = $balanceBefore + $amount;

            $lockedWallet->balance = $balanceAfter;
            $lockedWallet->save();

            $this->balance = $balanceAfter;

            $mutation = WalletMutation::create([
                'mutation_no' => 'MUT-' . date('YmdHis') . '-' . strtoupper(Str::random(4)),
                'affiliate_id' => $lockedWallet->affiliate_id,
                'wallet_id' => $lockedWallet->id,
                'type' => 'CREDIT',
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'category' => $category,
                'reference_type' => $reference ? get_class($reference) : null,
                'reference_id' => $reference ? $reference->id : null,
                'description' => $description,
            ]);

            return $mutation;
        });
    }

    /**
     * Kurangi saldo wallet secara atomik (dengan row lock) dan catat mutasi DEBIT
     */
    public function debit(float $amount, string $category = 'PPOB_ORDER', ?string $description = null, $reference = null): WalletMutation
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException('Nominal debit harus lebih besar dari 0.');
        }

        return DB::transaction(function () use ($amount, $category, $description, $reference) {
            // Lock row wallet ini untuk menghindari race condition
            $lockedWallet = self::where('id', $this->id)->lockForUpdate()->firstOrFail();

            $balanceBefore = (float) $lockedWallet->balance;

            if ($balanceBefore < $amount) {
                throw new \Exception('Saldo wallet tidak mencukupi untuk transaksi ini.');
            }

            $balanceAfter = $balanceBefore - $amount;

            $lockedWallet->balance = $balanceAfter;
            $lockedWallet->save();

            $this->balance = $balanceAfter;

            $mutation = WalletMutation::create([
                'mutation_no' => 'MUT-' . date('YmdHis') . '-' . strtoupper(Str::random(4)),
                'affiliate_id' => $lockedWallet->affiliate_id,
                'wallet_id' => $lockedWallet->id,
                'type' => 'DEBIT',
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'category' => $category,
                'reference_type' => $reference ? get_class($reference) : null,
                'reference_id' => $reference ? $reference->id : null,
                'description' => $description,
            ]);

            return $mutation;
        });
    }
}

