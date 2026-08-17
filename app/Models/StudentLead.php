<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentLead extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class);
    }

    public function clientProposal()
    {
        return $this->belongsTo(ClientProposal::class);
    }
}
