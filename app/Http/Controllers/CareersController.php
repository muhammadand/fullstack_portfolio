<?php

namespace App\Http\Controllers;

use App\Models\Career; // Menggunakan nama model standar (PascalCase & Singular)
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CareersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data career dengan paginasi (misal: 10 data per halaman)
        $careers = Career::latest()->paginate(10);
        
        return view('careers.index', compact('careers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('careers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input data
        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'nullable|string',
            'qualifications'  => 'nullable|string',
            'employment_type' => 'nullable|string|max:100',
            'work_mode'       => 'nullable|string|max:100',
            'location'        => 'nullable|string|max:255',
            'salary_min'      => 'nullable|numeric|min:0',
            'salary_max'      => 'nullable|numeric|min:0',
            'closing_date'    => 'nullable|date',
            'is_active'       => 'boolean',
        ]);

        // Generate slug otomatis dari title jika tidak diisi manual
        $validated['slug'] = Str::slug($request->title) . '-' . time();
        
        // Atur default value untuk checkbox is_active
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('careers', 'public');
        }

        Career::create($validated);

        return redirect()->route('careers.index')->with('success', 'Career lowongan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Career $career)
    {
        return view('careers.show', compact('career'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Career $career)
    {
  
        return view('careers.edit', compact('career'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Career $career)
    {
        // Validasi input data (kecuali slug unik milik data ini sendiri jika ada modifikasi)
        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'nullable|string',
            'qualifications'  => 'nullable|string',
            'employment_type' => 'nullable|string|max:100',
            'work_mode'       => 'nullable|string|max:100',
            'location'        => 'nullable|string|max:255',
            'salary_min'      => 'nullable|numeric|min:0',
            'salary_max'      => 'nullable|numeric|min:0',
            'closing_date'    => 'nullable|date',
            'is_active'       => 'boolean',
        ]);

        // Update slug jika title berubah (opsional, tergantung kebutuhan bisnis)
        if ($career->title !== $request->title) {
            $validated['slug'] = Str::slug($request->title) . '-' . time();
        }

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('featured_image')) {
            if ($career->featured_image && \Illuminate\Support\Facades\Storage::disk('public')->exists($career->featured_image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($career->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('careers', 'public');
        }

        $career->update($validated);

        return redirect()->route('careers.index')->with('success', 'Career lowongan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Career $career)
    {
        $career->delete();

        return redirect()->route('careers.index')->with('success', 'Career lowongan berhasil dihapus!');
    }

    public function getByslug($slug)
    {
        $career = Career::where('slug', $slug)->firstOrFail();
        
        $otherCareers = Career::where('is_active', true)
                              ->where('id', '!=', $career->id)
                              ->orderBy('created_at', 'desc')
                              ->take(3)
                              ->get();
                              
        return view('careers.getBySlug', compact('career', 'otherCareers'));
    }

    public function listCareers(Request $request){
        $query = Career::where('is_active', true);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('employment_type', 'like', "%{$search}%");
            });
        }

        // Tampilkan yang terbaru dulu (created_at DESC) dan waktu closing terdekat (closing_date ASC)
        $careers = $query->orderBy('created_at', 'desc')
                         ->orderBy('closing_date', 'asc')
                         ->paginate(10);

        return view('careers.listCareers', compact('careers'));
    }

    public function uploadImage(Request $request)
    {
        $request->validate(['image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:5120']);

        $path = $request->file('image')->store('uploads/careers/content', 'public');

        return response()->json(['url' => asset('storage/' . $path)]);
    }
}