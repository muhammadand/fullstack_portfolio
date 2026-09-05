<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DigitalProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DigitalProductController extends Controller
{
    public function index(Request $request)
    {
        $query = DigitalProduct::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('lynk_slug', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $products = $query->orderBy('display_order', 'asc')->latest()->paginate(10)->withQueryString();
        $categories = DigitalProduct::distinct()->pluck('category')->filter()->values();

        return view('admin.digital_products.index', compact('products', 'categories'));
    }

    public function create()
    {
        return view('admin.digital_products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:digital_products,slug',
            'lynk_slug' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'demo_url' => 'nullable|url|max:255',
            'is_active' => 'boolean',
            'display_order' => 'integer|min:0',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
            // Ensure unique slug
            $originalSlug = $validated['slug'];
            $count = 1;
            while (DigitalProduct::where('slug', $validated['slug'])->exists()) {
                $validated['slug'] = "{$originalSlug}-{$count}";
                $count++;
            }
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['display_order'] = $request->input('display_order', 0);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('digital_products', 'public');
        }

        DigitalProduct::create($validated);

        return redirect()->route('admin.digital_products.index')->with('success', 'Produk digital berhasil ditambahkan!');
    }

    public function edit(DigitalProduct $digitalProduct)
    {
        return view('admin.digital_products.edit', compact('digitalProduct'));
    }

    public function update(Request $request, DigitalProduct $digitalProduct)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:digital_products,slug,' . $digitalProduct->id,
            'lynk_slug' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'demo_url' => 'nullable|url|max:255',
            'is_active' => 'boolean',
            'display_order' => 'integer|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['display_order'] = $request->input('display_order', 0);

        if ($request->hasFile('thumbnail')) {
            if ($digitalProduct->thumbnail && Storage::disk('public')->exists($digitalProduct->thumbnail)) {
                Storage::disk('public')->delete($digitalProduct->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('digital_products', 'public');
        }

        $digitalProduct->update($validated);

        return redirect()->route('admin.digital_products.index')->with('success', 'Produk digital berhasil diperbarui!');
    }

    public function destroy(DigitalProduct $digitalProduct)
    {
        if ($digitalProduct->thumbnail && Storage::disk('public')->exists($digitalProduct->thumbnail)) {
            Storage::disk('public')->delete($digitalProduct->thumbnail);
        }

        $digitalProduct->delete();

        return redirect()->route('admin.digital_products.index')->with('success', 'Produk digital berhasil dihapus!');
    }
}
