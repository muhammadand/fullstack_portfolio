<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route as TravelRoute;
use Illuminate\Http\Request;

class TravelRouteController extends Controller
{
    /**
     * Display a listing of routes.
     */
    public function index()
    {
        $routes = TravelRoute::withCount('schedules')->latest()->paginate(15);

        return view('admin.travel_routes.index', compact('routes'));
    }

    /**
     * Store a newly created route.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'origin' => 'required|string|max:100',
            'destination' => 'required|string|max:100',
            'base_price' => 'required|numeric|min:0',
        ]);

        TravelRoute::create($validated);

        return redirect()->route('admin.travel_routes.index')->with('success', 'Rute perjalanan baru berhasil ditambahkan.');
    }

    /**
     * Update the specified route.
     */
    public function update(Request $request, $id)
    {
        $route = TravelRoute::findOrFail($id);

        $validated = $request->validate([
            'origin' => 'required|string|max:100',
            'destination' => 'required|string|max:100',
            'base_price' => 'required|numeric|min:0',
        ]);

        $route->update($validated);

        return redirect()->route('admin.travel_routes.index')->with('success', 'Rute perjalanan berhasil diperbarui.');
    }

    /**
     * Remove the specified route.
     */
    public function destroy($id)
    {
        $route = TravelRoute::findOrFail($id);

        if ($route->schedules()->count() > 0) {
            return back()->with('error', 'Rute ini tidak dapat dihapus karena masih memiliki jadwal keberangkatan aktif.');
        }

        $route->delete();

        return redirect()->route('admin.travel_routes.index')->with('success', 'Rute perjalanan berhasil dihapus.');
    }
}
