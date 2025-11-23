<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PortfolioCategoryRepository;
use App\Helpers\AuthHelper;
class PortfolioCategoryController extends BaseController
{
    
    public function __construct(PortfolioCategoryRepository $repository)
    {
        if ($resp = AuthHelper::mustLogin()) {
            // penting: return response dari constructor
            abort(redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.'));
        }
        $this->repository = $repository;
        $this->viewPath = 'portfolio_categories';
        $this->routeName = 'portfolio-categories';
    }
}
