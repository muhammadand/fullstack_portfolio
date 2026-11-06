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
        return new Content(view: 'emails.topup-order-status');
    }
}
