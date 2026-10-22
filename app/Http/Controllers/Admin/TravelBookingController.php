<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TravelBookingController extends Controller
{
    /**
     * Display a listing of travel bookings.
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        $type = $request->query('type');
        $search = $request->query('search');
        $date = $request->query('date');

        $query = Booking::with(['customer', 'schedule.route', 'details'])->latest();

        if ($status && in_array($status, ['pending', 'confirmed', 'completed', 'cancelled'])) {
            $query->where('status', $status);
        }

        if ($type && in_array($type, ['reguler', 'charter'])) {
            $query->where('booking_type', $type);
        }

        if ($date) {
            $query->where(function ($q) use ($date) {
                $q->whereDate('charter_date', $date)
                    ->orWhereHas('schedule', function ($sq) use ($date) {
                        $sq->whereDate('departure_date', $date);
                    });
            });
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('booking_code', 'like', "%{$search}%")
                    ->orWhere('pickup_address', 'like', "%{$search}%")
                    ->orWhere('dropoff_address', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($cq) use ($search) {
                        $cq->where('name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
            });
        }

        $bookings = $query->paginate(15)->withQueryString();

        // Statistics Cards
        $stats = (object) [
            'total' => Booking::count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'completed' => Booking::where('status', 'completed')->count(),
            'total_revenue' => Booking::where('payment_status', 'paid')->sum('total_amount'),
        ];

        return view('admin.travel_bookings.index', compact('bookings', 'stats', 'status', 'type', 'search', 'date'));
    }

    /**
     * Show booking details for modal inspection.
     */
    public function show($id)
    {
        $booking = Booking::with(['customer', 'schedule.route', 'details'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $booking,
        ]);
    }

    /**
     * Update booking status & payment status.
     */
    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'payment_status' => 'required|in:unpaid,paid,refunded,cancelled',
            'notes' => 'nullable|string|max:500',
        ]);

        $booking->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Pesanan #{$booking->booking_code} berhasil diperbarui.",
                'booking' => $booking->fresh(['customer', 'schedule.route']),
            ]);
        }

        return back()->with('success', "Status pesanan #{$booking->booking_code} berhasil diperbarui!");
    }

    /**
     * Quick 1-click verify payment.
     */
    public function verifyPayment($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update([
            'payment_status' => Booking::PAYMENT_PAID,
            'status' => Booking::STATUS_CONFIRMED,
        ]);

        return back()->with('success', "Pembayaran pesanan #{$booking->booking_code} diverifikasi Lunas & status diubah ke Terkonfirmasi.");
    }

    /**
     * Remove the specified booking.
     */
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $code = $booking->booking_code;
        $booking->delete();

        return back()->with('success', "Pesanan #{$code} berhasil dihapus.");
    }
}
