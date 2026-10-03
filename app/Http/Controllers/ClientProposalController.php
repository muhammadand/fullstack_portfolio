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

    public function landingCafe($slug)
    {
        $client = ClientProposal::where('slug', $slug)->firstOrFail();
        return view('client-proposals.cafe.landing', compact('client'));
    }

    public function proposalCafe($slug)
    {
        $client = ClientProposal::where('slug', $slug)->firstOrFail();
        return view('client-proposals.cafe.proposal', compact('client'));
    }

    public function customerDemoCafe($slug)
    {
        $client = ClientProposal::where('slug', $slug)->firstOrFail();
        return view('client-proposals.cafe.customer-demo', compact('client'));
    }

    public function adminDemoRental($slug)
    {
        $client = ClientProposal::where('slug', $slug)->firstOrFail();
        return view('client-proposals.rental-mobil.admin-demo', compact('client'));
    }

    public function adminDemoParfum($slug)
    {
        $client = ClientProposal::where('slug', $slug)->firstOrFail();
        return view('client-proposals.parfum.admin-demo', compact('client'));
    }

    public function landingTravel($slug)
    {
        $client = ClientProposal::where('slug', $slug)->firstOrFail();
        return view('client-proposals.travel.landing', compact('client'));
    }

    public function proposalTravel($slug)
    {
        $client = ClientProposal::where('slug', $slug)->firstOrFail();
        return view('client-proposals.travel.proposal', compact('client'));
    }

    public function customerDemoTravel($slug)
    {
        $client = ClientProposal::where('slug', $slug)->firstOrFail();
        return view('client-proposals.travel.customer-demo', compact('client'));
    }

    public function landingLpk($slug)
    {
        $client = ClientProposal::where('slug', $slug)->firstOrFail();
        return view('client-proposals.lpk.landing', compact('client'));
    }

    public function proposalLpk($slug)
    {
        $client = ClientProposal::where('slug', $slug)->firstOrFail();
        return view('client-proposals.lpk.proposal', compact('client'));
    }

    public function landingSport($slug)
    {
        $client = ClientProposal::where('slug', $slug)->firstOrFail();
        return view('client-proposals.sport.landing', compact('client'));
    }

    public function proposalSport($slug)
    {
        $client = ClientProposal::where('slug', $slug)->firstOrFail();
        return view('client-proposals.sport.proposal', compact('client'));
    }

    public function customerDemoSport($slug)
    {
        $client = ClientProposal::where('slug', $slug)->firstOrFail();
        return view('client-proposals.sport.customer-demo', compact('client'));
    }

    public function landingKlinik($slug)
    {
        $client = ClientProposal::where('slug', $slug)->firstOrFail();
        return view('client-proposals.klinik.landing', compact('client'));
    }

    public function proposalKlinik($slug)
    {
        $client = ClientProposal::where('slug', $slug)->firstOrFail();
        return view('client-proposals.klinik.proposal', compact('client'));
    }

    public function customerDemoKlinik($slug)
    {
        $client = ClientProposal::where('slug', $slug)->firstOrFail();
        return view('client-proposals.klinik.landing', compact('client'));
    }

    public function standaloneKlinik()
    {
        $client = ClientProposal::where('slug', 'medika-sehat-utama')->first();
        if (!$client) {
            $client = (object)[
                'brand_name' => 'Klinik Pratama Medika Sehat',
                'client_name' => 'dr. Hendra Kusuma, Sp.PD',
                'wa_number' => '6281234567890',
                'slug' => 'medika-sehat-utama'
            ];
        }
        return view('client-proposals.klinik.landing', compact('client'));
    }
}

