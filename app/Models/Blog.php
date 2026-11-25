<?php

namespace App\Models;

use App\Models\Concerns\RegeneratesSitemap;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory, RegeneratesSitemap;

    protected $table = 'blogs';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'category_id',
        'author_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'tags',
        'meta_title',
        'meta_description',
        'reading_time',
        'view_count',
        'is_featured',
        'is_published',
        'published_at',
        'link_clicks',
    ];

    protected $casts = [
        'tags' => 'array', // otomatis ubah kolom JSON ke array
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // Relasi ke kategori blog
    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    // Relasi ke penulis (user)
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // Relasi ke affiliate
    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class, 'affiliate_id');
    }

    // Relasi ke business category
    public function businessCategory()
    {
        return $this->belongsTo(BusinessCategory::class, 'business_category_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    // Ambil hanya blog yang sudah dipublikasikan
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at');
    }

    // Ambil blog yang ditampilkan di highlight/featured
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS & MUTATORS
    |--------------------------------------------------------------------------
    */

    // Slug otomatis berdasarkan judul dan event reward poin
    protected static function boot()
    {
        parent::boot();

        // Indeks halaman tag (/s/blogs/tag/...) dihitung ulang saat artikel berubah.
        static::saved(fn () => \App\Support\BlogTags::flush());
        static::deleted(fn () => \App\Support\BlogTags::flush());

        static::creating(function ($blog) {
            if (empty($blog->slug)) {
                $blog->slug = static::uniqueSlug($blog->title);
            }
        });

        static::updated(function ($blog) {
            // Jika status berubah jadi published, ditulis oleh affiliate, dan belum di-reward
            if ($blog->isDirty('is_published') && $blog->is_published && $blog->affiliate_id && !$blog->is_rewarded) {

                $affiliate = $blog->affiliate;
                if ($affiliate) {
                    // Beri 10 Poin
                    $affiliate->increment('points', 10);

                    // Catat di Point History
                    try {
                        \App\Models\AffiliatePointHistory::create([
                            'affiliate_id' => $affiliate->id,
                            'points_earned' => 10,
                            'description' => 'Bonus Submit Artikel (Approved): ' . $blog->title
                        ]);
                    } catch (\Throwable $th) {
                        // ignore error
                    }

                    // Kirim notifikasi
                    try {
                        $affiliate->notify(new \App\Notifications\AffiliateNotification(
                            'Artikel Diterima!',
                            'Artikel kamu "' . Str::limit($blog->title, 20) . '" telah diterbitkan. Kamu mendapat Bonus +10 Poin!',
                            'success'
                        ));
                    } catch (\Throwable $th) {
                        // ignore error
                    }
                }

                // Tandai bahwa blog ini sudah diberi reward poin
                $blog->is_rewarded = true;
                $blog->saveQuietly(); // saveQuietly agar tidak men-trigger event 'updated' lagi
            }
        });
    }

    // Format excerpt jika belum diset
    public function getExcerptAttribute($value)
    {
        if (!empty($value)) {
            return $value;
        }

        return Str::limit(strip_tags($this->content), 150);
    }

    /** Daftar tag yang sudah dirapikan (tanpa '#', tanpa duplikat), untuk tampilan & SEO. */
    public function getTagListAttribute(): array
    {
        return \App\Support\BlogTags::normalize($this->tags);
    }

    /**
     * Slug unik dari judul: "judul", lalu "judul-2", "judul-3", ...
     * Slug hanya dibuat sekali saat artikel dibuat. Setelah itu tidak diubah lagi walau judul diedit,
     * karena URL yang sudah diindex Google / dibagikan akan 404 bila slug berganti.
     */
    public static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::limit(Str::slug($title) ?: 'artikel', 180, '');
        $slug = $base;
        $i = 2;

        while (static::where('slug', $slug)->when($ignoreId, fn ($q) => $q->whereKeyNot($ignoreId))->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    /** Data terstruktur schema.org BlogPosting untuk rich result Google (dipakai di halaman baca). */
    public function jsonLd(): array
    {
        $url = route('blogs.read', $this->slug);
        $description = $this->meta_description ?: $this->excerpt;

        return array_filter([
            '@context'         => 'https://schema.org',
            '@type'            => 'BlogPosting',
            'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => $url],
            'url'              => $url,
            'headline'         => Str::limit($this->title, 110, ''),
            'description'      => $description ? Str::limit(trim(strip_tags($description)), 300) : null,
            'image'            => [$this->featured_image ? asset('storage/' . $this->featured_image) : asset('og-image.png')],
            'author'           => ['@type' => 'Person', 'name' => $this->author->name ?? 'Scalify Intelligence'],
            'publisher'        => [
                '@type' => 'Organization',
                'name'  => 'Scalify Intelligence',
                'logo'  => ['@type' => 'ImageObject', 'url' => asset('scalify.png')],
            ],
            'articleSection'   => $this->category->name ?? null,
            'keywords'         => $this->tag_list ? implode(', ', $this->tag_list) : null,
            'wordCount'        => str_word_count(strip_tags((string) $this->content)) ?: null,
            'datePublished'    => ($this->published_at ?? $this->created_at)?->toIso8601String(),
            'dateModified'     => ($this->updated_at ?? $this->published_at)?->toIso8601String(),
        ], fn ($v) => $v !== null);
    }
}
