<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Notifikasi status order produk digital ke email pembeli.
 * Event: paid (pembayaran diterima, sedang diproses), success (item terkirim), failed (gagal dikirim).
 */
class TopupOrderStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public const EVENTS = ['paid', 'success', 'failed'];

    public function __construct(public Order $order, public string $event)
    {
        if (!in_array($event, self::EVENTS, true)) {
            throw new \InvalidArgumentException("Event email order tidak dikenal: {$event}");
        }
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: "{$this->meta()['title']} - #{$this->order->order_no}");
    }

    public function content(): Content
    {
        return new Content(view: 'emails.topup-order-status', with: ['meta' => $this->meta()]);
    }

    /**
     * Teks & warna per event. Sengaja di sini (bukan di @php Blade) agar tidak rusak oleh formatter Blade.
     */
    public function meta(): array
    {
        $brand = config('mail.from.name');
        $order = $this->order;
        // Top up game tetap memakai kata "Top Up"; jenis lain memakai labelnya (Pulsa, Paket Data, ...).
        $label = ($order->source ?? Order::SOURCE_TOPUP_GAME) === Order::SOURCE_TOPUP_GAME ? 'Top Up' : $order->sourceLabel();
        $wallet = $order->isWalletPayment();
        $refund = $order->refunded_at
            ? ' Dana sebesar Rp ' . number_format((float) $order->total_amount, 0, ',', '.') . ' sudah dikembalikan ke '
                . ($wallet ? 'wallet kamu.' : 'saldo akun kamu dan bisa ditarik ke e-wallet.')
            : '';

        $cta = match (true) {
            $wallet             => ['cta_url' => route(\App\Http\Controllers\Affiliate\PpobController::typeForSource($order->source)['route']), 'cta_label' => 'Beli Lagi'],
            (bool) $order->refunded_at => ['cta_url' => route('customer.account'), 'cta_label' => 'Lihat Saldo'],
            default             => ['cta_url' => route('topup.index'), 'cta_label' => 'Top Up Lagi'],
        };

        return $cta + [
            'paid' => [
                'title'   => 'Pembayaran Diterima',
                'badge'   => 'Sedang Diproses',
                'message' => 'Terima kasih, pembayaranmu sudah kami terima. Pesanan sedang diproses dan biasanya masuk ke akun tujuan dalam beberapa menit.',
                'icon'    => '&#8635;',
                'color'   => '#2563EB',
                'soft'    => '#EFF6FF',
                'ring'    => '#BFDBFE',
            ],
            'success' => [
                'title'   => "{$label} Berhasil",
                'badge'   => 'Berhasil',
                'message' => 'Pesananmu sudah berhasil dikirim ke akun tujuan. Terima kasih sudah bertransaksi di ' . $brand . '.',
                'icon'    => '&#10003;',
                'color'   => '#059669',
                'soft'    => '#ECFDF5',
                'ring'    => '#A7F3D0',
            ],
            'failed' => [
                'title'   => "{$label} Gagal Diproses",
                'badge'   => 'Gagal',
                'message' => match (true) {
                    $wallet || (bool) $order->refunded_at => 'Mohon maaf, pesananmu gagal diproses oleh supplier.' . $refund . ' Silakan coba lagi atau hubungi admin dengan menyertakan nomor order di bawah.',
                    default => 'Mohon maaf, pesananmu gagal diproses oleh sistem. Silakan hubungi admin dengan menyertakan nomor order di bawah agar segera kami bantu.',
                },
                'icon'    => '&#33;',
                'color'   => '#DC2626',
                'soft'    => '#FEF2F2',
                'ring'    => '#FECACA',
            ],
        ][$this->event];
    }
}
