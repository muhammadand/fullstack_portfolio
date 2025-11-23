<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use App\Helpers\AuthHelper;

class BlogController extends Controller
{
     public function __construct()
    {
        // Jika belum login -> stop di sini
        if ($resp = AuthHelper::mustLogin()) {
            // penting: return response dari constructor
            abort(redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.'));
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::with(['category', 'author'])->latest()->paginate(10);
        return view('blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = BlogCategory::active()->orderBy('display_order')->get();
        $authors = User::all();
        return view('blogs.create', compact('categories', 'authors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:blog_categories,id',
            'author_id' => 'required|exists:users,id',
            'title' => 'required|string|max:200',
            'excerpt' => 'nullable|string|max:255',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'tags' => 'nullable|array',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'reading_time' => 'nullable|integer',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ]);

        // Upload image jika ada
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('blog_images', 'public');
        }

        // Auto slug & handle published_at
        $validated['slug'] = Str::slug($validated['title']);
        $validated['published_at'] = $request->is_published ? now() : null;

        Blog::create($validated);

        return redirect()->route('blogs.index')->with('success', 'Blog berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        $blog->load(['category', 'author']);
        return view('blogs.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        $categories = BlogCategory::active()->orderBy('display_order')->get();
        $authors = User::all();
        return view('blogs.edit', compact('blog', 'categories', 'authors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:blog_categories,id',
            'author_id' => 'required|exists:users,id',
            'title' => 'required|string|max:200',
            'excerpt' => 'nullable|string|max:255',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'tags' => 'nullable|array',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'reading_time' => 'nullable|integer',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('featured_image')) {
            // Hapus gambar lama
            if ($blog->featured_image && Storage::disk('public')->exists($blog->featured_image)) {
                Storage::disk('public')->delete($blog->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('blog_images', 'public');
        }

        $validated['slug'] = Str::slug($validated['title']);
        $validated['published_at'] = $request->is_published ? now() : null;

        $blog->update($validated);

        return redirect()->route('blogs.index')->with('success', 'Blog berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        if ($blog->featured_image && Storage::disk('public')->exists($blog->featured_image)) {
            Storage::disk('public')->delete($blog->featured_image);
        }

        $blog->delete();

        return redirect()->route('blogs.index')->with('success', 'Blog berhasil dihapus!');
    }
}
