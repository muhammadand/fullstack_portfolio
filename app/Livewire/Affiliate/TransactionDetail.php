<?php

namespace App\Livewire\Affiliate;

use App\Models\Commission;
use App\Models\WalletMutation;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TransactionDetail extends Component
{
    public string $type = '';
    public string $trxId = '';
    public ?array $trx = null;
    public string $copiedField = '';

    public function mount(string $type, string $id): void
    {
        $this->type = strtolower($type);
        $this->trxId = $id;

        $this->loadTransaction();
    }

    /**
     * Memuat data transaksi dengan lean UI query projection (hanya kolom yang diperlukan UI)
     */
    public function loadTransaction(): void
    {
        /** @var \App\Models\Affiliate|null $affiliate */
        $affiliate = Auth::guard('affiliate')->user();
        if (!$affiliate) {
            abort(401, 'Silakan login terlebih dahulu.');
        }

        switch ($this->type) {
            case 'commission':
            case 'komisi':
                $record = Commission::select(['id', 'amount', 'description', 'status', 'created_at'])
                    ->where('id', $this->trxId)
                    ->where('affiliate_id', $affiliate->id)
                    ->firstOrFail();

                $amount = (float) $record->amount;
                $this->trx = [
                    'type' => 'CREDIT',
                    'amount' => $amount,
                    'amount_formatted' => 'Rp ' . number_format($amount, 0, ',', '.'),
                    'total' => $amount,
                    'total_formatted' => 'Rp ' . number_format($amount, 0, ',', '.'),
                    'status' => 'Transaksi Berhasil',
                    'status_color' => 'emerald',
                    'status_icon' => 'fa-circle-check',
                    'title' => $record->description ?: 'Komisi Kemitraan Scalify',
                    'date' => $record->created_at ? $record->created_at->format('d M Y, H:i') . ' WIB' : '-',
                    'ref_no' => 'KOM-' . $record->id,
                    'category' => 'Komisi Afiliasi',
                    'method' => 'Program Kemitraan Scalify',
                    'balance_after' => null,
                    'notes' => $record->description ?: 'Komisi closing project website/leads terverifikasi.',
                    'proof_url' => null,
                ];
                break;

            case 'withdrawal':
            case 'penarikan':
            case 'tarik':
                $record = Withdrawal::select(['id', 'source', 'amount', 'bank_info', 'status', 'proof_of_payment', 'processed_at', 'created_at'])
                    ->where('id', $this->trxId)
                    ->where('affiliate_id', $affiliate->id)
                    ->firstOrFail();

                $rawStatus = strtolower($record->status ?? 'pending');
                $statusText = 'Menunggu Proses';
                $statusColor = 'amber';
                $statusIcon = 'fa-clock';

                if ($rawStatus === 'completed') {
                    $statusText = 'Transaksi Berhasil';
                    $statusColor = 'emerald';
                    $statusIcon = 'fa-circle-check';
                } elseif (in_array($rawStatus, ['rejected', 'ditolak', 'failed'])) {
                    $statusText = 'Transaksi Dibatalkan';
                    $statusColor = 'rose';
                    $statusIcon = 'fa-circle-xmark';
                }

                $amount = (float) $record->amount;
                $sourceLabel = Withdrawal::sourceLabel($record->source);
                $statusNote = $rawStatus === 'pending'
                    ? 'Diproses maks. 3x24 jam (estimasi ' . $record->created_at?->copy()->addDays(Withdrawal::PROCESSING_DAYS)->format('d M Y') . ').'
                    : ($record->processed_at ? 'Ditransfer pada ' . $record->processed_at->format('d M Y, H:i') . ' WIB.' : 'Status: ' . ucfirst($record->status) . '.');
                $this->trx = [
                    'type' => 'DEBIT',
                    'amount' => $amount,
                    'amount_formatted' => 'Rp ' . number_format($amount, 0, ',', '.'),
                    'total' => $amount,
                    'total_formatted' => 'Rp ' . number_format($amount, 0, ',', '.'),
                    'status' => $statusText,
                    'status_color' => $statusColor,
                    'status_icon' => $statusIcon,
                    'title' => 'Penarikan ' . $sourceLabel,
                    'date' => $record->created_at ? $record->created_at->format('d M Y, H:i') . ' WIB' : '-',
                    'ref_no' => 'WD-' . $record->id,
                    'category' => 'Pencairan Dana (Withdrawal)',
                    'method' => $record->bank_info ?: 'Rekening Bank Terdaftar',
                    'balance_after' => null,
                    'notes' => 'Pencairan ' . strtolower($sourceLabel) . ' ke: ' . ($record->bank_info ?: '-') . '. ' . $statusNote,
                    'proof_url' => $record->proof_of_payment ? asset('storage/' . $record->proof_of_payment) : null,
                ];
                break;

            case 'mutation':
            case 'mutasi':
            case 'wallet':
            case 'topup':
            case 'ppob':
            default:
                $record = WalletMutation::select([
                    'id',
                    'mutation_no',
                    'type',
                    'amount',
                    'balance_before',
                    'balance_after',
                    'category',
                    'description',
                    'created_at'
                ])
                    ->where('affiliate_id', $affiliate->id)
                    ->where(function ($q) {
                        $q->where('id', $this->trxId)
                            ->orWhere('mutation_no', $this->trxId);
                    })
                    ->firstOrFail();

                $isCredit = ($record->type === 'CREDIT');
                $amount = (float) $record->amount;
                $balanceAfter = $record->balance_after !== null ? (float) $record->balance_after : null;

                $this->trx = [
                    'type' => $record->type,
                    'amount' => $amount,
                    'amount_formatted' => 'Rp ' . number_format($amount, 0, ',', '.'),
                    'total' => $amount,
                    'total_formatted' => 'Rp ' . number_format($amount, 0, ',', '.'),
                    'status' => 'Transaksi Berhasil',
                    'status_color' => 'emerald',
                    'status_icon' => 'fa-circle-check',
                    'title' => $record->description ?: ($isCredit ? 'Top Up Saldo Wallet' : 'Transaksi Produk Digital'),
                    'date' => $record->created_at ? $record->created_at->format('d M Y, H:i') . ' WIB' : '-',
                    'ref_no' => $record->mutation_no,
                    'category' => $record->category ?: ($isCredit ? 'Top Up Saldo' : 'Transaksi Produk Digital'),
                    'method' => $isCredit ? 'QRIS' : 'Saldo Wallet Scalify',
                    'balance_after' => $balanceAfter !== null ? 'Rp ' . number_format($balanceAfter, 0, ',', '.') : null,
                    'notes' => $record->description ?: ($isCredit ? 'Top up saldo wallet berhasil diproses.' : 'Pembayaran produk digital via wallet.'),
                    'proof_url' => null,
                ];
                break;
        }
    }

    public function render()
    {
        return view('livewire.affiliate.transaction-detail');
    }
}
