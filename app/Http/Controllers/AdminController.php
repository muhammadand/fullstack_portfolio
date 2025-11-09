<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function admin(){
        return view('dashboard.admin');
    }
}
