<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogCategory extends Model
{
    use HasFactory;

    protected $table = 'blog_categories';
    protected $primaryKey = 'id';
    public $timestamps = false; // karena hanya ada created_at tanpa updated_at

    protected $fillable = [
        'name',
        'slug',
        'description',
        'meta_description',
        'display_order',
        'is_active',
        'created_at',
    ];

    // Scope untuk kategori aktif saja
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Relasi ke tabel blog (jika nanti ada tabel blogs)
    public function blogs()
    {
        return $this->hasMany(Blog::class, 'category_id');
    }
}
