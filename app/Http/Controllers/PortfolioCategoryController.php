<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PortfolioCategoryRepository;

class PortfolioCategoryController extends BaseController
{
    public function __construct(PortfolioCategoryRepository $repository)
    {
        $this->repository = $repository;
        $this->viewPath = 'portfolio_categories';
        $this->routeName = 'portfolio-categories';
    }
}
