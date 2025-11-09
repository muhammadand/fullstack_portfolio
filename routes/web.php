<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioCategoryController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\AdminController;
Route::resource('portfolio-categories', PortfolioCategoryController::class);
Route::resource('portfolio', PortfolioController::class);
Route::get('/dashboard/admin', [AdminController::class, 'admin'])->name('dashboard.admin');

Route::get('/', function () {
    return view('welcome');
});
