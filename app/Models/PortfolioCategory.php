<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioCategory extends Model
{
    protected $table = 'portfolio_categories';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'display_order',
        'is_active',
    ];

    public $timestamps = false; // karena kita cuma pakai created_at

    // optional: rules() kalau kamu mau validasi otomatis
    public static function rules($id = null)
    {
        return [
            'name' => 'required|string|max:100',
            'slug' => 'required|string|max:100|unique:portfolio_categories,slug,' . $id,
            'description' => 'nullable|string',
            'display_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }
     public function portfolios()
    {
        return $this->hasMany(Portfolio::class, 'category_id');
    }
   
}
