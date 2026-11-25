<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use App\Services\Blog\BlogContentConverter;
use App\Services\Blog\BlogImageIngestor;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;

/**
 * API publik untuk memasukkan artikel blog dari luar (mis. AI riset konten FEED).
 * POST /api/blogs
 *
 * - Kategori dikirim sebagai nama; dibuat otomatis bila belum ada.
 * - content boleh HTML, teks biasa, atau JSON (objek/array). Non-HTML dikonversi AI ke HTML WYSIWYG.
 * - featured_image (opsional): file upload, URL http(s), atau base64 -> disimpan di storage public/blog_images.
 * - Artikel langsung terbit. Endpoint tanpa kunci (sesuai keputusan), dibatasi rate limit di route,
 *   dan HTML selalu dibersihkan (whitelist) karena ditampilkan apa adanya di website.
 */
class BlogApiController extends Controller
{
    public function store(Request $request, BlogContentConverter $converter, BlogImageIngestor $images): JsonResponse
    {
        // Lewat multipart (kirim file gambar), content JSON ikut sebagai string: kembalikan ke array.
        if (is_string($request->input('content')) && preg_match('/^\s*[\[{]/', $request->input('content'))) {
            $decoded = json_decode($request->input('content'), true);
            if (is_array($decoded)) {
                $request->merge(['content' => $decoded]);
            }
        }

        $data = $request->validate([
            'title'                => ['required', 'string', 'max:200'],
            'category'             => ['required', 'string', 'max:100'],
            'category_description' => ['nullable', 'string', 'max:1000'],
            'content'              => ['required'],
            'excerpt'              => ['nullable', 'string'],
            'tags'                 => ['nullable'],
            'meta_title'           => ['nullable', 'string'],
            'meta_description'     => ['nullable', 'string'],
            // File upload, URL http(s), atau base64/data URI. Diperiksa lebih lanjut di BlogImageIngestor.
            'featured_image'       => ['nullable'],
        ]);

        $content = $data['content'];
        if (!is_string($content) && !is_array($content)) {
            throw ValidationException::withMessages(['content' => 'Content harus berupa teks/HTML atau JSON (objek/array).']);
        }

        $title = trim($data['title']);
        $converted = $converter->convert($content, $title);
        $html = $converted['html'];
        $plain = trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags($html))));

        if ($plain === '') {
            throw ValidationException::withMessages(['content' => 'Content kosong setelah dibersihkan.']);
        }

        $authorId = $this->authorId();
        if (!$authorId) {
            Log::error('Blog API: tidak ada user untuk dijadikan penulis (BLOG_API_AUTHOR_ID / tabel users kosong).');

            return response()->json(['success' => false, 'message' => 'Penulis default belum dikonfigurasi di server.'], 500);
        }

        $imagePath = null;
        $image = $request->file('featured_image') ?? $request->input('featured_image');
        if ($image !== null && $image !== '') {
            if (!$image instanceof UploadedFile && !is_string($image)) {
                throw ValidationException::withMessages(['featured_image' => 'Gambar harus berupa file, URL http(s), atau base64.']);
            }
            try {
                $imagePath = $images->store($image);
            } catch (InvalidArgumentException $e) {
                throw ValidationException::withMessages(['featured_image' => $e->getMessage()]);
            }
        }

        try {
            [$category, $categoryCreated] = $this->resolveCategory($data['category'], $data['category_description'] ?? null);
            $blog = $this->createBlog($data, $title, $html, $plain, $category, $authorId, $imagePath);
        } catch (\Throwable $e) {
            $images->delete($imagePath); // jangan tinggalkan file yatim bila artikel gagal disimpan
            throw $e;
        }

        return response()->json([
            'success' => true,
            'message' => 'Artikel berhasil diterbitkan.',
            'data'    => [
                'id'             => $blog->id,
                'title'          => $blog->title,
                'slug'           => $blog->slug,
                'url'            => route('blogs.read', $blog->slug),
                'featured_image' => $imagePath ? asset('storage/' . $imagePath) : null,
                'category'       => [
                    'id'      => $category->id,
                    'name'    => $category->name,
                    'slug'    => $category->slug,
                    'created' => $categoryCreated,
                ],
                'content_source' => $converted['source'], // html | ai | fallback
                'reading_time'   => $blog->reading_time,
                'is_published'   => true,
                'published_at'   => $blog->published_at->toIso8601String(),
            ],
        ], 201);
    }

    private function createBlog(array $data, string $title, string $html, string $plain, BlogCategory $category, int $authorId, ?string $imagePath): Blog
    {
        return Blog::create([
            'category_id'      => $category->id,
            'author_id'        => $authorId,
            'title'            => $title,
            'slug'             => Blog::uniqueSlug($title),
            'excerpt'          => Str::limit(trim($data['excerpt'] ?? '') ?: $plain, 250),
            'content'          => $html,
            'tags'             => $this->tags($data['tags'] ?? null),
            'meta_title'       => filled($data['meta_title'] ?? null) ? Str::limit(trim($data['meta_title']), 57) : Str::limit($title, 57),
            'meta_description' => Str::limit(trim($data['meta_description'] ?? '') ?: $plain, 157),
            'reading_time'     => max(1, (int) ceil(str_word_count($plain) / 200)),
            'featured_image'   => $imagePath,
            'is_featured'      => false,
            'is_published'     => true,
            'published_at'     => now(),
        ]);
    }

    /** @return array{0: BlogCategory, 1: bool} kategori + apakah baru dibuat */
    private function resolveCategory(string $name, ?string $description): array
    {
        $name = Str::limit(trim(preg_replace('/\s+/', ' ', $name)), 100, '');
        $slug = Str::slug($name) ?: 'kategori-' . substr(md5(mb_strtolower($name)), 0, 8);

        if ($existing = BlogCategory::where('slug', $slug)->first()) {
            return [$existing, false];
        }

        try {
            $category = BlogCategory::create([
                'name'          => $name,
                'slug'          => $slug,
                'description'   => $description,
                'display_order' => (int) BlogCategory::max('display_order') + 1,
                'is_active'     => true,
            ]);

            return [$category, true];
        } catch (QueryException) {
            // Dua request bersamaan membuat kategori yang sama: pakai yang sudah tersimpan.
            return [BlogCategory::where('slug', $slug)->firstOrFail(), false];
        }
    }

    /** tags: array ["a","b"] atau string "a, b" -> array unik. */
    /** tags: array ["a","b"] atau string "a, b" -> array unik (lihat BlogTags::normalize), maks 15. */
    private function tags(mixed $tags): array
    {
        return array_slice(\App\Support\BlogTags::normalize($tags), 0, 15);
    }

    private function authorId(): ?int
    {
        $configured = config('services.blog_api.author_id');
        if ($configured && User::whereKey($configured)->exists()) {
            return (int) $configured;
        }

        return User::orderBy('id')->value('id');
    }
}
