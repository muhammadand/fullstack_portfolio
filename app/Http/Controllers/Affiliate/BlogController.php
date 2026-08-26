<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BusinessCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Gemini\Laravel\Facades\Gemini;

class BlogController extends Controller
{
    public function index()
    {
        $affiliate = Auth::guard('affiliate')->user();

        $blogs = Blog::where('affiliate_id', $affiliate->id)
            ->with('businessCategory')
            ->latest()
            ->paginate(10);

        return view('affiliate.blogs.index', compact('affiliate', 'blogs'));
    }

    public function performance()
    {
        $affiliate = Auth::guard('affiliate')->user();

        $blogs = Blog::where('affiliate_id', $affiliate->id)
            ->where('is_published', true)
            ->with('businessCategory')
            ->latest('published_at')
            ->get();

        return view('affiliate.blogs.performance', compact('affiliate', 'blogs'));
    }

    public function create()
    {
        $affiliate = Auth::guard('affiliate')->user();
        $categories = BusinessCategory::all();

        return view('affiliate.blogs.create', compact('affiliate', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'business_category_id' => 'required|exists:business_categories,id',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $affiliate = Auth::guard('affiliate')->user();

        // Handle image upload
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('blogs', 'public');
        } else {
            $imagePath = null;
        }

        // Find default blog category (fallback)
        $defaultBlogCategory = \App\Models\BlogCategory::first();

        // Find default admin user for author_id
        $defaultAdmin = \App\Models\User::first();

        $blog = new Blog();
        $blog->title = $request->title;
        $blog->slug = Str::slug($request->title) . '-' . time();
        $blog->content = $request->content;
        $blog->excerpt = Str::limit(strip_tags($request->content), 150);
        $blog->featured_image = $imagePath;
        $blog->author_id = $defaultAdmin ? $defaultAdmin->id : 1;
        $blog->affiliate_id = $affiliate->id;
        $blog->business_category_id = $request->business_category_id;
        $blog->category_id = $defaultBlogCategory ? $defaultBlogCategory->id : 1;
        $blog->is_published = false;

        // Generate simple meta for SEO
        $blog->meta_title = Str::limit($request->title, 60, '');
        $blog->meta_description = Str::limit(strip_tags($request->content), 150);
        $blog->reading_time = max(1, ceil(str_word_count(strip_tags($request->content)) / 200));

        $blog->save();

        return redirect()->route('affiliate.blogs.index')->with('success', 'Artikel berhasil dikirim! Menunggu review dari Admin.');
    }

    public function generateAi(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:200',
            'business_category_id' => 'required|exists:business_categories,id',
        ]);

        $affiliate = Auth::guard('affiliate')->user();
        $category = BusinessCategory::findOrFail($request->business_category_id);

        $titleInstruction = $request->title
            ? "Topik/Judul: {$request->title}"
            : "Judul: Buatkan judul SEO-friendly yang sangat clickbait dan sedang hype/tren mengenai layanan '{$category->name}'.";

        $prompt = "Tulis artikel blog dalam bahasa Indonesia yang menarik dan SEO-friendly.
Target Market: Orang-orang yang tertarik dengan layanan '{$category->name}'.
{$titleInstruction}

Instruksi Format:
- Kembalikan respons MURNI dalam format JSON. JANGAN sertakan teks apapun di luar blok JSON.
- Struktur JSON HANYA boleh berisi dua key ini:
{
    \"title\": \"Judul artikel yang dihasilkan\",
    \"content\": \"Isi artikel murni dalam format HTML (gunakan <h2>, <p>, dll. Jangan ada tag <html> atau <body>)\"
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

            $htmlContent = trim($data['content']);
            $generatedTitle = trim($data['title']);

            // Buat CTA (Call to Action) link
            $konsultasiUrl = url('/sobat-scalify?ref=' . $affiliate->affiliate_code);

            // Ambil proposal sesuai kategori, jika tidak ada ambil random proposal apapun agar tidak error
            $proposal = \App\Models\ClientProposal::where('business_category_id', $category->id)->inRandomOrder()->first()
                ?? \App\Models\ClientProposal::inRandomOrder()->first();

            $promoUrl = $proposal ? route('landing.dynamic', $proposal->slug) . '?ref=' . $affiliate->affiliate_code : $konsultasiUrl;

            $ctaHtml = "
            <br>
            <div style='background-color: #fff7ed; padding: 15px; border-radius: 8px; border-left: 4px solid #f97316; margin-top: 20px;'>
                <p style='margin: 0; color: #9a3412;'><strong>Butuh layanan {$category->name} profesional?</strong></p>
                <p style='margin: 5px 0 0 0; color: #c2410c;'>Tingkatkan konversi dan branding bisnis Anda sekarang. <a href='{$konsultasiUrl}' style='color: #ea580c; text-decoration: underline; font-weight: bold;'>Konsultasi Gratis di Sini!</a></p>
                <p style='margin: 10px 0 0 0; color: #c2410c;'>Atau mau bikin website murah dan gratis tentang {$category->name}? <a href='{$promoUrl}' style='color: #ea580c; text-decoration: underline; font-weight: bold;'>Lihat demonya di sini!</a></p>
            </div>";

            return response()->json([
                'status' => 'success',
                'title' => $generatedTitle,
                'html' => $htmlContent . $ctaHtml
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghasilkan artikel AI: ' . $e->getMessage()
            ], 500);
        }
    }
}
