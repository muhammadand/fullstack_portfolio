<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use Illuminate\Http\Request;
use App\Helpers\AuthHelper;

class PortfolioController extends Controller
{
    public function __construct()
    {
        // Jika belum login -> stop di sini
        if ($resp = AuthHelper::mustLogin()) {
            // penting: return response dari constructor
            abort(redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.'));
        }
    }
    public function index(Request $request)
    {
        // 🔍 Ambil kategori untuk dropdown filter
        $categories = PortfolioCategory::orderBy('display_order')->get();

        // 🔎 Query dasar
        $query = Portfolio::with('category');

        // ✅ Filter berdasarkan kategori (jika ada)
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        // ✅ Filter berdasarkan status aktif
        if ($request->has('is_active') && $request->is_active != '') {
            $query->where('is_active', $request->is_active);
        }

        // ✅ Filter berdasarkan pencarian judul
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // 🔹 Urutkan & paginasi
        $portfolios = $query->orderBy('display_order', 'asc')->paginate(10);

        return view('portfolio.index', compact('portfolios', 'categories'));
    }

    // 🔹 Tampilkan form create
    public function create()
    {
        $categories = PortfolioCategory::orderBy('display_order')->get();
        return view('portfolio.create', compact('categories'));
    }

    // 🔹 Simpan data portfolio baru
    public function store(Request $request)
    {
        // ✅ Validasi (sesuaikan rules di model Portfolio)
        $validated = $request->validate([
            'category_id' => 'required|exists:portfolio_categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:portfolios,slug',
            'client_name' => 'nullable|string|max:255',
            'project_type' => 'nullable|string|max:255',
            'short_description' => 'nullable|string',
            'full_description' => 'nullable|string',
            'challenge' => 'nullable|string',
            'solution' => 'nullable|string',
            'result' => 'nullable|string',
            'technologies' => 'nullable|string',
            'project_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'completion_date' => 'nullable|date',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'thumbnail_image' => 'nullable|image|mimes:jpg,jpeg,png|max:20000',
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png|max:20000',
        ]);

        // ✅ Upload file jika ada
        if ($request->hasFile('thumbnail_image')) {
            $validated['thumbnail_image'] = $request->file('thumbnail_image')->store('uploads/portfolio', 'public');
        }

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('uploads/portfolio', 'public');
        }

        // ✅ Simpan ke database
        \App\Models\Portfolio::create($validated);

        return redirect()->route('portfolio.index')->with('success', 'Portfolio berhasil ditambahkan!');
    }


    // 🔹 Edit
    public function edit($id)
    {
        $item = Portfolio::findOrFail($id);
        $categories = PortfolioCategory::orderBy('display_order')->get();
        return view('portfolio.edit', compact('item', 'categories'));
    }

    // 🔹 Update data
    public function update(Request $request, $id)
    {
        $portfolio = Portfolio::findOrFail($id);

        $validated = $request->validate(Portfolio::rules($id));

        // 🔹 Ubah technologies string → array
        if (!empty($validated['technologies'])) {
            $validated['technologies'] = array_map('trim', explode(',', $validated['technologies']));
        }

        // 🔹 Upload thumbnail jika ada file baru
        if ($request->hasFile('thumbnail_image')) {
            $validated['thumbnail_image'] = $request->file('thumbnail_image')
                ->store('uploads/portfolio', 'public');
        }

        // 🔹 Upload featured_image jika ada file baru
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')
                ->store('uploads/portfolio', 'public');
        }

        $portfolio->update($validated);

        return redirect()->route('portfolio.index')
            ->with('success', 'Portfolio berhasil diperbarui!');
    }


    // 🔹 Hapus
    public function destroy($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        $portfolio->delete();

        return redirect()->route('portfolio.index')
            ->with('success', 'Portfolio berhasil dihapus!');
    }
}
