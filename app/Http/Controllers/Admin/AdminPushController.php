<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminNotifier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AdminActivityNotification;

/** Daftarkan / lepas perangkat (HP) admin untuk push notification. */
class AdminPushController extends Controller
{
    public function subscribe(Request $request): JsonResponse
    {
        $data = $request->validate([
            'endpoint'    => ['required', 'url', 'max:500'],
            'keys.auth'   => ['required', 'string', 'max:255'],
            'keys.p256dh' => ['required', 'string', 'max:255'],
        ]);

        if (!in_array($request->user()->role, AdminNotifier::ADMIN_ROLES, true)) {
            return response()->json(['success' => false, 'message' => 'Hanya admin yang bisa menerima notifikasi.'], 403);
        }

        $request->user()->updatePushSubscription($data['endpoint'], $data['keys']['p256dh'], $data['keys']['auth']);

        return response()->json(['success' => true]);
    }

    public function unsubscribe(Request $request): JsonResponse
    {
        $data = $request->validate(['endpoint' => ['required', 'string', 'max:500']]);
        $request->user()->deletePushSubscription($data['endpoint']);

        return response()->json(['success' => true]);
    }

    /** Kirim notifikasi uji ke semua perangkat admin yang sedang login. */
    public function test(Request $request): JsonResponse
    {
        if (!$request->user()->pushSubscriptions()->exists()) {
            return response()->json(['success' => false, 'message' => 'Perangkat ini belum mengaktifkan notifikasi.'], 422);
        }

        Notification::send($request->user(), new AdminActivityNotification(
            'Notifikasi admin aktif', 'Kamu akan menerima kabar top up, pesanan, pendaftaran, dan penarikan di HP ini.',
            route('dashboard.admin'), 'admin-test'
        ));

        return response()->json(['success' => true]);
    }
}
