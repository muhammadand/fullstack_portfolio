<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerApplication extends Model
{
    use HasFactory;

    protected $table = 'career_applications';

    protected $fillable = [
        'career_id',
        'full_name',
        'email',
        'phone',
        'resume',
        'portfolio_url',
        'linkedin_url',
        'cover_letter',
        'applied_at',
    ];

    protected $casts = [
        'applied_at' => 'datetime',
    ];

    /**
     * Get the career that owns the application.
     */
    public function career()
    {
        return $this->belongsTo(Career::class);
    }
}
