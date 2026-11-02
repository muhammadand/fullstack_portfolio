<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\WalletDeposit;
use App\Models\WalletMutation;
use App\Services\ScalifyPayService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class WalletController extends Controller
{
    /**
     * Ambil riwayat mutasi wallet partner (Optimal Query & UI-Only Data Projection)
     */
    public function mutations(Request $request): JsonResponse|View
    {
        /** @var \App\Models\Affiliate $affiliate */
        $affiliate = Auth::guard('affiliate')->user();
        $wallet = $affiliate->getOrCreateWallet();

        // Query teroptimasi: Hanya mengambil kolom yang dipakai UI
        $query = WalletMutation::select([
            'id',
            'mutation_no',
            'type',
            'amount',
            'balance_after',
            'category',
            'description',
            'created_at',
        ])->where('wallet_id', $wallet->id);

        if ($request->filled('type') && in_array(strtoupper($request->type), ['CREDIT', 'DEBIT'])) {
            $query->where('type', strtoupper($request->type));
        }

        $mutations = $query->latest('id')->paginate(15);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'wallet'  => [
                    'balance' => (float) $wallet->balance,
                    'status'  => (string) $wallet->status,
                ],
                // Transformasi data agar hanya mengirim field yang dibutuhkan UI
                'mutations' => $mutations->through(fn ($m) => [
                    'mutation_no'   => $m->mutation_no,
                    'type'          => $m->type,
                    'amount'        => (float) $m->amount,
                    'balance_after' => (float) $m->balance_after,
                    'category'      => $m->category,
                    'description'   => $m->description,
                    'date_human'    => $m->created_at ? $m->created_at->format('d M Y, H:i') : '-',
                ]),
            ]);
        }

        return view('affiliate.wallet_mutations', compact('affiliate', 'wallet', 'mutations'));
    }

    /**
     * Buat permintaan top up / deposit saldo wallet via ScalifyPayService (QRIS)
     * Dilengkapi proteksi Idempotency (Anti-Spam / Anti-Duplicate Invoice)
     */
    public function depositStore(Request $request): RedirectResponse
    {
        /** @var \App\Models\Affiliate $affiliate */
        $affiliate = Auth::guard('affiliate')->user();
        $wallet = $affiliate->getOrCreateWallet();

        // Validasi ketat: Minimal 50.000 (50k)
        $request->validate([
            'amount' => 'required|numeric|min:50000|max:10000000',
            'notes'  => 'nullable|string|max:255',
        ], [
            'amount.required' => 'Nominal pengisian saldo wajib diisi.',
            'amount.min'      => 'Minimal pengisian saldo adalah Rp 50.000.',
            'amount.max'      => 'Maksimal pengisian saldo adalah Rp 10.000.000 per transaksi.',
        ]);

        $amount = (float) $request->amount;

        // Idempotency Guard: Cek apakah ada invoice pending dengan nominal sama dalam 2 menit terakhir
        $existingPending = WalletDeposit::select(['id', 'deposit_no', 'payment_url', 'expired_at'])
            ->where('affiliate_id', $affiliate->id)
            ->where('payment_status', 'pending')
            ->where('amount', $amount)
            ->where('created_at', '>=', now()->subMinutes(2))
            ->where('expired_at', '>', now())
            ->latest('id')
            ->first();

        if ($existingPending && !empty($existingPending->payment_url)) {
            return redirect()->route('affiliate.wallet.pay_qris', $existingPending->deposit_no)
                ->with('info', 'Anda memiliki tagihan QRIS aktif dengan nominal yang sama. Silakan lanjutkan pembayaran ini.');
        }

        // Biaya admin QRIS 2%
        $fee = (float) round($amount * 0.02);
        $totalAmount = (int) round($amount + $fee);

        $depositNo = 'DEP-' . date('YmdHis') . '-' . strtoupper(Str::random(4));

        $customerData = [
            'name'  => $affiliate->name,
            'email' => $affiliate->email ?? null,
            'phone' => $affiliate->phone ?? null,
        ];

        $itemDetails = [
            [
                'id'       => 'TOPUP-SALDO',
                'name'     => 'Top Up Saldo Wallet',
                'price'    => (int) round($amount),
                'quantity' => 1,
            ],
            [
                'id'       => 'FEE-ADMIN',
                'name'     => 'Biaya Layanan (2%)',
                'price'    => (int) round($fee),
                'quantity' => 1,
            ],
        ];

        // Request QRIS ke ScalifyPayService Gateway
        $chargeResult = ScalifyPayService::chargeQris(
            $depositNo,
            $totalAmount,
            $customerData,
            $itemDetails,
            'gopay',
            30
        );

        if (!$chargeResult['success']) {
            return redirect()->back()->with('error', $chargeResult['message'] ?? 'Gagal membuat QRIS pembayaran. Silakan coba beberapa saat lagi.');
        }

        $chargeData = $chargeResult['data'] ?? [];

        $deposit = WalletDeposit::create([
            'deposit_no'        => $depositNo,
            'affiliate_id'      => $affiliate->id,
            'wallet_id'         => $wallet->id,
            'amount'            => $amount,       // Saldo murni yang akan masuk ke wallet partner
            'fee'               => $fee,          // Biaya admin 2%
            'unique_code'       => 0,
            'total_amount'      => $totalAmount,  // Total tagihan QRIS
            'payment_method'    => 'qris',
            'payment_status'    => 'pending',
            'payment_reference' => $chargeData['transaction_id'] ?? $depositNo,
            'payment_url'       => $chargeData['qr_image_url'] ?? null,
            'gateway_response'  => $chargeData,
            'expired_at'        => now()->addMinutes(30),
            'notes'             => $request->notes,
        ]);

        return redirect()->route('affiliate.wallet.pay_qris', $deposit->deposit_no)
            ->with('success', 'Kode QRIS berhasil dibuat. Silakan scan dan selesaikan pembayaran.');
    }

    /**
     * Tampilkan halaman instruksi pembayaran QRIS (Optimal Projection)
     */
    public function payQris(string $depositNo): View|RedirectResponse
    {
        /** @var \App\Models\Affiliate $affiliate */
        $affiliate = Auth::guard('affiliate')->user();

        // Query teroptimasi: Hanya mengambil kolom yang dipakai view tiket QRIS
        $deposit = WalletDeposit::select([
            'id',
            'deposit_no',
            'affiliate_id',
            'wallet_id',
            'amount',
            'fee',
            'total_amount',
            'payment_method',
            'payment_status',
            'payment_url',
            'gateway_response',
            'expired_at',
        ])
        ->where('deposit_no', $depositNo)
        ->where('affiliate_id', $affiliate->id)
        ->firstOrFail();

        // Jika sudah dibayar, langsung alihkan ke dashboard dengan pesan sukses
        if ($deposit->payment_status === 'paid') {
            return redirect()->route('affiliate.dashboard')
                ->with('success', "Deposit #{$depositNo} sebesar Rp " . number_format($deposit->amount, 0, ',', '.') . " telah lunas dan saldo sudah masuk ke wallet Anda!");
        }

        $gatewayData = $deposit->gateway_response ?? [];
        $qrImageUrl = $gatewayData['qr_image_url'] ?? $deposit->payment_url ?? null;

        return view('affiliate.wallet.qris_payment', compact('affiliate', 'deposit', 'gatewayData', 'qrImageUrl'));
    }

    /**
     * Endpoint AJAX Polling status deposit (Super Lean Query & Output Khusus UI)
     */
    public function checkDepositStatus(string $depositNo): JsonResponse
    {
        /** @var \App\Models\Affiliate $affiliate */
        $affiliate = Auth::guard('affiliate')->user();

        // Query sangat ringan: hanya mengambil field status dan amount
        $deposit = WalletDeposit::select(['id', 'deposit_no', 'payment_status', 'amount'])
            ->where('deposit_no', $depositNo)
            ->where('affiliate_id', $affiliate->id)
            ->first();

        if (!$deposit) {
            return response()->json([
                'success' => false,
                'message' => 'Deposit tidak ditemukan.',
            ], 404);
        }

        // Ambil saldo langsung via single indexed value query tanpa load seluruh model
        $currentBalance = Wallet::where('affiliate_id', $affiliate->id)->value('balance') ?? 0.00;

        return response()->json([
            'success'        => true,
            'deposit_no'     => $deposit->deposit_no,
            'payment_status' => $deposit->payment_status,
            'is_paid'        => ($deposit->payment_status === 'paid'),
            'amount'         => (float) $deposit->amount,
            'wallet_balance' => (float) $currentBalance,
        ]);
    }
}
