<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ClientProposal;

class ClientProposalController extends Controller
{
    public function landing($slug)
    {
        $client = ClientProposal::where('slug', $slug)->firstOrFail();
        return view('client-proposals.landing', compact('client'));
    }

    public function proposal($slug)
    {
        $client = ClientProposal::where('slug', $slug)->firstOrFail();
        return view('client-proposals.proposal', compact('client'));
    }
}
