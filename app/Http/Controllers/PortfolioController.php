<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use Illuminate\Http\Request;
use App\Helpers\AuthHelper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        $search = trim((string) $request->query('search'));

        $portfolios = Portfolio::select(['id', 'category_id', 'title', 'client_name', 'thumbnail_image', 'is_active', 'is_featured', 'display_order'])
            ->with('category:id,name')
            ->when($request->filled('category_id'), fn ($q) => $q->where('category_id', $request->category_id))
            ->when($request->filled('is_active'), fn ($q) => $q->where('is_active', $request->boolean('is_active')))
            ->when($search !== '', fn ($q) => $q->where('title', 'like', "%{$search}%"))
            ->orderBy('display_order')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('portfolio.index', [
            'portfolios' => $portfolios,
            'categories' => PortfolioCategory::orderBy('display_order')->get(['id', 'name']),
        ]);
    }

    public function create()
    {
        return view('portfolio.create', $this->formOptions());
    }

    public function store(Request $request)
    {
        $validated = $this->validatePortfolio($request);

        $validated['thumbnail_image'] = $request->file('thumbnail_image')->store('uploads/portfolio', 'public');

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('uploads/portfolio', 'public');
        }

        Portfolio::create($validated);

        return redirect()->route('portfolio.index')->with('success', 'Portfolio berhasil ditambahkan!');
    }

    public function edit(Portfolio $portfolio)
    {
        return view('portfolio.edit', ['item' => $portfolio] + $this->formOptions());
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $validated = $this->validatePortfolio($request, $portfolio);
        unset($validated['remove_featured_image']);

        if ($request->hasFile('thumbnail_image')) {
            $this->deleteImage($portfolio->thumbnail_image);
            $validated['thumbnail_image'] = $request->file('thumbnail_image')->store('uploads/portfolio', 'public');
        }

        if ($request->hasFile('featured_image')) {
            $this->deleteImage($portfolio->featured_image);
            $validated['featured_image'] = $request->file('featured_image')->store('uploads/portfolio', 'public');
        } elseif ($request->boolean('remove_featured_image')) {
            $this->deleteImage($portfolio->featured_image);
            $validated['featured_image'] = null;
        }

        $portfolio->update($validated);

        return redirect()->route('portfolio.index')->with('success', 'Portfolio berhasil diperbarui!');
    }

    public function destroy(Portfolio $portfolio)
    {
        $this->deleteImage($portfolio->thumbnail_image);
        $this->deleteImage($portfolio->featured_image);

        $portfolio->delete();

        return redirect()->route('portfolio.index')->with('success', 'Portfolio berhasil dihapus!');
    }

    /**
     * Data dropdown untuk form create/edit.
     */
    private function formOptions(): array
    {
        return [
            'categories' => PortfolioCategory::orderBy('display_order')->get(['id', 'name']),
        ];
    }

    /**
     * Validasi + normalisasi input (dipakai store & update).
     */
    private function validatePortfolio(Request $request, ?Portfolio $portfolio = null): array
    {
        $validated = $request->validate(Portfolio::rules($portfolio?->id));

        // Field file hanya boleh masuk jika benar-benar ada upload baru (jangan menimpa gambar lama dengan null)
        unset($validated['thumbnail_image'], $validated['featured_image']);

        $validated['slug'] = $this->uniqueSlug($validated['slug'] ?? '', $validated['title'], $portfolio?->id);

        // "Laravel, Vue.js , MySQL" -> ['Laravel', 'Vue.js', 'MySQL']
        $validated['technologies'] = collect(explode(',', (string) ($validated['technologies'] ?? '')))
            ->map(fn ($tech) => trim($tech))
            ->filter()
            ->unique()
            ->values()
            ->all();

        $validated['is_featured'] = (bool) ($validated['is_featured'] ?? false);
        $validated['is_active'] = (bool) ($validated['is_active'] ?? false);

        return $validated;
    }

    /**
     * Slug dari input (atau dari judul jika kosong), dijamin unik.
     */
    private function uniqueSlug(string $slug, string $title, ?int $ignoreId): string
    {
        $base = Str::slug($slug !== '' ? $slug : $title) ?: 'portfolio';
        $candidate = $base;
        $counter = 2;

        while (Portfolio::where('slug', $candidate)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $candidate = $base . '-' . $counter++;
        }

        return $candidate;
    }

    private function deleteImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    /**
     * Upload gambar dari WYSIWYG Editor (Quill) ke storage/public
     * Mengembalikan URL publik gambar yang di-upload
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
        ]);

        $path = $request->file('image')->store('uploads/portfolio/content', 'public');
        $url  = Storage::url($path); // => /storage/uploads/portfolio/content/filename.jpg

        return response()->json(['url' => asset($url)]);
    }
}
