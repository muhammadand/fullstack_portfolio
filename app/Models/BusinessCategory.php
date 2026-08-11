<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessCategory extends Model
{
    protected $guarded = ['id'];

    public function proposals()
    {
        return $this->hasMany(ClientProposal::class);
    }
}
