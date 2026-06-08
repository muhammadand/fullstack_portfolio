<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit
    protected $table = 'careers';

    // Kolom yang diizinkan untuk mass assignment
    protected $fillable = [
        'title',
        'slug',
        'description',
        'qualifications',
        'employment_type',
        'work_mode',
        'location',
        'salary_min',
        'salary_max',
        'closing_date',
        'is_active',
    ];

    // Mengonversi tipe data kolom secara otomatis (Casting)
    protected $casts = [
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2',
        'closing_date' => 'date',
        'is_active' => 'boolean',
    ];
}