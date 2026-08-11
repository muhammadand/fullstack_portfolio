<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ClientProposal;

class ClientProposalController extends Controller
{
    public function landing($slug)
    {
        $client = ClientProposal::with('category')->where('slug', $slug)->firstOrFail();
        
        $categorySlug = $client->category ? $client->category->slug : 'wedding';
        
        if (!view()->exists("client-proposals.{$categorySlug}.landing")) {
            abort(404, "Tema landing page untuk kategori {$categorySlug} belum tersedia.");
        }
        
        return view("client-proposals.{$categorySlug}.landing", compact('client'));
    }

    public function proposal($slug)
    {
        $client = ClientProposal::with('category')->where('slug', $slug)->firstOrFail();
        
        $categorySlug = $client->category ? $client->category->slug : 'wedding';
        
        if (!view()->exists("client-proposals.{$categorySlug}.proposal")) {
            abort(404, "Tema proposal untuk kategori {$categorySlug} belum tersedia.");
        }
        
        return view("client-proposals.{$categorySlug}.proposal", compact('client'));
    }
}
