<?php

namespace App\Http\Controllers;

use App\Services\TopupCatalogService;

class TopupController extends Controller
{
    public function index()
    {
        return view('topup.index', ['catalog' => TopupCatalogService::games()]);
    }

    public function show(string $slug)
    {
        $game = TopupCatalogService::game($slug);

        abort_if($game === null, 404);

        return view('topup.show', $game);
    }
}
