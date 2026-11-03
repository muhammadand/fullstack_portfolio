<?php

namespace App\Livewire\Affiliate;

use App\Models\Affiliate;
use App\Models\Wallet;
use App\Models\Withdrawal;
use App\Notifications\AffiliateNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;

class WithdrawPage extends Component
{
    #[Url]
    public string $source = Withdrawal::SOURCE_COMMISSION;

    public string $amount = '';

    /** Ringkasan pengajuan terakhir yang berhasil dibuat (untuk banner sukses) */
    public ?array $submitted = null;

    public function mount(): void
    {
        if (!in_array($this->source, [Withdrawal::SOURCE_COMMISSION, Withdrawal::SOURCE_WALLET], true)) {
            $this->source = Withdrawal::SOURCE_COMMISSION;
        }
    }

    protected function affiliateId(): int
    {
        $id = Auth::guard('affiliate')->id();
        if (!$id) {
            abort(401, 'Silakan login terlebih dahulu.');
        }

        return (int) $id;
    }

    /**
     * Data saldo & rekening — hanya kolom yang dipakai UI
     */
    #[Computed]
    public function summary(): array
    {
        $affiliate = Affiliate::select(['id', 'balance', 'bank_info'])->findOrFail($this->affiliateId());
        $walletBalance = (float) (Wallet::where('affiliate_id', $affiliate->id)->value('balance') ?? 0);

        return [
            'commission_balance' => (float) $affiliate->balance,
            'wallet_balance' => $walletBalance,
            'bank_info' => trim((string) $affiliate->bank_info),
        ];
    }

    #[Computed]
    public function availableBalance(): float
    {
        return $this->source === Withdrawal::SOURCE_WALLET
            ? $this->summary['wallet_balance']
            : $this->summary['commission_balance'];
    }

    /**
     * 5 pengajuan terakhir — hanya kolom yang dipakai UI
     */
    #[Computed]
    public function recentWithdrawals(): array
    {
        return Withdrawal::select(['id', 'source', 'amount', 'status', 'created_at', 'processed_at'])
            ->where('affiliate_id', $this->affiliateId())
            ->latest()
            ->limit(5)
            ->get()
            ->map(function (Withdrawal $w) {
                $status = strtolower((string) $w->status);

                return [
                    'id' => $w->id,
                    'source_label' => Withdrawal::sourceLabel($w->source),
                    'amount' => (float) $w->amount,
                    'status' => in_array($status, ['completed', 'approved'], true)
                        ? 'completed'
                        : ($status === 'pending' ? 'pending' : 'rejected'),
                    'date' => $w->created_at?->format('d M Y, H:i'),
                    'eta' => $w->created_at?->copy()->addDays(Withdrawal::PROCESSING_DAYS)->format('d M Y'),
                    'processed_at' => $w->processed_at?->format('d M Y, H:i'),
                ];
            })
            ->all();
    }

    public function selectSource(string $source): void
    {
        if (in_array($source, [Withdrawal::SOURCE_COMMISSION, Withdrawal::SOURCE_WALLET], true)) {
            $this->source = $source;
            $this->resetValidation();
        }
    }

    public function setAmount(int $value): void
    {
        $this->amount = (string) $value;
        $this->resetValidation('amount');
    }

    public function setMaxAmount(): void
    {
        $this->amount = (string) (int) floor($this->availableBalance);
        $this->resetValidation('amount');
    }

    public function submit(): void
    {
        $this->validate([
            'source' => 'required|in:' . Withdrawal::SOURCE_COMMISSION . ',' . Withdrawal::SOURCE_WALLET,
            'amount' => 'required|integer|min:' . Withdrawal::MIN_AMOUNT,
        ], [
            'amount.required' => 'Masukkan jumlah penarikan.',
            'amount.integer' => 'Jumlah penarikan harus berupa angka bulat.',
            'amount.min' => 'Minimal penarikan Rp ' . number_format(Withdrawal::MIN_AMOUNT, 0, ',', '.') . '.',
        ]);

        $amount = (int) $this->amount;
        $source = $this->source;
        $affiliateId = $this->affiliateId();

        $withdrawal = DB::transaction(function () use ($amount, $source, $affiliateId) {
            $affiliate = Affiliate::select(['id', 'balance', 'bank_info'])
                ->lockForUpdate()
                ->findOrFail($affiliateId);

            if (blank($affiliate->bank_info)) {
                throw ValidationException::withMessages([
                    'amount' => 'Rekening pencairan belum diisi. Lengkapi dulu di halaman profil.',
                ]);
            }

            if ($source === Withdrawal::SOURCE_COMMISSION) {
                if ((float) $affiliate->balance < $amount) {
                    throw ValidationException::withMessages(['amount' => 'Saldo komisi tidak mencukupi.']);
                }

                $affiliate->decrement('balance', $amount);
            } else {
                $wallet = Wallet::select(['id', 'balance'])
                    ->where('affiliate_id', $affiliateId)
                    ->lockForUpdate()
                    ->first();

                if (!$wallet || (float) $wallet->balance < $amount) {
                    throw ValidationException::withMessages(['amount' => 'Saldo wallet tidak mencukupi.']);
                }
            }

            $withdrawal = Withdrawal::create([
                'affiliate_id' => $affiliateId,
                'source' => $source,
                'amount' => $amount,
                'bank_info' => $affiliate->bank_info,
                'status' => Withdrawal::STATUS_PENDING,
            ]);

            if ($source === Withdrawal::SOURCE_WALLET) {
                $wallet->debit(
                    $amount,
                    'WITHDRAWAL',
                    'Penarikan saldo wallet ke rekening (WD-' . $withdrawal->id . ')',
                    $withdrawal
                );
            }

            return $withdrawal;
        });

        Affiliate::find($affiliateId)?->notify(new AffiliateNotification(
            'Penarikan Diajukan',
            'Pengajuan penarikan ' . Withdrawal::sourceLabel($source) . ' sebesar Rp ' . number_format($amount, 0, ',', '.') . ' sedang diproses (maks. 3x24 jam).',
            'success'
        ));

        $this->submitted = [
            'id' => $withdrawal->id,
            'amount' => $amount,
            'source_label' => Withdrawal::sourceLabel($source),
            'eta' => now()->addDays(Withdrawal::PROCESSING_DAYS)->format('d M Y, H:i'),
        ];

        $this->amount = '';
        unset($this->summary, $this->availableBalance, $this->recentWithdrawals);
    }

    public function render()
    {
        return view('livewire.affiliate.withdraw-page', [
            'minAmount' => Withdrawal::MIN_AMOUNT,
        ]);
    }
}
