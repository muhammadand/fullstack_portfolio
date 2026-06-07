<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyView extends Model
{
    use HasFactory;

    protected $fillable = [
        'viewable_type',
        'viewable_id',
        'date',
        'views_count',
    ];

    public function viewable()
    {
        return $this->morphTo();
    }
}
