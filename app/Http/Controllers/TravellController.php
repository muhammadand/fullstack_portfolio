<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Customer;
use App\Models\Route;
use App\Models\Schedule;
use App\Services\QrisPaymentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TravellController extends Controller
{
    /**
     * Display travel landing page with routes & schedules.
     */
    public function index(Request $request)
    {
        return view('travell.index');
    }

    /**
     * Handle quick booking creation from landing page.
     */
    public function storeBooking(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'phone' => 'required|string|max:30',
            'schedule_id' => 'nullable|exists:schedules,id',
            'booking_type' => 'required|in:reguler,charter',
            'total_passengers' => 'required|integer|min:1|max:20',
            'pickup_address' => 'nullable|string|max:255',
            'dropoff_address' => 'nullable|string|max:255',
            'charter_date' => 'nullable|date',
            'duration_days' => 'nullable|integer|min:1',
            'charter_purpose' => 'nullable|string|in:kondangan,liburan,dinas',
            'charter_fleet' => 'nullable|string',
            'destination_note' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:500',
            'seats' => 'nullable|array',
        ]);

        // 1. Enforce Business Rule: Minimal 4 Kursi untuk Shuttle Reguler
        $schedule = null;
        $unitPrice = 190000;
        $totalAmount = 0;

        if ($validated['booking_type'] === 'reguler') {
            $totalPassengers = (int) $validated['total_passengers'];
            if ($totalPassengers < 4) {
                return response()->json([
                    'success' => false,
                    'message' => "Pemesanan shuttle reguler minimal 4 kursi untuk pemberangkatan rombongan door to door via Tol.",
                ], 422);
            }

            if (!empty($validated['schedule_id'])) {
                $schedule = Schedule::with('route')->find($validated['schedule_id']);
            }

            if (!$schedule) {
                $depDate = $request->input('departure_date', Carbon::today()->toDateString());
                $rawTime = $request->input('departure_time', '06:00');
                $depTime = strlen($rawTime) === 5 ? ($rawTime . ':00') : $rawTime;

                // Determine route based on pickup / origin
                $pickupRaw = strtolower($validated['pickup_address'] ?? $request->input('origin', 'ciamis'));
                $route = null;
                if (str_contains($pickupRaw, 'bandung') || str_contains($pickupRaw, 'pasteur') || str_contains($pickupRaw, 'dipatiukur')) {
                    $route = Route::where('origin', 'like', '%Bandung%')->first();
                } else {
                    $route = Route::where('origin', 'like', '%Ciamis%')->first();
                }

                if (!$route) {
                    $route = Route::first() ?? Route::create([
                        'origin' => 'Ciamis',
                        'destination' => 'Bandung',
                        'base_price' => 190000,
                    ]);
                }

                $schedule = Schedule::firstOrCreate([
                    'route_id' => $route->id,
                    'departure_date' => $depDate,
                    'departure_time' => $depTime,
                ], [
                    'service_type' => Schedule::SERVICE_TYPE_REGULER,
                    'min_quota' => 4,
                    'status' => 'waiting_quota',
                ]);
            }

            $unitPrice = 190000;
            if ($schedule && $schedule->route) {
                $unitPrice = (float) $schedule->route->base_price;
            }
            $totalAmount = $unitPrice * $totalPassengers;
        } else {
            // 2. Charter Pricing Logic (Kondangan vs Liburan)
            $purpose = $validated['charter_purpose'] ?? 'kondangan';
            $fleet = $validated['charter_fleet'] ?? 'xenia_all_new';
            $days = (int) ($validated['duration_days'] ?? 1);

            $rates = [
                'kondangan' => [
                    'xenia_all_new' => 750000,
                    'avanza_veloz' => 700000,
                    'innova_zenix' => 1000000,
                    'hiace_premio' => 1350000,
                    'elf_long' => 1500000,
                ],
                'liburan' => [
                    'xenia_all_new' => 950000,
                    'avanza_veloz' => 850000,
                    'innova_zenix' => 1250000,
                    'hiace_premio' => 1650000,
                    'elf_long' => 1800000,
                ],
                'dinas' => [
                    'xenia_all_new' => 850000,
                    'avanza_veloz' => 800000,
                    'innova_zenix' => 1100000,
                    'hiace_premio' => 1500000,
                    'elf_long' => 1650000,
                ],
            ];

            $dailyRate = $rates[$purpose][$fleet] ?? ($rates['kondangan']['xenia_all_new'] ?? 750000);
            $totalAmount = $dailyRate * $days;
        }

        // 3. Find or create Customer by unique phone
        $cleanPhone = preg_replace('/[^0-9]/', '', $validated['phone']);
        $customer = Customer::where('phone', $cleanPhone)
            ->orWhere('phone', $validated['phone'])
            ->first();

        if (!$customer) {
            $customer = Customer::create([
                'name' => $validated['name'],
                'phone' => $cleanPhone,
                'points' => 50, // Welcome points
            ]);
        } else {
            if ($customer->name !== $validated['name'] && !empty($validated['name'])) {
                $customer->update(['name' => $validated['name']]);
            }
        }

        // 4. Generate Unique Booking Code
        $prefix = $validated['booking_type'] === 'reguler' ? 'RVN' : 'CHR';
        $bookingCode = $prefix . '-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));

        // 5. Create Booking Header
        $booking = Booking::create([
            'booking_code' => $bookingCode,
            'customer_id' => $customer->id,
            'schedule_id' => $schedule ? $schedule->id : null,
            'booking_type' => $validated['booking_type'],
            'total_passengers' => $validated['total_passengers'],
            'charter_date' => $validated['charter_date'] ?? null,
            'duration_days' => $validated['duration_days'] ?? 1,
            'pickup_address' => $validated['pickup_address'] ?? null,
            'dropoff_address' => $validated['dropoff_address'] ?? null,
            'destination_note' => $validated['destination_note'] ?? null,
            'total_amount' => $totalAmount,
            'payment_status' => Booking::PAYMENT_UNPAID,
            'status' => Booking::STATUS_PENDING,
            'notes' => $validated['notes'] ?? null,
        ]);

        // 6. Create Booking Details (Line Items)
        if ($validated['booking_type'] === 'reguler') {
            $routeName = ($schedule && $schedule->route)
                ? ($schedule->route->origin . ' - ' . $schedule->route->destination)
                : 'Ciamis - Bandung';

            $selectedSeats = $request->input('seats', []);
            for ($i = 1; $i <= (int) $validated['total_passengers']; $i++) {
                $seatNumber = isset($selectedSeats[$i - 1]) ? ('K-0' . $selectedSeats[$i - 1]) : ('K-0' . $i);

                BookingDetail::create([
                    'booking_id' => $booking->id,
                    'item_type' => BookingDetail::ITEM_TYPE_SEAT,
                    'item_name' => 'Tiket Kursi ' . $seatNumber . ' (' . $routeName . ')',
                    'seat_number' => $seatNumber,
                    'passenger_name' => $i === 1 ? $customer->name : 'Penumpang ' . $i . ' (Rombongan ' . $customer->name . ')',
                    'passenger_phone' => $i === 1 ? $customer->phone : null,
                    'pickup_point' => $validated['pickup_address'] ?? null,
                    'drop_point' => $validated['dropoff_address'] ?? null,
                    'price' => $unitPrice,
                    'qty' => 1,
                    'subtotal' => $unitPrice,
                ]);
            }
        } else {
            $purposeLabel = ucfirst($validated['charter_purpose'] ?? 'kondangan');
            BookingDetail::create([
                'booking_id' => $booking->id,
                'item_type' => BookingDetail::ITEM_TYPE_CHARTER_UNIT,
                'item_name' => 'Charter ' . strtoupper($validated['charter_fleet'] ?? 'Daihatsu Xenia') . ' (' . ($validated['duration_days'] ?? 1) . ' Hari - ' . $purposeLabel . ')',
                'passenger_name' => $customer->name,
                'passenger_phone' => $customer->phone,
                'pickup_point' => $validated['pickup_address'] ?? null,
                'drop_point' => $validated['dropoff_address'] ?? null,
                'price' => $totalAmount,
                'qty' => 1,
                'subtotal' => $totalAmount,
                'notes' => $validated['destination_note'] ?? null,
            ]);
        }

        // 7. Request Dynamic QRIS via QrisPaymentService (Scalify Pay)
        $qrisResult = QrisPaymentService::createDynamicQris(
            $booking->booking_code,
            $totalAmount,
            [
                'name' => $customer->name,
                'phone' => $customer->phone,
            ],
            'DANA'
        );

        // Generate QR image URL if payload exists
        $qrisPayload = $qrisResult['data']['qris_payload'] ?? null;
        $qrisImageUrl = $qrisPayload
            ? 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&margin=8&data=' . urlencode($qrisPayload)
            : null;

        $finalAmount = $qrisResult['data']['total_amount'] ?? $totalAmount;

        return response()->json([
            'success' => true,
            'message' => 'Pemesanan berhasil dibuat!',
            'data' => [
                'booking_code' => $booking->booking_code,
                'customer_id' => $customer->id,
                'customer_name' => $customer->name,
                'customer_phone' => $customer->phone,
                'customer_points' => (int) ($customer->points ?? 0),
                'booking_type' => $booking->booking_type,
                'total_passengers' => $booking->total_passengers,
                'pickup_address' => $booking->pickup_address,
                'dropoff_address' => $booking->dropoff_address,
                'base_amount' => (int) $totalAmount,
                'total_amount' => (int) $finalAmount,
                'unique_code' => (int) ($qrisResult['data']['unique_code'] ?? 0),
                'formatted_amount' => 'Rp ' . number_format($finalAmount, 0, ',', '.'),
                'qris_payload' => $qrisPayload,
                'qris_image_url' => $qrisImageUrl,
                'expires_at' => $qrisResult['data']['expires_at'] ?? now()->addMinutes(30)->toIso8601String(),
                'qris' => $qrisResult,
            ],
        ]);
    }

    /**
     * Request Dynamic QRIS from Scalify Payment API.
     */
    protected function requestDynamicQris(Booking $booking, Customer $customer, $totalAmount): array
    {
        $url = config('services.qris.url', env('SCALIFY_QRIS_URL', 'http://pay.scalifyintellegence.my.id/api/v1/qris/dynamic'));
        $apiKey = config('services.qris.api_key', env('SCALIFY_QRIS_API_KEY', env('QRIS_API_KEY', '')));
        $project = config('services.qris.project', env('SCALIFY_PROJECT', ''));

        // Check if API key is populated
        if (empty($apiKey)) {
            return [
                'success' => false,
                'status' => 'pending_config',
                'message' => 'API Key QRIS belum dikonfigurasi di .env (SCALIFY_QRIS_API_KEY).',
            ];
        }

        $payload = [
            'order_id' => $booking->booking_code,
            'amount' => (int) round($totalAmount),
            'provider' => 'DANA',
            'merchant_id' => null,
            'use_unique_code' => null,
            'customer' => [
                'name' => $customer->name,
                'email' => $customer->email ?? null,
                'phone' => $customer->phone ?? null,
            ],
            'authenticated_project' => $project ?? '',
        ];

        try {
            $response = Http::timeout(10)
                ->withHeaders([
                    'X-API-Key' => $apiKey,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->post($url, $payload);

            if ($response->successful()) {
                $body = $response->json();
                return [
                    'success' => true,
                    'status' => 'generated',
                    'data' => $body,
                ];
            }

            Log::warning('Scalify QRIS failed with code ' . $response->status() . ': ' . $response->body());
            return [
                'success' => false,
                'status' => 'api_error',
                'http_code' => $response->status(),
                'message' => 'Gagal memproses QRIS dari server payment (' . $response->status() . ').',
                'raw' => $response->json() ?? $response->body(),
            ];
        } catch (\Throwable $e) {
            Log::error('Scalify QRIS Exception: ' . $e->getMessage());
            return [
                'success' => false,
                'status' => 'exception',
                'message' => 'Koneksi ke gateway QRIS bermasalah: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Endpoint to re-generate / refresh QRIS for an existing booking code.
     */
    public function generateQris(Request $request)
    {
        $validated = $request->validate([
            'booking_code' => 'required|string',
        ]);

        $booking = Booking::with('customer')->where('booking_code', $validated['booking_code'])->first();
        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Data pemesanan tidak ditemukan.',
            ], 404);
        }

        $qrisResult = $this->requestDynamicQris($booking, $booking->customer, $booking->total_amount);

        return response()->json([
            'success' => true,
            'booking_code' => $booking->booking_code,
            'total_amount' => (int) $booking->total_amount,
            'formatted_amount' => 'Rp ' . number_format($booking->total_amount, 0, ',', '.'),
            'qris' => $qrisResult,
        ]);
    }

    /**
     * Endpoint to check booking status.
     */
    public function checkStatus($bookingCode)
    {
        $booking = Booking::where('booking_code', $bookingCode)->first();
        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Pemesanan tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'booking_code' => $booking->booking_code,
            'payment_status' => $booking->payment_status,
            'status' => $booking->status,
            'total_amount' => (int) $booking->total_amount,
            'formatted_amount' => 'Rp ' . number_format($booking->total_amount, 0, ',', '.'),
        ]);
    }

    /**
     * Get list of tickets / bookings for a customer by customer_id or phone number.
     */
    public function myTickets(Request $request)
    {
        $customerId = $request->input('customer_id');
        $rawPhone = $request->input('phone');

        if (empty($customerId) && empty($rawPhone)) {
            return response()->json([
                'success' => false,
                'message' => 'Customer ID atau Nomor WhatsApp wajib diisi.',
            ], 422);
        }

        $customerIds = collect();

        if (!empty($customerId)) {
            $customer = Customer::find($customerId);
            if ($customer) {
                $cleanPhone = preg_replace('/[^0-9]/', '', $customer->phone ?? '');
                $customerIds = Customer::where('id', $customer->id)
                    ->when(!empty($cleanPhone), function ($q) use ($cleanPhone) {
                        $q->orWhere('phone', $cleanPhone);
                        if (str_starts_with($cleanPhone, '62')) {
                            $q->orWhere('phone', '0' . substr($cleanPhone, 2));
                        } elseif (str_starts_with($cleanPhone, '0')) {
                            $q->orWhere('phone', '62' . substr($cleanPhone, 1));
                        }
                        if (strlen($cleanPhone) >= 8) {
                            $q->orWhere('phone', 'like', '%' . substr($cleanPhone, -8));
                        }
                    })->pluck('id');
            } else {
                $customerIds = collect([(int)$customerId]);
            }
        } elseif (!empty($rawPhone)) {
            $cleanPhone = preg_replace('/[^0-9]/', '', $rawPhone);
            if (strlen($cleanPhone) < 6) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nomor HP tidak valid.',
                ], 422);
            }

            // Find customer matching phone variations (08xxx vs 62xxx or last 8 digits)
            $customerIds = Customer::where(function ($q) use ($cleanPhone) {
                $q->where('phone', $cleanPhone);
                if (str_starts_with($cleanPhone, '62')) {
                    $alt = '0' . substr($cleanPhone, 2);
                    $q->orWhere('phone', $alt);
                } elseif (str_starts_with($cleanPhone, '0')) {
                    $alt = '62' . substr($cleanPhone, 1);
                    $q->orWhere('phone', $alt);
                }
                if (strlen($cleanPhone) >= 8) {
                    $q->orWhere('phone', 'like', '%' . substr($cleanPhone, -8));
                }
            })->pluck('id');
        }

        $bookings = Booking::whereIn('customer_id', $customerIds)
            ->with(['customer', 'schedule.route', 'details'])
            ->latest()
            ->get();

        $formatted = $bookings->map(function ($b) {
            $isCharter = $b->booking_type === 'charter';
            $sched = $b->schedule;
            $origin = $sched ? ($sched->route->origin ?? 'Ciamis') : 'Ciamis';
            $dest = $sched ? ($sched->route->destination ?? 'Bandung') : ($b->destination_note ?? 'Bandung');
            $depTime = $sched ? Carbon::parse($sched->departure_time)->format('H:i') . ' WIB' : '08:00 WIB';
            $depDate = $isCharter
                ? ($b->charter_date ? Carbon::parse($b->charter_date)->format('Y-m-d') : date('Y-m-d'))
                : ($sched && $sched->departure_date ? Carbon::parse($sched->departure_date)->format('Y-m-d') : date('Y-m-d'));

            $seatNumbers = $b->details ? $b->details->where('item_type', 'seat')->pluck('seat_number')->filter()->implode(', ') : null;
            if (empty(trim((string)$seatNumbers))) {
                $seatNumbers = $isCharter ? 'Sewa 1 Unit Mobil' : ($b->total_passengers ? $b->total_passengers . ' Kursi' : '1 Unit');
            }

            // Map status label for customer view
            $statusLabel = 'Proses Verifikasi Pembayaran';
            $statusColor = 'amber';
            if ($b->payment_status === 'paid' || $b->status === 'confirmed') {
                $statusLabel = 'PAID (Lunas & Terkonfirmasi)';
                $statusColor = 'emerald';
            } elseif ($b->status === 'completed') {
                $statusLabel = 'Selesai';
                $statusColor = 'sky';
            } elseif ($b->status === 'cancelled') {
                $statusLabel = 'Dibatalkan';
                $statusColor = 'rose';
            }

            $paymentLabel = 'MENUNGGU PEMBAYARAN';
            if ($b->payment_status === 'paid' || $b->status === 'confirmed') {
                $paymentLabel = 'PAID / LUNAS';
            } elseif ($b->payment_status === 'refunded') {
                $paymentLabel = 'REFUND';
            }

            return [
                'id' => $b->id,
                'bookingCode' => $b->booking_code,
                'orderType' => strtoupper($b->booking_type ?? 'REGULER'),
                'passengerName' => $b->customer->name ?? 'Penumpang',
                'phone' => $b->customer->phone ?? '',
                'origin' => $origin,
                'destination' => $dest,
                'departureTime' => $depTime,
                'departureDate' => $depDate,
                'seats' => $seatNumbers,
                'pickupAddress' => $b->pickup_address ?? '-',
                'dropoffAddress' => $b->dropoff_address ?? '-',
                'fleetName' => 'Daihatsu All New Xenia',
                'totalPrice' => (int) $b->total_amount,
                'totalFormatted' => 'Rp ' . number_format($b->total_amount, 0, ',', '.'),
                'paymentStatus' => $paymentLabel,
                'bookingStatus' => $b->status,
                'statusLabel' => $statusLabel,
                'statusColor' => $statusColor,
                'createdAt' => $b->created_at ? $b->created_at->format('d M Y H:i') : '-',
            ];
        });

        return response()->json([
            'success' => true,
            'count' => $formatted->count(),
            'data' => $formatted,
        ]);
    }

    /**
     * Mark booking as paid (from QRIS screen simulation or webhook).
     */
    public function payBooking(Request $request, $bookingCode)
    {
        $booking = Booking::where('booking_code', $bookingCode)->first();
        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan.',
            ], 404);
        }

        $booking->update([
            'payment_status' => Booking::PAYMENT_UNPAID, // Proses verifikasi oleh admin
            'payment_method' => $request->input('payment_method', 'QRIS Dynamic (Scalify Pay)'),
            'status' => Booking::STATUS_PENDING, // 'pending' (Proses Verifikasi Pembayaran)
        ]);

        if ($booking->customer) {
            $booking->customer->increment('points', 25);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran Anda berhasil dikirim! Status pesanan saat ini: Proses Verifikasi Pembayaran oleh Admin.',
            'data' => [
                'booking_code' => $booking->booking_code,
                'payment_status' => $booking->payment_status,
                'status' => $booking->status,
                'status_label' => 'Proses Verifikasi Pembayaran',
                'total_amount' => (int) $booking->total_amount,
                'customer_points' => (int) ($booking->customer->points ?? 0),
            ],
        ]);
    }

    /**
     * Customer Login / Register by unique Phone & Name.
     */
    public function loginCustomer(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string',
            'name' => 'nullable|string|max:150',
        ]);

        $rawPhone = $validated['phone'];
        $cleanPhone = preg_replace('/[^0-9]/', '', $rawPhone);
        if (strlen($cleanPhone) < 8) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor WhatsApp / HP tidak valid (minimal 8 digit).',
            ], 422);
        }

        // Look up customer by phone variations
        $customer = Customer::where('phone', $cleanPhone)
            ->orWhere(function ($q) use ($cleanPhone) {
                if (str_starts_with($cleanPhone, '62')) {
                    $q->where('phone', '0' . substr($cleanPhone, 2));
                } elseif (str_starts_with($cleanPhone, '0')) {
                    $q->where('phone', '62' . substr($cleanPhone, 1));
                }
            })->first();

        $isNew = false;
        if (!$customer) {
            $name = trim($validated['name'] ?? '');
            if (empty($name)) {
                return response()->json([
                    'success' => true,
                    'exists' => false,
                    'message' => 'Nomor baru terdeteksi. Silakan masukkan nama Anda untuk pendaftaran akun.',
                ]);
            }

            $customer = Customer::create([
                'name' => $name,
                'phone' => $cleanPhone,
                'points' => 50, // Welcome bonus points
            ]);
            $isNew = true;
        } else {
            if (!empty($validated['name']) && ($customer->name === 'Penumpang' || $customer->name === 'Tamu')) {
                $customer->update(['name' => $validated['name']]);
            }
        }

        return response()->json([
            'success' => true,
            'exists' => true,
            'is_new' => $isNew,
            'message' => $isNew ? 'Pendaftaran berhasil! Anda mendapatkan bonus 50 Poin.' : 'Selamat datang kembali, ' . $customer->name . '!',
            'customer' => [
                'id' => $customer->id,
                'name' => $customer->name,
                'phone' => $customer->phone,
                'points' => (int) ($customer->points ?? 0),
            ],
        ]);
    }

    /**
     * Get Customer Profile & Real-time Points.
     */
    public function customerProfile(Request $request)
    {
        $rawPhone = $request->query('phone');
        if (empty($rawPhone)) {
            return response()->json(['success' => false, 'message' => 'Nomor HP wajib.'], 422);
        }

        $cleanPhone = preg_replace('/[^0-9]/', '', $rawPhone);
        $customer = Customer::where('phone', $cleanPhone)
            ->orWhere(function ($q) use ($cleanPhone) {
                if (str_starts_with($cleanPhone, '62')) {
                    $q->where('phone', '0' . substr($cleanPhone, 2));
                } elseif (str_starts_with($cleanPhone, '0')) {
                    $q->where('phone', '62' . substr($cleanPhone, 1));
                }
            })->first();

        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'Customer tidak ditemukan.'], 404);
        }

        return response()->json([
            'success' => true,
            'customer' => [
                'id' => $customer->id,
                'name' => $customer->name,
                'phone' => $customer->phone,
                'points' => (int) ($customer->points ?? 0),
            ],
        ]);
    }
}
