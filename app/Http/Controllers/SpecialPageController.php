<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpecialPageController extends Controller
{
    /**
     * Tampilkan landing page untuk Permata Qiana Wedding
     */
    public function permataQianaWeddingLanding()
    {
        return view('special-pages.permata-qiana-wedding.landing');
    }

    /**
     * Tampilkan proposal untuk Permata Qiana Wedding
     */
    public function permataQianaWeddingProposal()
    {
        return view('special-pages.permata-qiana-wedding.proposal');
    }
}
