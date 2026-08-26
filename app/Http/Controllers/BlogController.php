<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Gemini\Laravel\Facades\Gemini;

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


    //from public

    public function getBlogs()
    {
        $blogs = Blog::published()->latest()->get();
        return view('blogs.getBlogs', compact('blogs'));
    }

    /**
     * Upload inline image from WYSIWYG editor.
     */
    public function uploadImage(Request $request)
    {
        $request->validate(['image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:5120']);

        $path = $request->file('image')->store('uploads/blog/content', 'public');

        return response()->json(['url' => asset('storage/' . $path)]);
    }
    /**
     * Quick publish from admin dashboard.
     */
    public function publish(Blog $blog)
    {
        $blog->is_published = true;
        if (empty($blog->published_at)) {
            $blog->published_at = now();
        }
        $blog->save(); // This will trigger the Boot event in Blog.php and give +10 points to affiliate!

        return redirect()->back()->with('success', 'Blog berhasil di-publish! Affiliate akan mendapat poin.');
    }

    /**
     * Generate content and meta using Gemini AI
     */
    public function generateAi(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:200',
            'category_id' => 'required|exists:blog_categories,id',
        ]);

        $category = BlogCategory::findOrFail($request->category_id);

        $titleInstruction = $request->title
            ? "Topik/Judul: {$request->title}"
            : "Judul: Buatkan judul SEO-friendly yang sangat clickbait dan sedang hype/tren mengenai kategori '{$category->name}'.";

        $prompt = "Tulis artikel blog dalam bahasa Indonesia yang menarik dan SEO-friendly.
Kategori: '{$category->name}'.
{$titleInstruction}

Instruksi Format:
- Kembalikan respons MURNI dalam format JSON. JANGAN sertakan teks apapun di luar blok JSON.
- Struktur JSON HANYA boleh berisi 6 key ini:
{
    \"title\": \"Judul artikel yang dihasilkan\",
    \"content\": \"Isi artikel murni dalam format HTML (gunakan <h2>, <p>, dll. Jangan ada tag <html> atau <body>)\",
    \"excerpt\": \"Ringkasan artikel max 150 karakter\",
    \"meta_title\": \"Judul SEO singkat max 60 karakter\",
    \"meta_description\": \"Deskripsi SEO memikat max 150 karakter\",
    \"tags\": \"kata kunci 1, kata kunci 2, kata kunci 3\"
}
- Panjang artikel sekitar 300-400 kata. Buat paragraf pendek agar nyaman dibaca di mobile.
";

        try {
            $response = Gemini::generativeModel('gemini-3.1-flash-lite')->generateContent($prompt);
            $responseText = $response->text();

            // Bersihkan markdown wrapper untuk parsing JSON
            $responseText = preg_replace('/^```json\s*|\s*```$/i', '', trim($responseText));

            $data = json_decode($responseText, true);

            if (!$data || !isset($data['content']) || !isset($data['title'])) {
                throw new \Exception("Format respons AI tidak valid atau JSON rusak.");
            }

            return response()->json([
                'status' => 'success',
                'title' => trim($data['title']),
                'html' => trim($data['content']),
                'excerpt' => $data['excerpt'] ?? '',
                'meta_title' => $data['meta_title'] ?? '',
                'meta_description' => $data['meta_description'] ?? '',
                'tags' => $data['tags'] ?? ''
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghasilkan artikel AI: ' . $e->getMessage()
            ], 500);
        }
    }
}
