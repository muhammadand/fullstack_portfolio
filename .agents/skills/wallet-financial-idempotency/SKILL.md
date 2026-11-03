---
name: wallet-financial-idempotency
description: Best practices and mandatory patterns for wallet financial transactions, row-level locking, strict idempotency, lean UI query projections, and unit testing in Laravel.
category: backend
---

# Wallet Financial & Idempotency Standard

Standar arsitektur dan pola penulisan kode untuk modul finansial (Wallet, Deposit, Mutasi Saldo, dan PPOB) di proyek ini. Wajib diikuti untuk mencegah kecurangan *double-spending*, duplikasi kredit saat *webhook retry*, serta menjaga performa query tetap *ultra-lean*.

---

## 1. Atomic Transaction & Row-Level Locking (`lockForUpdate`)

Setiap operasi yang memodifikasi saldo (`balance`) **TIDAK BOLEH** hanya melakukan `UPDATE wallets SET balance = balance + amount`.

Wajib menggunakan transaksi database dan penguncian baris (`lockForUpdate()`):

```php
use Illuminate\Support\Facades\DB;

public function credit(float $amount, string $category, ?string $description = null, $reference = null): WalletMutation
{
    if ($amount <= 0) {
        throw new \InvalidArgumentException('Nominal kredit harus lebih besar dari 0.');
    }

    return DB::transaction(function () use ($amount, $category, $description, $reference) {
        // 1. Kunci baris wallet untuk menghindari balapan request (Race Condition)
        $lockedWallet = self::where('id', $this->id)->lockForUpdate()->firstOrFail();

        $balanceBefore = (float) $lockedWallet->balance;
        $balanceAfter = $balanceBefore + $amount;

        $lockedWallet->balance = $balanceAfter;
        $lockedWallet->save();

        // 2. Catat audit trail mutasi saldo secara atomik
        return WalletMutation::create([
            'mutation_no'    => 'MUT-' . date('YmdHis') . '-' . strtoupper(Str::random(4)),
            'affiliate_id'   => $lockedWallet->affiliate_id,
            'wallet_id'      => $lockedWallet->id,
            'type'           => 'CREDIT',
            'amount'         => $amount,
            'balance_before' => $balanceBefore,
            'balance_after'  => $balanceAfter,
            'category'       => $category,
            'reference_type' => $reference ? get_class($reference) : null,
            'reference_id'   => $reference ? $reference->id : null,
            'description'    => $description,
        ]);
    });
}
```

---

## 2. Strict Idempotent Settlement (`markAsPaid`)

Gateway pembayaran seperti Midtrans atau Scalify Pay dapat mengirimkan *webhook callback* berulang kali (retries) jika respons acknowledgment sedikit terlambat.

Pengecekan status `payment_status === 'paid'` **WAJIB** berada di dalam `DB::transaction()` bersama `lockForUpdate()`, bukan di luarnya:

```php
public function markAsPaid(?string $reference = null, ?array $gatewayResponse = null): bool
{
    return DB::transaction(function () use ($reference, $gatewayResponse) {
        // Lock baris deposit
        $lockedDeposit = self::where('id', $this->id)->lockForUpdate()->firstOrFail();

        // Jika sudah lunas, langsung keluar (Idempoten No-Op)
        if ($lockedDeposit->payment_status === 'paid') {
            return false;
        }

        $lockedDeposit->payment_status = 'paid';
        $lockedDeposit->paid_at = now();
        if ($reference) $lockedDeposit->payment_reference = $reference;
        if ($gatewayResponse) $lockedDeposit->gateway_response = $gatewayResponse;
        $lockedDeposit->save();

        // Kreditkan saldo ke wallet
        $wallet = Wallet::where('id', $lockedDeposit->wallet_id)->firstOrFail();
        $wallet->credit(
            (float) $lockedDeposit->amount,
            'DEPOSIT',
            "Top up saldo via {$lockedDeposit->payment_method} #{$lockedDeposit->deposit_no}",
            $lockedDeposit
        );

        return true;
    });
}
```

---

## 3. Idempotency Guard pada Pembuatan Tagihan (Anti-Spam)

Cegah pengguna menekan tombol *submit* berkali-kali secara cepat (*rapid double-click*) yang dapat memicu pembuatan banyak invoice/QRIS duplikat:

```php
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
        ->with('info', 'Anda memiliki tagihan QRIS aktif dengan nominal yang sama.');
}
```

---

## 4. Optimal Query & UI-Only Data Projection

Hindari penggunaan `SELECT *` yang membengkak di memori server dan berisiko membocorkan data sensitif:
- **Hanya pilih kolom yang ditampilkan UI:**
  `WalletMutation::select(['id', 'mutation_no', 'type', 'amount', 'balance_after', 'category', 'description', 'created_at'])`
- **Output JSON yang terkurasi (*Lean Response*):**
  Jangan mereturn seluruh objek Eloquent mentah. Gunakan resource/transformasi eksplisit sehingga hanya field yang relevan untuk UI (misal: `date_human`, `balance_after`, `amount`) yang dikirim ke frontend.
- **Single Indexed Value Lookup:**
  Untuk mengambil saldo pada polling ringan, gunakan:
  `$balance = Wallet::where('affiliate_id', $affiliate->id)->value('balance') ?? 0.00;`
  tanpa memuat seluruh model ke memori.

---

## 5. Mandatory Automated Testing

Setiap modifikasi logika finansial wajib diuji dengan PHPUnit/Pest:
- `tests/Unit/WalletFinancialLogicTest.php`: Menguji integritas atomik `credit()`, `debit()`, pencegahan saldo minus, dan idempotensi `markAsPaid()`.
- `tests/Feature/WalletControllerTest.php`: Menguji proteksi otorisasi, validasi nominal minimal (>= 50k), *idempotency guard*, dan struktur response UI.
- `tests/Feature/AffiliateHistoryTest.php`: Menguji halaman riwayat transaksi mobile, pemisahan dual-pocket (Komisi vs Wallet PPOB), dan proyeksi kolom lean UI.
- `tests/Unit/PaymentWebhookServiceTest.php`: Menguji normalisasi payload multi-gateway, validasi SHA-512 signature, settlement atomik, idempotensi retry, dan penanganan expired/failed.
- `tests/Feature/PaymentCallbackControllerTest.php`: Menguji endpoint HTTP webhook (`/payment/callback`, `/webhook/payment`, dll.), penolakan 422 untuk missing ID, 403 untuk invalid signature, dan persistensi audit log.

---

## 6. High-Performance Webhook Architecture (`PaymentWebhookService`)

- **Decoupled Controller**: `PaymentCallbackController` ramping (~35 baris) hanya mendelegasikan ke `PaymentWebhookService`.
- **Fast Prefix Routing**:
  - `DEP-` -> Langsung query `WalletDeposit::where('deposit_no', ...)` (indexed, sub-milidetik).
  - `GCO-` -> Langsung query `GoogleCardOrder::where('order_id', ...)`.
  - `RVN-` / `CHR-` -> Langsung query `Booking::where('booking_code', ...)`.
  - Hindari melakukan query lambat pada kolom JSON `raw_response->...` pada setiap request masuk.
- **Immutable Audit Trail**: Selalu simpan payload webhook mentah ke tabel `payment_callbacks` sebelum dispatch order untuk kebutuhan forensik dan debugging.


