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
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q'));

        $blogs = Blog::with(['category:id,name', 'author:id,name', 'affiliate:id,name'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhereHas('category', fn ($c) => $c->where('name', 'like', "%{$search}%"));
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blogs.create', $this->formOptions());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->validateBlog($request);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('blog_images', 'public');
        }

        $validated['slug'] = Str::slug($validated['title']);
        $validated['published_at'] = $validated['is_published'] ? now() : null;

        Blog::create($validated);

        return redirect()->route('blogs.index')->with('success', 'Blog berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        $blog->load(['category:id,name', 'author:id,name', 'affiliate:id,name']);
        return view('blogs.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        return view('blogs.edit', ['blog' => $blog] + $this->formOptions());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $validated = $this->validateBlog($request);
        unset($validated['remove_image']);

        if ($request->hasFile('featured_image')) {
            $this->deleteImage($blog->featured_image);
            $validated['featured_image'] = $request->file('featured_image')->store('blog_images', 'public');
        } elseif ($request->boolean('remove_image')) {
            $this->deleteImage($blog->featured_image);
            $validated['featured_image'] = null;
        }

        $validated['slug'] = Str::slug($validated['title']);
        // Pertahankan tanggal terbit asli; hanya diisi saat pertama kali dipublish
        $validated['published_at'] = $validated['is_published'] ? ($blog->published_at ?? now()) : null;

        $blog->update($validated);

        return redirect()->route('blogs.index')->with('success', 'Blog berhasil diperbarui!');
    }

    /**
     * Data dropdown untuk form create/edit.
     */
    private function formOptions(): array
    {
        return [
            'categories' => BlogCategory::active()->orderBy('display_order')->get(['id', 'name']),
            'authors' => User::orderBy('name')->get(['id', 'name']),
        ];
    }

    /**
     * Validasi form blog (dipakai store & update).
     */
    private function validateBlog(Request $request): array
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:blog_categories,id',
            'author_id' => 'required|exists:users,id',
            'title' => 'required|string|max:200',
            'excerpt' => 'nullable|string|max:255',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'remove_image' => 'nullable|boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|string',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'reading_time' => 'nullable|integer',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ]);

        // Input tags berupa satu teks "a, b, c" -> pecah jadi array
        $validated['tags'] = collect($validated['tags'] ?? [])
            ->flatMap(fn ($tag) => explode(',', (string) $tag))
            ->map(fn ($tag) => trim($tag))
            ->filter()
            ->unique()
            ->values()
            ->all();

        // Kolom excerpt NOT NULL: isi otomatis dari konten jika dikosongkan
        if (blank($validated['excerpt'] ?? null)) {
            $plain = trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags($validated['content']))));
            $validated['excerpt'] = Str::limit($plain, 150);
        }

        $validated['is_featured'] = (bool) ($validated['is_featured'] ?? false);
        $validated['is_published'] = (bool) ($validated['is_published'] ?? false);

        return $validated;
    }

    private function deleteImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $this->deleteImage($blog->featured_image);

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
