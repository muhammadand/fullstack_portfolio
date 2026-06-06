<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documentation extends Model
{
    protected $table = 'documentations';

    protected $fillable = [
        'title',
        'slug',
        'images',
    ];
}
