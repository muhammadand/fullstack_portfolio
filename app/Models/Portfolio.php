<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $table = 'portfolios';

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'client_name',
        'project_type',
        'short_description',
        'full_description',
        'challenge',
        'solution',
        'result',
        'thumbnail_image',
        'featured_image',
        'technologies',
        'project_url',
        'github_url',
        'completion_date',
        'is_featured',
        'view_count',
        'display_order',
        'is_active',
    ];

    protected $casts = [
        'technologies' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'completion_date' => 'date',
    ];

    // 🔗 Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(PortfolioCategory::class, 'category_id');
    }

    // 🧩 Validasi dinamis
  public static function rules($id = null)
{
    return [
        'category_id' => 'required|exists:portfolio_categories,id',
        'title' => 'required|string|max:200',
        'slug' => 'required|string|max:200|unique:portfolios,slug,' . $id,
        'client_name' => 'nullable|string|max:100',
        'project_type' => 'nullable|string|max:100',
        'short_description' => 'required|string|max:255',
        'full_description' => 'required|string',
        'challenge' => 'nullable|string',
        'solution' => 'nullable|string',
        'result' => 'nullable|string',

        // 🔥 STORE = required, UPDATE = nullable
        'thumbnail_image' => $id
            ? 'nullable|image|mimes:jpg,jpeg,png|max:10240'
            : 'required|image|mimes:jpg,jpeg,png|max:10240',

        'featured_image' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',

        // 🔥 Input kamu string → controller yg ubah ke array
        'technologies' => 'nullable|string',

        'project_url' => 'nullable|url|max:255',
        'github_url' => 'nullable|url|max:255',
        'completion_date' => 'nullable|date',
        'is_featured' => 'boolean',
        'display_order' => 'integer',
        'is_active' => 'boolean',
    ];
}


    // 🧭 Scope untuk aktif saja
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // 🌟 Scope untuk portfolio unggulan
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
   
}
