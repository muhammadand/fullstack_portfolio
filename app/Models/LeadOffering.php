<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadOffering extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'contacted_at' => 'datetime',
    ];

    public function proposal()
    {
        return $this->belongsTo(ClientProposal::class, 'client_proposal_id');
    }

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class);
    }
}
