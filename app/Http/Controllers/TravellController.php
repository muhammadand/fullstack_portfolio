<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Customer;
use App\Models\Route;
use App\Models\Schedule;
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
            'destination_note' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:500',
        ]);

        // 1. Find or create Customer
        $customer = Customer::firstOrCreate(
            ['phone' => $validated['phone']],
            ['name' => $validated['name']]
        );

        if ($customer->name !== $validated['name']) {
            $customer->update(['name' => $validated['name']]);
        }

        // 2. Determine price and calculate total
        $totalAmount = 0;
        $unitPrice = 190000;
        $schedule = null;
        if ($validated['booking_type'] === 'reguler') {
            if (!empty($validated['schedule_id'])) {
                $schedule = Schedule::with('route')->find($validated['schedule_id']);
                if ($schedule && $schedule->route) {
                    $unitPrice = (float) $schedule->route->base_price;
                }
            }
            $totalAmount = $unitPrice * (int) $validated['total_passengers'];
        } else {
            // Charter sewa mobil harian (default 850.000 / hari all in sopir)
            $dailyRate = 850000;
            $days = $validated['duration_days'] ?? 1;
            $totalAmount = $dailyRate * $days;
        }

        // 3. Generate Unique Booking Code
        $bookingCode = 'TRV-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));

        // 4. Create Booking Header
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

        // 5. Create Booking Details (Line Items)
        if ($validated['booking_type'] === 'reguler') {
            $routeName = ($schedule && $schedule->route)
                ? ($schedule->route->origin . ' - ' . $schedule->route->destination)
                : 'Ciamis - Bandung';

            for ($i = 1; $i <= (int) $validated['total_passengers']; $i++) {
                BookingDetail::create([
                    'booking_id' => $booking->id,
                    'item_type' => BookingDetail::ITEM_TYPE_SEAT,
                    'item_name' => 'Tiket Kursi ' . $routeName,
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
            BookingDetail::create([
                'booking_id' => $booking->id,
                'item_type' => BookingDetail::ITEM_TYPE_CHARTER_UNIT,
                'item_name' => 'Sewa Mobil + Sopir (' . ($validated['duration_days'] ?? 1) . ' Hari) - ' . ($validated['destination_note'] ?? 'Wisata/Charter'),
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

        // 6. Request Dynamic QRIS from Scalify Intelligence Payment Gateway
        $qrisResult = $this->requestDynamicQris($booking, $customer, $totalAmount);

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
                'total_amount' => (int) $booking->total_amount,
                'formatted_amount' => 'Rp ' . number_format($booking->total_amount, 0, ',', '.'),
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
