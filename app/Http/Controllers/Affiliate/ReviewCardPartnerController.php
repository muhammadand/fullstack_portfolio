<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Services\QrisPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReviewCardPartnerController extends Controller
{
    /**
     * Display Partner Reseller Hub for Google Review Cards.
     */
    public function index(Request $request)
    {
        $affiliate = Auth::guard('affiliate')->user();

        // 1. Agregat statistik milik partner (hanya kartu yang sudah lunas/terverifikasi)
        $stats = DB::table('review_cards')
            ->where('affiliate_id', $affiliate->id)
            ->where('payment_status', 'paid')
            ->selectRaw('
                COUNT(*) as total_cards,
                SUM(CASE WHEN status = "active" THEN 1 ELSE 0 END) as active_cards,
                SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as ready_cards,
                COALESCE(SUM(total_scans), 0) as total_scans
            ')
            ->first();

        // 2. Cek apakah ada pesanan QRIS yang sedang pending / diproses
        $pendingOrderCards = DB::table('review_cards')
            ->where('affiliate_id', $affiliate->id)
            ->where('payment_status', 'pending')
            ->whereNotNull('notes')
            ->orderBy('id', 'desc')
            ->get();

        $pendingOrders = [];
        foreach ($pendingOrderCards as $card) {
            $notes = json_decode($card->notes, true);
            if ($notes && isset($notes['order_id'])) {
                $oid = $notes['order_id'];
                if (!isset($pendingOrders[$oid])) {
                    $pendingOrders[$oid] = $notes;
                }
            }
        }

        // 3. Query daftar kartu lunas milik partner
        $query = DB::table('review_cards')
            ->where('affiliate_id', $affiliate->id)
            ->where('payment_status', 'paid')
            ->select([
                'id',
                'serial_number',
                'slug',
                'activation_code',
                'business_name',
                'google_review_url',
                'status',
                'buy_price',
                'total_scans',
                'purchased_at',
                'activated_at',
                'created_at',
            ]);

        // Filter status kartu milik partner
        if ($request->filled('filter')) {
            if ($request->filter === 'ready') {
                $query->where('status', 'pending');
            } elseif ($request->filter === 'active') {
                $query->where('status', 'active');
            }
        }

        // Pencarian serial atau nama toko klien
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('serial_number', 'like', "%{$search}%")
                    ->orWhere('business_name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        $perPage = (int) $request->get('per_page', 4);
        $myCards = $query->orderBy('id', 'desc')->paginate($perPage)->withQueryString();

        return view('affiliate.review_cards.index', compact('affiliate', 'stats', 'pendingOrders', 'myCards'));
    }

    /**
     * Partner creates a QRIS dynamic order to buy review card stock.
     */
    public function buy(Request $request)
    {
        $affiliate = Auth::guard('affiliate')->user();

        $validated = $request->validate([
            'quantity' => 'required|integer|in:1,5,10',
        ]);

        $qty = (int) $validated['quantity'];

        // Paket Harga Reseller:
        // 1 Unit = Rp 10.000
        // 5 Unit = Rp 45.000 (Hemat 5rb)
        // 10 Unit = Rp 80.000 (Hemat 20rb)
        $pricing = [
            1  => 10000,
            5  => 45000,
            10 => 80000,
        ];

        $totalCost = $pricing[$qty] ?? ($qty * 10000);

        // 1. Generate unique Order ID
        $orderId = 'RC-' . date('ymd') . '-' . strtoupper(Str::random(4));

        // 2. Request QRIS Dinamis ke Payment Gateway Scalify
        $customerData = [
            'name'  => $affiliate->name,
            'email' => $affiliate->email ?? null,
            'phone' => null,
        ];

        $qrisResponse = QrisPaymentService::createDynamicQris($orderId, $totalCost, $customerData, 'DANA');

        if (!$qrisResponse['success']) {
            return redirect()->back()->with('error', $qrisResponse['message'] ?? 'Gagal membuat QRIS pembayaran. Silakan coba kembali beberapa saat lagi.');
        }

        $qrisData = $qrisResponse['data'];

        // 3. Catat stok reservasi dengan payment_status = pending
        DB::transaction(function () use ($affiliate, $qty, $totalCost, $orderId, $qrisData) {
            $now = now();
            $orderNotes = json_encode([
                'order_id'     => $orderId,
                'qris_id'      => $qrisData['id'],
                'base_amount'  => $qrisData['base_amount'],
                'unique_code'  => $qrisData['unique_code'],
                'total_amount' => $qrisData['total_amount'],
                'qris_payload' => $qrisData['qris_payload'],
                'expires_at'   => $qrisData['expires_at'],
                'provider'     => $qrisData['provider'],
                'quantity'     => $qty,
                'ordered_at'   => $now->toIso8601String(),
            ]);

            for ($i = 0; $i < $qty; $i++) {
                $uniqueHex = strtoupper(Str::random(4));
                $serialNumber = "SCL-" . date('ym') . "-{$uniqueHex}";
                $slug = Str::lower(Str::random(6));
                $pin = (string) random_int(100000, 999999);

                DB::table('review_cards')->insert([
                    'serial_number'   => $serialNumber,
                    'slug'            => $slug,
                    'activation_code' => $pin,
                    'status'          => 'pending',
                    'buy_price'       => (int) round($totalCost / $qty),
                    'payment_status'  => 'pending', // Menunggu Verifikasi Admin
                    'affiliate_id'    => $affiliate->id,
                    'notes'           => $orderNotes,
                    'created_at'      => $now,
                    'updated_at'      => $now,
                ]);
            }
        });

        // 4. Arahkan partner langsung ke halaman QRIS untuk pembayaran
        return redirect()->route('affiliate.review_cards.pay', $orderId)
            ->with('success', "QRIS pembayaran berhasil dibuat. Silakan scan dan lakukan pembayaran.");
    }

    /**
     * Display the QRIS payment instruction page for the partner.
     */
    public function payOrder(string $orderId)
    {
        $affiliate = Auth::guard('affiliate')->user();

        // Cari kartu pesanan
        $card = DB::table('review_cards')
            ->where('affiliate_id', $affiliate->id)
            ->where('notes', 'like', "%{$orderId}%")
            ->first();

        if (!$card) {
            return redirect()->route('affiliate.review_cards.index')
                ->with('error', 'Data pesanan tidak ditemukan.');
        }

        $orderData = json_decode($card->notes, true);

        // Jika pesanan sudah diverifikasi admin, langsung arahkan ke index
        if ($card->payment_status === 'paid') {
            return redirect()->route('affiliate.review_cards.index')
                ->with('success', "Pesanan #{$orderId} telah diverifikasi dan lunas! Kuota kartu sudah tersedia.");
        }

        return view('affiliate.review_cards.qris_payment', compact('affiliate', 'orderData', 'orderId'));
    }

    /**
     * Show printable design card for partner to download and print.
     */
    public function printCard(int $id)
    {
        $affiliate = Auth::guard('affiliate')->user();

        $card = DB::table('review_cards')
            ->where('id', $id)
            ->where('affiliate_id', $affiliate->id)
            ->where('payment_status', 'paid')
            ->first();

        if (!$card) {
            return redirect()->route('affiliate.review_cards.index')
                ->with('error', 'Kartu tidak ditemukan atau belum aktif.');
        }

        return view('affiliate.review_cards.print', compact('card', 'affiliate'));
    }

    /**
     * Partner helps local client activate the card on the spot.
     */
    public function activateForClient(Request $request, int $id, \App\Services\GoogleMapsService $mapsService)
    {
        $affiliate = Auth::guard('affiliate')->user();

        $card = DB::table('review_cards')
            ->where('id', $id)
            ->where('affiliate_id', $affiliate->id)
            ->where('payment_status', 'paid')
            ->first();

        if (!$card) {
            return redirect()->back()->with('error', 'Kartu tidak valid atau bukan milik Anda.');
        }

        $validated = $request->validate([
            'business_name'     => 'required|string|max:150',
            'google_review_url' => 'required|url|max:1000',
            'owner_phone'       => 'nullable|string|max:30',
        ]);

        $rawUrl = trim($validated['google_review_url']);

        try {
            // Resolve URL via Productmate & konversi otomatis ke link review langsung dengan Place ID
            $finalReviewUrl = $mapsService->convertToWriteReviewUrl($rawUrl);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Gagal konversi Google Maps URL: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memproses link Google Maps: ' . $e->getMessage() . '. Pastikan link mengarah ke lokasi bisnis Google Maps yang valid.');
        }

        DB::table('review_cards')->where('id', $id)->update([
            'business_name'     => trim($validated['business_name']),
            'google_review_url' => $finalReviewUrl,
            'owner_phone'       => $validated['owner_phone'] ?? null,
            'status'            => 'active',
            'activated_at'      => now(),
            'updated_at'        => now(),
        ]);

        return redirect()->route('affiliate.review_cards.index')
            ->with('success', "Berhasil menghubungkan kartu {$card->serial_number} ke {$validated['business_name']}! Link review langsung telah aktif.");
    }
}
