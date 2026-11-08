<?php

namespace App\Support;

use App\Models\Affiliate;
use App\Models\Booking;
use App\Models\CareerApplication;
use App\Models\CustomerWithdrawal;
use App\Models\Order;
use App\Models\Withdrawal;
use App\Services\AdminNotifier as N;
use Illuminate\Support\Facades\Auth;

/**
 * Daftar kejadian yang dikirim sebagai push ke HP admin saat data DIBUAT.
 * Kejadian "sudah dibayar" / "gagal" dipanggil langsung di PaymentWebhookService & DigiflazzFulfillmentService.
 */
class AdminActivityHooks
{
    public static function register(): void
    {
        Affiliate::created(function (Affiliate $a) {
            if (self::byAdmin()) return;
            N::notify('Partner baru mendaftar', "{$a->name} ({$a->email}) menunggu approval.",
                route('admin.affiliates.index', ['status' => 'pending']), 'affiliate-' . $a->id);
        });

        CareerApplication::created(function (CareerApplication $c) {
            N::notify('Lamaran kerja masuk', trim($c->full_name . ' melamar ' . ($c->career?->title ?? 'posisi terbuka')) . '.',
                route('career-applications.index'), 'career-' . $c->id);
        });

        Booking::created(function (Booking $b) {
            if (self::byAdmin()) return;
            N::notify('Booking travel baru', "Kode {$b->booking_code} · {$b->total_passengers} penumpang.",
                route('admin.travel_bookings.index'), 'booking-' . $b->id);
        });

        Order::created(function (Order $o) {
            // Order partner dibayar saldo (langsung lunas). Top up game dikabari saat pembayaran masuk.
            if ($o->isWalletPayment()) {
                N::notify("Order {$o->sourceLabel()} partner", "{$o->product_name} ke {$o->customer_no} · " . N::rupiah($o->total_amount),
                    route('admin.orders.show', $o), 'order-' . $o->id);
            }
        });

        Withdrawal::created(function (Withdrawal $w) {
            N::notify('Partner ajukan penarikan', N::rupiah($w->amount) . ' menunggu diproses.',
                route('admin.withdrawals.index'), 'withdrawal-' . $w->id);
        });

        CustomerWithdrawal::created(function (CustomerWithdrawal $w) {
            N::notify('Customer ajukan penarikan', 'Transfer ' . N::rupiah($w->net_amount) . " ke {$w->ewallet} {$w->account_no}.",
                route('admin.customer_withdrawals.index'), 'customer-withdrawal-' . $w->id);
        });
    }

    /** Data yang dibuat admin sendiri dari panel tidak perlu dikabarkan ke admin. */
    private static function byAdmin(): bool
    {
        return Auth::guard('web')->check();
    }
}
