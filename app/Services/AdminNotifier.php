<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\AdminActivityNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

use function Illuminate\Support\defer;

/**
 * Kirim push notification ke semua perangkat admin yang sudah mengaktifkan notifikasi.
 * Best-effort: dikirim setelah transaksi DB commit dan setelah response, kegagalan hanya dicatat di log.
 */
class AdminNotifier
{
    public const ADMIN_ROLES = ['super_admin', 'admin'];

    public static function notify(string $title, string $body, string $url, string $tag = 'admin'): void
    {
        DB::afterCommit(fn () => defer(fn () => self::sendNow($title, $body, $url, $tag)));
    }

    public static function sendNow(string $title, string $body, string $url, string $tag = 'admin'): void
    {
        if (!config('services.admin_push.enabled')) {
            return;
        }

        try {
            $admins = User::whereIn('role', self::ADMIN_ROLES)->whereHas('pushSubscriptions')->get();

            if ($admins->isNotEmpty()) {
                Notification::send($admins, new AdminActivityNotification($title, $body, $url, $tag));
            }
        } catch (\Throwable $e) {
            Log::warning("Push admin gagal: {$title}", ['error' => $e->getMessage()]);
        }
    }

    public static function rupiah($amount): string
    {
        return 'Rp ' . number_format((float) $amount, 0, ',', '.');
    }
}
