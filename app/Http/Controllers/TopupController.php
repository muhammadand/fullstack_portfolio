<?php

namespace App\Http\Controllers;

use App\Services\TopupCatalogService;

class TopupController extends Controller
{
    public function index()
    {
        return view('topup.index', ['catalog' => TopupCatalogService::games()]);
    }
}
