<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReviewCardController extends Controller
{
    /**
     * Display a listing of review cards using Query Builder for maximum performance.
     */
    public function index(Request $request)
    {
        // 1. Ringan & Cepat: Ambil statistik agregat dalam 1 query tunggal
        $stats = DB::table('review_cards')
            ->selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN status = "active" THEN 1 ELSE 0 END) as active,
                SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending,
                COALESCE(SUM(total_scans), 0) as total_scans
            ')
            ->first();

        // 2. Query data utama: hanya select kolom yang benar-benar dibutuhkan view
        $query = DB::table('review_cards')
            ->select([
                'id',
                'serial_number',
                'slug',
                'activation_code',
                'business_name',
                'google_review_url',
                'status',
                'owner_name',
                'total_scans',
                'activated_at',
                'created_at',
            ]);

        // Filter Pencarian
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('serial_number', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('business_name', 'like', "%{$search}%")
                    ->orWhere('owner_name', 'like', "%{$search}%");
            });
        }

        // Filter Status
        if ($request->filled('status') && in_array($request->status, ['pending', 'active', 'inactive'])) {
            $query->where('status', $request->status);
        }

        $cards = $query->orderBy('id', 'desc')->paginate(15)->withQueryString();

        // 3. Ambil pesanan QRIS dari Partner yang sedang menunggu verifikasi admin
        $pendingCards = DB::table('review_cards')
            ->leftJoin('affiliates', 'review_cards.affiliate_id', '=', 'affiliates.id')
            ->where('review_cards.payment_status', 'pending')
            ->whereNotNull('review_cards.notes')
            ->select([
                'review_cards.id as card_id',
                'review_cards.notes',
                'review_cards.created_at',
                'affiliates.name as partner_name',
                'affiliates.email as partner_email',
                'affiliates.bank_info as partner_bank',
            ])
            ->orderBy('review_cards.id', 'desc')
            ->get();

        $pendingOrders = [];
        foreach ($pendingCards as $item) {
            $notes = json_decode($item->notes, true);
            if ($notes && isset($notes['order_id'])) {
                $oid = $notes['order_id'];
                if (!isset($pendingOrders[$oid])) {
                    $pendingOrders[$oid] = array_merge($notes, [
                        'partner_name'  => $item->partner_name ?? 'Partner #' . ($item->card_id ?? '-'),
                        'partner_email' => $item->partner_email ?? '-',
                        'created_at'    => $item->created_at,
                        'card_ids'      => [],
                    ]);
                }
                $pendingOrders[$oid]['card_ids'][] = $item->card_id;
            }
        }

        return view('admin.review_cards.index', compact('cards', 'stats', 'pendingOrders'));
    }

    /**
     * Show form to create a single card.
     */
    public function create()
    {
        // Pre-generate unique random default values for convenience
        $defaultSerial = 'SCL-' . strtoupper(Str::random(6));
        $defaultSlug = Str::lower(Str::random(6));
        $defaultPin = str_pad((string) random_int(100000, 999999), 6, '0', STR_PAD_LEFT);

        return view('admin.review_cards.create', compact('defaultSerial', 'defaultSlug', 'defaultPin'));
    }

    /**
     * Store a newly created review card using Query Builder.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'serial_number' => 'required|string|max:64|unique:review_cards,serial_number',
            'slug' => 'required|string|max:64|alpha_dash|unique:review_cards,slug',
            'activation_code' => 'required|string|max:32',
            'business_name' => 'nullable|string|max:255',
            'google_review_url' => 'nullable|url',
            'status' => 'required|in:pending,active,inactive',
            'owner_name' => 'nullable|string|max:255',
            'owner_phone' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
        ]);

        $now = now();

        DB::table('review_cards')->insert([
            'serial_number' => strtoupper(trim($validated['serial_number'])),
            'slug' => strtolower(trim($validated['slug'])),
            'activation_code' => trim($validated['activation_code']),
            'business_name' => $validated['business_name'] ?? null,
            'google_review_url' => $validated['google_review_url'] ?? null,
            'status' => $validated['status'],
            'owner_name' => $validated['owner_name'] ?? null,
            'owner_phone' => $validated['owner_phone'] ?? null,
            'total_scans' => 0,
            'activated_at' => $validated['status'] === 'active' ? $now : null,
            'notes' => $validated['notes'] ?? null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return redirect()->route('admin.review_cards.index')
            ->with('success', "Review Card {$validated['serial_number']} berhasil ditambahkan.");
    }

    /**
     * Mass / Batch generator: Untuk tahap "Scalify menyiapkan produk / cetak massal"
     */
    public function batchGenerate(Request $request)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:100',
            'prefix' => 'nullable|string|max:10',
            'notes' => 'nullable|string|max:255',
        ]);

        $qty = (int) $validated['quantity'];
        $prefix = strtoupper(trim($validated['prefix'] ?? 'SCL'));
        $now = now();
        $batchData = [];

        // Generate serials and slugs
        for ($i = 0; $i < $qty; $i++) {
            $uniqueHex = strtoupper(Str::random(4));
            $serialNumber = "{$prefix}-" . date('ym') . "-{$uniqueHex}";
            $slug = Str::lower(Str::random(6));
            $pin = (string) random_int(100000, 999999);

            $batchData[] = [
                'serial_number' => $serialNumber,
                'slug' => $slug,
                'activation_code' => $pin,
                'status' => 'pending',
                'business_name' => null,
                'google_review_url' => null,
                'owner_name' => null,
                'owner_phone' => null,
                'total_scans' => 0,
                'activated_at' => null,
                'notes' => $validated['notes'] ?? 'Batch generated for print',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('review_cards')->insert($batchData);

        return redirect()->route('admin.review_cards.index')
            ->with('success', "Berhasil men-generate {$qty} unit QR Review Cards siap cetak.");
    }

    /**
     * Show card details and printable card template.
     */
    public function show(int $id)
    {
        $card = DB::table('review_cards')->where('id', $id)->first();

        if (!$card) {
            return redirect()->route('admin.review_cards.index')
                ->with('error', 'Kartu review tidak ditemukan.');
        }

        $businessName = $card->business_name ?? '';

        return view('admin.review_cards.show', compact('card', 'businessName'));
    }

    /**
     * Show form to edit a card.
     */
    public function edit(int $id)
    {
        $card = DB::table('review_cards')->where('id', $id)->first();

        if (!$card) {
            return redirect()->route('admin.review_cards.index')
                ->with('error', 'Kartu review tidak ditemukan.');
        }

        return view('admin.review_cards.edit', compact('card'));
    }

    /**
     * Update review card using Query Builder.
     */
    public function update(Request $request, int $id)
    {
        $card = DB::table('review_cards')->where('id', $id)->first();

        if (!$card) {
            return redirect()->route('admin.review_cards.index')
                ->with('error', 'Kartu review tidak ditemukan.');
        }

        $validated = $request->validate([
            'business_name' => 'nullable|string|max:255',
            'google_review_url' => 'nullable|url',
            'status' => 'required|in:pending,active,inactive',
            'owner_name' => 'nullable|string|max:255',
            'owner_phone' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
        ]);

        $now = now();
        $activatedAt = $card->activated_at;

        if ($validated['status'] === 'active' && empty($activatedAt)) {
            $activatedAt = $now;
        }

        DB::table('review_cards')->where('id', $id)->update([
            'business_name' => $validated['business_name'] ?? null,
            'google_review_url' => $validated['google_review_url'] ?? null,
            'status' => $validated['status'],
            'owner_name' => $validated['owner_name'] ?? null,
            'owner_phone' => $validated['owner_phone'] ?? null,
            'activated_at' => $activatedAt,
            'notes' => $validated['notes'] ?? null,
            'updated_at' => $now,
        ]);

        return redirect()->route('admin.review_cards.index')
            ->with('success', "Data kartu {$card->serial_number} berhasil diperbarui.");
    }

    /**
     * Delete a review card.
     */
    public function destroy(int $id)
    {
        $deleted = DB::table('review_cards')->where('id', $id)->delete();

        if ($deleted) {
            return redirect()->route('admin.review_cards.index')
                ->with('success', 'Kartu review berhasil dihapus.');
        }

        return redirect()->route('admin.review_cards.index')
            ->with('error', 'Gagal menghapus kartu.');
    }

    /**
     * Toggle status quickly between active and inactive.
     */
    public function toggleStatus(int $id)
    {
        $card = DB::table('review_cards')->where('id', $id)->first();

        if (!$card) {
            return response()->json(['success' => false, 'message' => 'Kartu tidak ditemukan.'], 404);
        }

        $newStatus = $card->status === 'active' ? 'inactive' : 'active';
        $now = now();

        DB::table('review_cards')->where('id', $id)->update([
            'status' => $newStatus,
            'activated_at' => ($newStatus === 'active' && empty($card->activated_at)) ? $now : $card->activated_at,
            'updated_at' => $now,
        ]);

        return redirect()->back()
            ->with('success', "Status kartu {$card->serial_number} diubah menjadi {$newStatus}.");
    }

    /**
     * Public scan gateway: domain.com/r/{slug}
     * Ultra-fast redirect to Google Review or Activation Page.
     */
    public function scanRedirect(string $slug)
    {
        $card = DB::table('review_cards')
            ->select(['id', 'serial_number', 'slug', 'activation_code', 'google_review_url', 'business_name', 'status'])
            ->where('slug', $slug)
            ->first();

        if (!$card) {
            abort(404, 'Review Card QR tidak terdaftar.');
        }

        // Jika baru saja sukses diaktivasi (ada session flag), tampilkan layar sukses
        if (session('activated_success')) {
            return view('admin.review_cards.activated_success', compact('card'));
        }

        // Jika sudah aktif dan punya URL review Google, langsung redirect seketika!
        if ($card->status === 'active' && !empty($card->google_review_url)) {
            DB::table('review_cards')->where('id', $card->id)->increment('total_scans');
            return redirect()->away($card->google_review_url);
        }

        // Jika belum aktif, tampilkan formulir aktivasi mandiri untuk pembeli
        return view('admin.review_cards.activate', compact('card'));
    }

    /**
     * Customer Self-Activation Handler: POST /r/{slug}/activate
     */
    public function activateCard(Request $request, string $slug)
    {
        $card = DB::table('review_cards')
            ->where('slug', $slug)
            ->first();

        if (!$card) {
            abort(404, 'Review Card QR tidak terdaftar.');
        }

        if ($card->status === 'active' && !empty($card->google_review_url)) {
            return redirect()->route('review_cards.scan', $slug);
        }

        $validated = $request->validate([
            'pin' => 'required|string',
            'business_name' => 'required|string|max:255',
            'google_review_url' => 'required|url',
            'owner_name' => 'nullable|string|max:255',
            'owner_phone' => 'nullable|string|max:50',
        ]);

        // Verifikasi PIN Aktivasi (Abaikan spasi & case-insensitive)
        if (strtoupper(trim($validated['pin'])) !== strtoupper(trim($card->activation_code))) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kode PIN Aktivasi salah! Silakan periksa kembali nomor PIN di kartu atau kemasan produk Anda.'
                ], 422);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Kode PIN Aktivasi salah! Silakan periksa kembali nomor PIN di kartu atau kemasan produk Anda.');
        }

        $rawReviewUrl = trim($validated['google_review_url']);
        try {
            $finalReviewUrl = app(\App\Services\GoogleMapsService::class)->convertToWriteReviewUrl($rawReviewUrl);
        } catch (\Exception $e) {
            $finalReviewUrl = $rawReviewUrl;
        }

        $now = now();
        DB::table('review_cards')->where('id', $card->id)->update([
            'business_name' => trim($validated['business_name']),
            'google_review_url' => $finalReviewUrl,
            'owner_name' => !empty($validated['owner_name']) ? trim($validated['owner_name']) : null,
            'owner_phone' => !empty($validated['owner_phone']) ? trim($validated['owner_phone']) : null,
            'status' => 'active',
            'activated_at' => $now,
            'updated_at' => $now,
        ]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'business_name' => trim($validated['business_name']),
                'serial_number' => $card->serial_number,
                'google_review_url' => trim($validated['google_review_url']),
                'redirect_url' => route('review_cards.scan', $slug),
            ]);
        }

        return redirect()->route('review_cards.scan', $slug)
            ->with('activated_success', true);
    }

    /**
     * Admin verifies partner QRIS order payment and releases cards stock.
     */
    public function verifyOrderPayment(Request $request, string $orderId)
    {
        $updated = DB::table('review_cards')
            ->where('payment_status', 'pending')
            ->where('notes', 'like', "%{$orderId}%")
            ->update([
                'payment_status' => 'paid',
                'purchased_at'   => now(),
                'updated_at'     => now(),
            ]);

        if ($updated > 0) {
            return redirect()->back()
                ->with('success', "✅ Pesanan #{$orderId} berhasil diverifikasi! {$updated} unit kartu QR kini telah aktif di akun partner.");
        }

        return redirect()->back()->with('error', "Pesanan #{$orderId} tidak ditemukan atau sudah diverifikasi.");
    }

    /**
     * Admin cancels/rejects partner QRIS order payment.
     */
    public function cancelOrderPayment(Request $request, string $orderId)
    {
        $deleted = DB::table('review_cards')
            ->where('payment_status', 'pending')
            ->where('notes', 'like', "%{$orderId}%")
            ->delete();

        if ($deleted > 0) {
            return redirect()->back()
                ->with('success', "Pesanan #{$orderId} ({$deleted} unit kartu) berhasil dibatalkan.");
        }

        return redirect()->back()->with('error', "Pesanan #{$orderId} tidak ditemukan.");
    }
}
