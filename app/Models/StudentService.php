<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentService extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'min_price',
        'max_price',
        'description',
        'is_active',
    ];
}
