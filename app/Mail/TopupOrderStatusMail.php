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
        $subject = match ($this->event) {
            'paid'    => 'Pembayaran Diterima',
            'success' => 'Top Up Berhasil',
            'failed'  => 'Top Up Gagal Diproses',
        };

        return new Envelope(subject: "{$subject} - #{$this->order->order_no}");
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

        return [
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
                'title'   => 'Top Up Berhasil',
                'badge'   => 'Berhasil',
                'message' => 'Pesananmu sudah berhasil dikirim ke akun tujuan. Terima kasih sudah bertransaksi di ' . $brand . '.',
                'icon'    => '&#10003;',
                'color'   => '#059669',
                'soft'    => '#ECFDF5',
                'ring'    => '#A7F3D0',
            ],
            'failed' => [
                'title'   => 'Top Up Gagal Diproses',
                'badge'   => 'Gagal',
                'message' => 'Mohon maaf, pesananmu gagal diproses oleh sistem. Silakan hubungi admin dengan menyertakan nomor order di bawah agar segera kami bantu.',
                'icon'    => '&#33;',
                'color'   => '#DC2626',
                'soft'    => '#FEF2F2',
                'ring'    => '#FECACA',
            ],
        ][$this->event];
    }
}
