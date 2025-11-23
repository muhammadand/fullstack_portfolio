<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Helpers\AuthHelper;
class BlogCategoryController extends Controller
{
      public function __construct()
    {
        // Jika belum login -> stop di sini
        if ($resp = AuthHelper::mustLogin()) {
            // penting: return response dari constructor
            abort(redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.'));
        }
    }
    // Tampilkan semua kategori di view
    public function index(Request $request)
    {
        $query = BlogCategory::orderBy('display_order');

        // Jika ada pencarian
        if ($request->has('q') && $request->q != '') {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        // Pagination 10 per halaman
        $categories = $query->paginate(10);

        return view('category-blogs.index', compact('categories'));
    }

    // Tampilkan form create kategori
    public function create()
    {
        return view('category-blogs.create');
    }

    // Simpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'meta_description' => 'nullable|string|max:255',
            'display_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $category = BlogCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'meta_description' => $request->meta_description,
            'display_order' => $request->display_order ?? 0,
            'is_active' => $request->is_active ?? true,
            'created_at' => now(),
        ]);

        return redirect()->route('blog-categories.index')->with('success', 'Kategori berhasil dibuat');
    }

    // Tampilkan form edit kategori
    public function edit($id)
    {
        $category = BlogCategory::findOrFail($id);
        return view('category-blogs.edit', compact('category'));
    }

    // Update kategori
    public function update(Request $request, $id)
    {
        $category = BlogCategory::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'meta_description' => 'nullable|string|max:255',
            'display_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $category->update([
            'name' => $request->name ?? $category->name,
            'slug' => $request->name ? Str::slug($request->name) : $category->slug,
            'description' => $request->description ?? $category->description,
            'meta_description' => $request->meta_description ?? $category->meta_description,
            'display_order' => $request->display_order ?? $category->display_order,
            'is_active' => $request->is_active ?? $category->is_active,
        ]);

        return redirect()->route('blog-categories.index')->with('success', 'Kategori berhasil diperbarui');
    }

    // Hapus kategori
    public function destroy($id)
    {
        $category = BlogCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('blog-categories.index')->with('success', 'Kategori berhasil dihapus');
    }
}
