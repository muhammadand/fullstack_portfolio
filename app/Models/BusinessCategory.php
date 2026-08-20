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

    public function chatTemplates()
    {
        return $this->hasMany(ChatTemplate::class);
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'business_category_id');
    }
}
