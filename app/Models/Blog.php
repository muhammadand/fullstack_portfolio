<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

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

    // Slug otomatis berdasarkan judul
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($blog) {
            if (empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
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
}
