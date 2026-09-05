<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DigitalProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DigitalProductApiController extends Controller
{
    /**
     * Get list of digital products
     * GET /api/digital-products
     */
    public function index(Request $request)
    {
        $query = DigitalProduct::query();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('lynk_slug', 'like', "%{$search}%");
            });
        }

        if ($request->boolean('active_only', true)) {
            $query->active();
        }

        $products = $query->ordered()->paginate($request->input('per_page', 20));

        return response()->json([
            'status' => 'success',
            'data' => $products
        ]);
    }

    /**
     * Create a single digital product
     * POST /api/digital-products
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:digital_products,slug',
            'lynk_slug' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'thumbnail' => 'nullable', // can be file or URL string
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'demo_url' => 'nullable|url|max:255',
            'is_active' => 'nullable|boolean',
            'display_order' => 'nullable|integer|min:0',
        ]);

        // Generate unique slug if not provided
        if (empty($validated['slug'])) {
            $baseSlug = Str::slug($validated['name']);
            $slug = $baseSlug;
            $count = 1;
            while (DigitalProduct::where('slug', $slug)->exists()) {
                $slug = "{$baseSlug}-{$count}";
                $count++;
            }
            $validated['slug'] = $slug;
        }

        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : true;
        $validated['display_order'] = (int)($request->input('display_order', 0));

        // Handle thumbnail upload if file provided
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('digital_products', 'public');
        } elseif (is_string($request->input('thumbnail')) && !empty($request->input('thumbnail'))) {
            $validated['thumbnail'] = $request->input('thumbnail');
        }

        $product = DigitalProduct::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Produk digital berhasil dibuat.',
            'data' => $product
        ], 201);
    }

    /**
     * Bulk store multiple digital products
     * POST /api/digital-products/bulk
     */
    public function bulkStore(Request $request)
    {
        $request->validate([
            'products' => 'required|array|min:1',
            'products.*.name' => 'required|string|max:255',
            'products.*.lynk_slug' => 'required|string|max:255',
            'products.*.category' => 'nullable|string|max:100',
            'products.*.price' => 'required|numeric|min:0',
            'products.*.thumbnail' => 'nullable|string',
            'products.*.short_description' => 'nullable|string|max:500',
            'products.*.description' => 'nullable|string',
            'products.*.demo_url' => 'nullable|url|max:255',
            'products.*.is_active' => 'nullable|boolean',
            'products.*.display_order' => 'nullable|integer|min:0',
        ]);

        $created = [];
        $failed = 0;

        foreach ($request->products as $item) {
            try {
                $slug = $item['slug'] ?? Str::slug($item['name']);
                $originalSlug = $slug;
                $count = 1;
                while (DigitalProduct::where('slug', $slug)->exists()) {
                    $slug = "{$originalSlug}-{$count}";
                    $count++;
                }
                $item['slug'] = $slug;
                $item['is_active'] = isset($item['is_active']) ? (bool)$item['is_active'] : true;
                $item['display_order'] = (int)($item['display_order'] ?? 0);

                $product = DigitalProduct::create($item);
                $created[] = $product;
            } catch (\Exception $e) {
                Log::error("Failed to insert digital product via API bulk: " . $e->getMessage());
                $failed++;
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Bulk insert produk digital selesai.',
            'data' => [
                'inserted_count' => count($created),
                'failed_count' => $failed,
                'items' => $created
            ]
        ], 201);
    }

    /**
     * Detail of single digital product
     * GET /api/digital-products/{id}
     */
    public function show($id)
    {
        $product = DigitalProduct::find($id);

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Produk digital tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $product
        ]);
    }
}
