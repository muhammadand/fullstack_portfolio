<?php

namespace App\Services;

use App\Mail\TopupOrderStatusMail;
use App\Models\Order;
use App\Models\OrderEvent;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Kirim email status order langsung (tanpa queue) bila pembeli mengisi email.
 * Gagal kirim (SMTP down, dll.) hanya dicatat (log + jejak audit) agar webhook pembayaran/Digiflazz tetap sukses.
 */
class TopupOrderMailer
{
    public static function send(Order $order, string $event): void
    {
        if (blank($order->email)) {
            return;
        }

        // Email disamarkan di jejak audit (minimasi data pribadi); alamat lengkap tetap ada di tabel orders.
        $context = ['mail_event' => $event, 'to' => self::mask($order->email)];

        try {
            Mail::to($order->email)->send(new TopupOrderStatusMail($order, $event));
            OrderEvent::safeRecord($order, OrderEvent::NOTIFICATION_SENT, ['context' => $context]);
        } catch (\Throwable $e) {
            Log::warning("Order #{$order->order_no}: gagal kirim email '{$event}' ke {$order->email}.", [
                'error' => $e->getMessage(),
            ]);
            OrderEvent::safeRecord($order, OrderEvent::NOTIFICATION_FAILED, [
                'context' => $context + ['error' => mb_substr($e->getMessage(), 0, 500)],
            ]);
        }
    }

    /** andi@contoh.com -> a***@contoh.com */
    public static function mask(string $email): string
    {
        [$local, $domain] = array_pad(explode('@', $email, 2), 2, '');

        return mb_substr($local, 0, 1) . '***@' . $domain;
    }
}
