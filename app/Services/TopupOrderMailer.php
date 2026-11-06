<?php

namespace App\Services;

use App\Mail\TopupOrderStatusMail;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Kirim email status order langsung (tanpa queue) bila pembeli mengisi email.
 * Gagal kirim (SMTP down, dll.) hanya dicatat di log agar webhook pembayaran/Digiflazz tetap sukses.
 */
class TopupOrderMailer
{
    public static function send(Order $order, string $event): void
    {
        if (blank($order->email)) {
            return;
        }

        try {
            Mail::to($order->email)->send(new TopupOrderStatusMail($order, $event));
        } catch (\Throwable $e) {
            Log::warning("Order #{$order->order_no}: gagal kirim email '{$event}' ke {$order->email}.", [
                'error' => $e->getMessage(),
            ]);
        }
    }
}
