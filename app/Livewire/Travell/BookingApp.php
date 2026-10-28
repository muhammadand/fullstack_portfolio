<?php

namespace App\Livewire\Travell;

use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Customer;
use App\Models\Route;
use App\Models\Schedule;
use App\Services\QrisPaymentService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class BookingApp extends Component
{
    // Navigation / View State
    public string $currentView = 'home'; // 'home', 'schedules', 'seat_picker', 'passenger_form', 'ticket', 'history', 'charter', 'package'
    public string $activeTab = 'home';   // for bottom nav highlights

    // Customer Identity State
    public bool $isLoggedIn = false;
    public string $customerName = '';
    public string $customerPhone = '';
    public int $customerPoints = 0;

    // Booking Form State (Home Direct Booking)
    public string $pickupAddress = '';
    public string $dropoffAddress = '';
    public string $destinationNote = '';
    public string $departureDate = '';
    public string $selectedTime = '06:00';
    public int $seatQuantity = 4; // Minimal 4 Kursi
    public int $pricePerSeat = 190000;
    public int $totalAmount = 760000;

    // Charter Booking State
    public string $charterPurpose = 'kondangan'; // 'kondangan', 'liburan', 'dinas'
    public string $charterFleet = 'xenia_all_new';
    public int $charterDays = 1;
    public string $charterDate = '';
    public int $charterTotalAmount = 750000;

    // Active Ticket & QRIS State
    public ?array $activeBooking = null;
    public ?array $qrisData = null;
    public bool $isQrisModalOpen = false;

    // Auth Modal State
    public bool $isAuthModalOpen = false;
    public string $authPhone = '';
    public string $authName = '';
    public string $authError = '';

    // History (Tiket Saya) State
    public string $historyPhone = '';
    public string $historyFilter = 'all'; // 'all', 'paid', 'unpaid'
    public array $myTickets = [];
    public bool $hasSearchedHistory = false;

    // Feedback Notifications
    public string $feedbackMessage = '';
    public string $feedbackType = 'success'; // 'success', 'error', 'info'

    // Available Departure Time Slots
    public array $timeSlots = ['06:00', '09:00', '13:00', '16:00', '19:30'];

    public function mount(): void
    {
        $this->departureDate = Carbon::today()->toDateString();
        $this->charterDate = Carbon::today()->addDay()->toDateString();
        $this->calculateTotal();
        $this->calculateCharterTotal();

        // Restore Customer Session if available
        $savedPhone = session('travel_customer_phone');
        if ($savedPhone) {
            $customer = Customer::where('phone', $savedPhone)->first();
            if ($customer) {
                $this->isLoggedIn = true;
                $this->customerName = $customer->name;
                $this->customerPhone = $customer->phone;
                $this->customerPoints = (int) ($customer->points ?? 0);
                $this->historyPhone = $customer->phone;
            }
        }
    }

    public function switchView(string $view): void
    {
        $this->currentView = $view;
        if (in_array($view, ['home', 'history', 'charter', 'package', 'profile'])) {
            $this->activeTab = $view;
        }

        if ($view === 'history' && $this->isLoggedIn && !empty($this->customerPhone)) {
            $this->historyPhone = $this->customerPhone;
            $this->loadMyTickets();
        }

        $this->clearFeedback();
    }

    public function incrementSeats(): void
    {
        if ($this->seatQuantity < 5) {
            $this->seatQuantity++;
            $this->calculateTotal();
        }
    }

    public function decrementSeats(): void
    {
        if ($this->seatQuantity > 4) {
            $this->seatQuantity--;
            $this->calculateTotal();
        }
    }

    public function selectTime(string $time): void
    {
        $this->selectedTime = $time;
    }

    public function calculateTotal(): void
    {
        $this->totalAmount = $this->seatQuantity * $this->pricePerSeat;
    }

    public function calculateCharterTotal(): void
    {
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

        $dailyRate = $rates[$this->charterPurpose][$this->charterFleet] ?? 750000;
        $this->charterTotalAmount = $dailyRate * max(1, $this->charterDays);
    }

    public function updatedCharterPurpose(): void
    {
        $this->calculateCharterTotal();
    }

    public function updatedCharterFleet(): void
    {
        $this->calculateCharterTotal();
    }

    public function updatedCharterDays(): void
    {
        $this->calculateCharterTotal();
    }

    public function applyQuickPickup(string $address): void
    {
        $this->pickupAddress = $address;
    }

    public function applyQuickDropoff(string $address): void
    {
        $this->dropoffAddress = $address;
    }

    // ==========================================
    // CUSTOMER AUTHENTICATION METHODS
    // ==========================================

    public function openCustomerAuthModal(): void
    {
        $this->authPhone = $this->customerPhone;
        $this->authName = $this->customerName;
        $this->authError = '';
        $this->isAuthModalOpen = true;
    }

    public function closeCustomerAuthModal(): void
    {
        $this->isAuthModalOpen = false;
        $this->authError = '';
    }

    public function handleCustomerAuthSubmit(): void
    {
        $cleanPhone = preg_replace('/[^0-9]/', '', $this->authPhone);
        if (strlen($cleanPhone) < 8) {
            $this->authError = 'Nomor WhatsApp / HP tidak valid (minimal 8 digit).';
            return;
        }

        $cleanName = trim($this->authName);
        if (empty($cleanName)) {
            $this->authError = 'Nama lengkap wajib diisi.';
            return;
        }

        // Find or create customer
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
            $customer = Customer::create([
                'name' => $cleanName,
                'phone' => $cleanPhone,
                'points' => 50, // Welcome bonus
            ]);
            $isNew = true;
        } else {
            if (!empty($cleanName)) {
                $customer->update(['name' => $cleanName]);
            }
        }

        // Save session
        session(['travel_customer_phone' => $customer->phone]);

        $this->isLoggedIn = true;
        $this->customerName = $customer->name;
        $this->customerPhone = $customer->phone;
        $this->customerPoints = (int) ($customer->points ?? 0);
        $this->historyPhone = $customer->phone;

        $this->closeCustomerAuthModal();
        $this->setFeedback($isNew ? 'Pendaftaran berhasil! Anda mendapatkan bonus +50 Poin.' : 'Selamat datang kembali, ' . $customer->name . '!', 'success');
    }

    public function switchCustomerAccount(): void
    {
        session()->forget('travel_customer_phone');
        $this->isLoggedIn = false;
        $this->customerName = '';
        $this->customerPhone = '';
        $this->customerPoints = 0;
        $this->openCustomerAuthModal();
    }

    public function updateProfileName(): void
    {
        if (!$this->isLoggedIn || empty($this->customerPhone)) {
            return;
        }

        $cleanName = trim($this->customerName);
        if (empty($cleanName)) {
            $this->setFeedback('Nama lengkap tidak boleh kosong.', 'error');
            return;
        }

        $customer = Customer::where('phone', $this->customerPhone)->first();
        if ($customer) {
            $customer->update(['name' => $cleanName]);
            $this->customerName = $cleanName;
            $this->setFeedback('Nama profil berhasil diperbarui.', 'success');
        }
    }

    public function logoutCustomer(): void
    {
        session()->forget('travel_customer_phone');
        $this->isLoggedIn = false;
        $this->customerName = '';
        $this->customerPhone = '';
        $this->customerPoints = 0;
        $this->switchView('home');
        $this->setFeedback('Anda telah keluar dari akun.', 'info');
    }

    // ==========================================
    // DIRECT BOOKING (SHUTTLE REGULER)
    // ==========================================

    public function handleDirectBookingSubmit(): void
    {
        // 1. Validation
        if (!$this->isLoggedIn) {
            if (empty(trim($this->customerName)) || empty(trim($this->customerPhone))) {
                $this->setFeedback('Mohon isi nama dan nomor WhatsApp Anda terlebih dahulu.', 'error');
                return;
            }
        }

        if (empty(trim($this->pickupAddress))) {
            $this->setFeedback('Mohon tentukan titik penjemputan (Asal).', 'error');
            return;
        }

        if (empty(trim($this->dropoffAddress))) {
            $this->setFeedback('Mohon tentukan titik tujuan (Pengantaran).', 'error');
            return;
        }

        if ($this->seatQuantity < 4) {
            $this->setFeedback('Pemesanan shuttle minimal 4 kursi untuk rombongan eksekutif via Tol.', 'error');
            return;
        }

        try {
            DB::beginTransaction();

            // 2. Customer
            $cleanPhone = preg_replace('/[^0-9]/', '', $this->customerPhone);
            $customer = Customer::where('phone', $cleanPhone)->first();
            if (!$customer) {
                $customer = Customer::create([
                    'name' => trim($this->customerName),
                    'phone' => $cleanPhone,
                    'points' => 50,
                ]);
            } else {
                if (!empty($this->customerName)) {
                    $customer->update(['name' => trim($this->customerName)]);
                }
            }

            session(['travel_customer_phone' => $customer->phone]);
            $this->isLoggedIn = true;
            $this->customerName = $customer->name;
            $this->customerPhone = $customer->phone;
            $this->customerPoints = (int) ($customer->points ?? 0);

            // 3. Find or Create Schedule
            $depTime = strlen($this->selectedTime) === 5 ? ($this->selectedTime . ':00') : $this->selectedTime;
            $pickupLower = strtolower($this->pickupAddress);
            $isBandungOrigin = str_contains($pickupLower, 'bandung') || str_contains($pickupLower, 'pasteur') || str_contains($pickupLower, 'dipatiukur');

            $route = $isBandungOrigin
                ? Route::where('origin', 'like', '%Bandung%')->first()
                : Route::where('origin', 'like', '%Ciamis%')->first();

            if (!$route) {
                $route = Route::first() ?? Route::create([
                    'origin' => 'Ciamis',
                    'destination' => 'Bandung',
                    'base_price' => 190000,
                ]);
            }

            $schedule = Schedule::firstOrCreate([
                'route_id' => $route->id,
                'departure_date' => $this->departureDate ?: Carbon::today()->toDateString(),
                'departure_time' => $depTime,
            ], [
                'service_type' => Schedule::SERVICE_TYPE_REGULER,
                'min_quota' => 4,
                'status' => 'waiting_quota',
            ]);

            $unitPrice = (int) ($route->base_price ?? 190000);
            $finalTotal = $unitPrice * $this->seatQuantity;

            // 4. Booking Code
            $bookingCode = 'RVN-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));

            // 5. Booking Header
            $booking = Booking::create([
                'booking_code' => $bookingCode,
                'customer_id' => $customer->id,
                'schedule_id' => $schedule->id,
                'booking_type' => 'reguler',
                'total_passengers' => $this->seatQuantity,
                'duration_days' => 1,
                'pickup_address' => $this->pickupAddress,
                'dropoff_address' => $this->dropoffAddress,
                'destination_note' => $this->destinationNote ?: null,
                'total_amount' => $finalTotal,
                'payment_status' => Booking::PAYMENT_UNPAID,
                'status' => Booking::STATUS_PENDING,
                'notes' => 'Direct Booking: ' . $this->seatQuantity . ' Kursi Door to Door',
            ]);

            // 6. Booking Details
            $routeName = $route->origin . ' - ' . $route->destination;
            for ($i = 1; $i <= $this->seatQuantity; $i++) {
                $seatNumber = 'K-0' . $i;
                BookingDetail::create([
                    'booking_id' => $booking->id,
                    'item_type' => BookingDetail::ITEM_TYPE_SEAT,
                    'item_name' => 'Tiket Kursi ' . $seatNumber . ' (' . $routeName . ')',
                    'seat_number' => $seatNumber,
                    'passenger_name' => $i === 1 ? $customer->name : 'Penumpang ' . $i . ' (' . $customer->name . ')',
                    'passenger_phone' => $i === 1 ? $customer->phone : null,
                    'pickup_point' => $this->pickupAddress,
                    'drop_point' => $this->dropoffAddress,
                    'price' => $unitPrice,
                    'qty' => 1,
                    'subtotal' => $unitPrice,
                ]);
            }

            DB::commit();

            // 7. Request Dynamic QRIS
            $qrisResult = QrisPaymentService::createDynamicQris(
                $booking->booking_code,
                $booking->total_amount,
                [
                    'name' => $customer->name,
                    'phone' => $customer->phone,
                ]
            );

            // 8. Prepare Active Booking Array
            $this->activeBooking = $this->formatBookingToArray($booking->fresh(['customer', 'schedule.route', 'details']));

            if (!empty($qrisResult['success']) && !empty($qrisResult['data'])) {
                $this->qrisData = [
                    'booking_code' => $booking->booking_code,
                    'total_amount' => $finalTotal,
                    'formatted_amount' => 'Rp ' . number_format($finalTotal, 0, ',', '.'),
                    'qris_image_url' => $qrisResult['data']['qris_image_url'] ?? $qrisResult['data']['qr_image_url'] ?? null,
                    'qris_payload' => $qrisResult['data']['qris_payload'] ?? null,
                    'expires_at' => $qrisResult['data']['expires_at'] ?? now()->addMinutes(30)->toIso8601String(),
                ];
                $this->isQrisModalOpen = true;
            } else {
                // If QRIS gateway unavailable, go directly to ticket view
                $this->switchView('ticket');
            }

            $this->setFeedback('Pemesanan berhasil dibuat! Kode Booking: ' . $booking->booking_code, 'success');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Direct booking error: ' . $e->getMessage());
            $this->setFeedback('Gagal membuat pemesanan: ' . $e->getMessage(), 'error');
        }
    }

    // ==========================================
    // QRIS & PAYMENT METHODS
    // ==========================================

    public function closeQrisModal(): void
    {
        $this->isQrisModalOpen = false;
        if ($this->activeBooking) {
            $this->switchView('ticket');
        }
    }

    public function confirmPayment(): void
    {
        if (!$this->activeBooking || empty($this->activeBooking['booking_code'])) {
            return;
        }

        $booking = Booking::with('customer')->where('booking_code', $this->activeBooking['booking_code'])->first();
        if ($booking) {
            $booking->update([
                'payment_status' => Booking::PAYMENT_UNPAID, // Verifikasi admin
                'payment_method' => 'QRIS Dynamic (Scalify Pay)',
                'status' => Booking::STATUS_PENDING,
            ]);

            if ($booking->customer) {
                $booking->customer->increment('points', 25);
                $this->customerPoints = (int) $booking->customer->points;
            }

            $this->activeBooking = $this->formatBookingToArray($booking->fresh(['customer', 'schedule.route', 'details']));
            $this->closeQrisModal();
            $this->switchView('ticket');
            $this->setFeedback('Bukti pembayaran diterima! Admin sedang memverifikasi tiket Anda.', 'success');
        }
    }

    // ==========================================
    // ORDER HISTORY (TIKET SAYA)
    // ==========================================

    public function loadMyTickets(): void
    {
        $cleanPhone = preg_replace('/[^0-9]/', '', $this->historyPhone);
        if (strlen($cleanPhone) < 8) {
            $this->setFeedback('Masukkan nomor WhatsApp yang valid (minimal 8 digit).', 'error');
            return;
        }

        $customerIds = Customer::where('phone', $cleanPhone)
            ->orWhere(function ($q) use ($cleanPhone) {
                if (str_starts_with($cleanPhone, '62')) {
                    $q->orWhere('phone', '0' . substr($cleanPhone, 2));
                } elseif (str_starts_with($cleanPhone, '0')) {
                    $q->orWhere('phone', '62' . substr($cleanPhone, 1));
                }
                if (strlen($cleanPhone) >= 8) {
                    $q->orWhere('phone', 'like', '%' . substr($cleanPhone, -8));
                }
            })->pluck('id');

        $query = Booking::whereIn('customer_id', $customerIds)
            ->with(['customer', 'schedule.route', 'details'])
            ->latest();

        if ($this->historyFilter === 'paid') {
            $query->where(function ($q) {
                $q->where('payment_status', 'paid')->orWhere('status', 'confirmed');
            });
        } elseif ($this->historyFilter === 'unpaid') {
            $query->where('payment_status', '!=', 'paid')->where('status', '!=', 'confirmed');
        }

        $bookings = $query->get();
        $this->myTickets = $bookings->map(fn($b) => $this->formatBookingToArray($b))->toArray();
        $this->hasSearchedHistory = true;
    }

    public function setHistoryFilter(string $filter): void
    {
        $this->historyFilter = $filter;
        $this->loadMyTickets();
    }

    public function openTicketByCode(string $bookingCode): void
    {
        $booking = Booking::with(['customer', 'schedule.route', 'details'])
            ->where('booking_code', $bookingCode)
            ->first();

        if ($booking) {
            $this->activeBooking = $this->formatBookingToArray($booking);
            $this->switchView('ticket');
        }
    }

    // ==========================================
    // HELPER FORMATTERS
    // ==========================================

    protected function formatBookingToArray(Booking $b): array
    {
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
        }

        return [
            'id' => $b->id,
            'booking_code' => $b->booking_code,
            'booking_type' => $b->booking_type,
            'customer_name' => $b->customer->name ?? 'Penumpang',
            'customer_phone' => $b->customer->phone ?? '',
            'origin' => $origin,
            'destination' => $dest,
            'departure_time' => $depTime,
            'departure_date' => $depDate,
            'departure_date_formatted' => Carbon::parse($depDate)->locale('id')->isoFormat('D MMMM Y'),
            'total_amount' => (int) $b->total_amount,
            'total_amount_formatted' => 'Rp ' . number_format($b->total_amount, 0, ',', '.'),
            'seat_numbers' => $seatNumbers,
            'total_passengers' => $b->total_passengers ?? 1,
            'payment_status' => $b->payment_status,
            'payment_label' => $paymentLabel,
            'status' => $b->status,
            'status_label' => $statusLabel,
            'status_color' => $statusColor,
            'pickup_address' => $b->pickup_address ?? 'Penjemputan Door to Door',
            'dropoff_address' => $b->dropoff_address ?? 'Pengantaran Sampai Tujuan',
            'fleet_name' => 'Daihatsu All New Xenia',
            'created_at' => $b->created_at ? $b->created_at->format('d M Y, H:i') : date('d M Y, H:i'),
        ];
    }

    protected function setFeedback(string $message, string $type = 'success'): void
    {
        $this->feedbackMessage = $message;
        $this->feedbackType = $type;
    }

    public function clearFeedback(): void
    {
        $this->feedbackMessage = '';
    }

    // ==========================================
    // EAGER LOADED SCHEDULES (NO N+1 QUERY!)
    // ==========================================

    public function getSchedulesProperty(): array
    {
        $targetDate = $this->departureDate ?: Carbon::today()->toDateString();

        $schedules = Schedule::with(['route', 'bookings' => function ($q) {
            $q->whereIn('payment_status', ['paid', 'unpaid'])->with('details');
        }])
            ->whereDate('departure_date', $targetDate)
            ->orderBy('departure_time', 'asc')
            ->get();

        if ($schedules->isEmpty()) {
            $schedules = Schedule::with(['route', 'bookings' => function ($q) {
                $q->whereIn('payment_status', ['paid', 'unpaid'])->with('details');
            }])
                ->whereDate('departure_date', '>=', Carbon::today())
                ->orderBy('departure_date', 'asc')
                ->orderBy('departure_time', 'asc')
                ->limit(10)
                ->get();
        }

        if ($schedules->isEmpty()) {
            return [
                ['id' => 101, 'origin' => 'Ciamis', 'destination' => 'Bandung (Pasteur / Dipatiukur)', 'fleet_name' => 'Daihatsu All New Xenia', 'departure_time' => '06:00 WIB', 'price' => 190000, 'price_formatted' => 'Rp 190.000', 'booked_seats' => [2], 'total_seats' => 5],
                ['id' => 102, 'origin' => 'Ciamis', 'destination' => 'Bandung (Pasteur / Dipatiukur)', 'fleet_name' => 'Daihatsu All New Xenia', 'departure_time' => '09:00 WIB', 'price' => 190000, 'price_formatted' => 'Rp 190.000', 'booked_seats' => [], 'total_seats' => 5],
                ['id' => 103, 'origin' => 'Ciamis', 'destination' => 'Bandung (Pasteur / Dipatiukur)', 'fleet_name' => 'Daihatsu All New Xenia', 'departure_time' => '13:00 WIB', 'price' => 190000, 'price_formatted' => 'Rp 190.000', 'booked_seats' => [1], 'total_seats' => 5],
                ['id' => 104, 'origin' => 'Ciamis', 'destination' => 'Bandung (Pasteur / Dipatiukur)', 'fleet_name' => 'Daihatsu All New Xenia', 'departure_time' => '16:00 WIB', 'price' => 190000, 'price_formatted' => 'Rp 190.000', 'booked_seats' => [3, 4], 'total_seats' => 5],
                ['id' => 105, 'origin' => 'Ciamis', 'destination' => 'Bandung (Pasteur / Dipatiukur)', 'fleet_name' => 'Daihatsu All New Xenia', 'departure_time' => '19:30 WIB', 'price' => 190000, 'price_formatted' => 'Rp 190.000', 'booked_seats' => [], 'total_seats' => 5],
            ];
        }

        return $schedules->map(function ($s) {
            $originName = $s->route->origin ?? 'Ciamis';
            $destName = $s->route->destination ?? 'Bandung';
            $timeObj = Carbon::parse($s->departure_time);

            $bookedSeats = $s->bookings->flatMap(function ($b) {
                return $b->details ? $b->details->where('item_type', 'seat')->pluck('seat_number') : [];
            })->map(function ($num) {
                preg_match('/\d+/', (string)$num, $m);
                return isset($m[0]) ? (int)$m[0] : null;
            })->filter()->unique()->values()->toArray();

            $price = (int) ($s->route->base_price ?? 190000);

            return [
                'id' => $s->id,
                'origin' => $originName,
                'destination' => $destName,
                'fleet_name' => 'Daihatsu All New Xenia',
                'departure_time' => $timeObj->format('H:i') . ' WIB',
                'price' => $price,
                'price_formatted' => 'Rp ' . number_format($price, 0, ',', '.'),
                'total_seats' => 5,
                'booked_seats' => $bookedSeats,
                'date' => is_string($s->departure_date) ? $s->departure_date : optional($s->departure_date)->format('Y-m-d'),
            ];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.travell.booking-app');
    }
}
