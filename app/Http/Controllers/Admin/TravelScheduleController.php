<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route as TravelRoute;
use App\Models\Schedule as TravelSchedule;
use Illuminate\Http\Request;

class TravelScheduleController extends Controller
{
    /**
     * Display a listing of schedules.
     */
    public function index(Request $request)
    {
        $routeId = $request->query('route_id');
        $date = $request->query('date');
        $status = $request->query('status');

        $query = TravelSchedule::with('route')->withCount('bookings')->latest('departure_date')->orderBy('departure_time', 'asc');

        if ($routeId) {
            $query->where('route_id', $routeId);
        }

        if ($date) {
            $query->whereDate('departure_date', $date);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $schedules = $query->paginate(20)->withQueryString();
        $routes = TravelRoute::all();

        return view('admin.travel_schedules.index', compact('schedules', 'routes', 'routeId', 'date', 'status'));
    }

    /**
     * Store a newly created schedule.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'route_id' => 'required|exists:routes,id',
            'departure_date' => 'required|date',
            'departure_time' => 'required',
            'service_type' => 'required|in:reguler,premium_sopir',
            'min_quota' => 'required|integer|min:1|max:20',
            'status' => 'required|in:waiting_quota,confirmed,departed,completed,cancelled',
        ]);

        TravelSchedule::create($validated);

        return redirect()->route('admin.travel_schedules.index')->with('success', 'Jadwal keberangkatan baru berhasil ditambahkan.');
    }

    /**
     * Update the specified schedule.
     */
    public function update(Request $request, $id)
    {
        $schedule = TravelSchedule::findOrFail($id);

        $validated = $request->validate([
            'route_id' => 'required|exists:routes,id',
            'departure_date' => 'required|date',
            'departure_time' => 'required',
            'service_type' => 'required|in:reguler,premium_sopir',
            'min_quota' => 'required|integer|min:1|max:20',
            'status' => 'required|in:waiting_quota,confirmed,departed,completed,cancelled',
        ]);

        $schedule->update($validated);

        return redirect()->route('admin.travel_schedules.index')->with('success', 'Jadwal keberangkatan berhasil diperbarui.');
    }

    /**
     * Remove the specified schedule.
     */
    public function destroy($id)
    {
        $schedule = TravelSchedule::findOrFail($id);

        if ($schedule->bookings()->count() > 0) {
            return back()->with('error', 'Jadwal ini tidak dapat dihapus karena sudah memiliki pemesanan tiket dari penumpang.');
        }

        $schedule->delete();

        return redirect()->route('admin.travel_schedules.index')->with('success', 'Jadwal keberangkatan berhasil dihapus.');
    }
}
