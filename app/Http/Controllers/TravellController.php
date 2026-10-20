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
        $routes = Route::all();

        $selectedOrigin = $request->query('origin', 'Ciamis');
        $selectedDestination = $request->query('destination', 'Bandung');
        $selectedDate = $request->query('date', Carbon::today()->toDateString());
        $serviceType = $request->query('service_type');

        // Query active schedules matching filters
        $schedulesQuery = Schedule::with('route')
            ->whereHas('route', function ($q) use ($selectedOrigin, $selectedDestination) {
                if ($selectedOrigin) {
                    $q->where('origin', 'like', "%{$selectedOrigin}%");
                }
                if ($selectedDestination) {
                    $q->where('destination', 'like', "%{$selectedDestination}%");
                }
            })
            ->whereDate('departure_date', '>=', Carbon::today())
            ->orderBy('departure_date', 'asc')
            ->orderBy('departure_time', 'asc');

        if ($selectedDate) {
            $schedulesQuery->whereDate('departure_date', $selectedDate);
        }

        if ($serviceType && in_array($serviceType, [Schedule::SERVICE_TYPE_REGULER, Schedule::SERVICE_TYPE_PREMIUM_SOPIR])) {
            $schedulesQuery->where('service_type', $serviceType);
        }

        $schedules = $schedulesQuery->get();

        // If today has no schedules in query, fallback to next upcoming schedules
        if ($schedules->isEmpty()) {
            $schedules = Schedule::with('route')
                ->whereDate('departure_date', '>=', Carbon::today())
                ->orderBy('departure_date', 'asc')
                ->orderBy('departure_time', 'asc')
                ->limit(8)
                ->get();
        }

        return view('travell.index', compact(
            'routes',
            'schedules',
            'selectedOrigin',
            'selectedDestination',
            'selectedDate',
            'serviceType'
        ));
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
            if (empty($validated['schedule_id'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pilih jadwal keberangkatan terlebih dahulu.',
                ], 422);
            }

            $schedule = Schedule::with('route')->findOrFail($validated['schedule_id']);
            $minQuota = (int) ($schedule->min_quota ?? 4);
            $totalPassengers = (int) $validated['total_passengers'];

            if ($totalPassengers < $minQuota) {
                return response()->json([
                    'success' => false,
                    'message' => "Pemesanan shuttle reguler minimal {$minQuota} kursi untuk pemberangkatan rombongan door to door.",
                ], 422);
            }

            if ($schedule->route) {
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

        // 3. Find or create Customer
        $customer = Customer::firstOrCreate(
            ['phone' => $validated['phone']],
            ['name' => $validated['name']]
        );

        if ($customer->name !== $validated['name']) {
            $customer->update(['name' => $validated['name']]);
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
                'customer_name' => $customer->name,
                'customer_phone' => $customer->phone,
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
}
