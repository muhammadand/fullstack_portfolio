<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioCategoryController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use Spatie\Sitemap\SitemapGenerator;
use App\Http\Controllers\DocumentationController;

Route::get('/generate-sitemap', function () {

    SitemapGenerator::create('https://scalifyintellegence.my.id/')
        ->writeToFile(public_path('sitemap.xml'));

    return 'Sitemap generated!';
});


//administrator
    Route::get('/dashboard/admin', [AdminController::class, 'admin'])->name('dashboard.admin');
    Route::get('/admin/view-stats', [AdminController::class, 'viewStats'])->name('admin.view.stats');

    // Portfolio
    Route::resource('portfolio', PortfolioController::class);
    Route::post('portfolio/upload-image', [PortfolioController::class, 'uploadImage'])->name('portfolio.upload-image');
    Route::resource('portfolio-categories', PortfolioCategoryController::class);
    // Dashboard admin
    // Blog categories
    Route::resource('blog-categories', BlogCategoryController::class);
    // Blogs
    Route::resource('blogs', BlogController::class);
    Route::post('blogs/upload-image', [BlogController::class, 'uploadImage'])->name('blogs.upload-image');

    //Public Routes
    Route::get('/',[HomeController::class,'indexCompanyProfile'])->name('index.company.profile');
    //blogs user
    Route::get('landing/blogs', [HomeController::class, 'blogs'])->name('landing.blogs');
    Route::get('landing/blog/{slug}', [HomeController::class, 'readBlog'])->name('blogs.read');
    //portfolio users
    Route::get('landing/portfolio', [HomeController::class, 'portfolio'])->name('landing.portfolio');
    Route::get('landing/portfolio/{slug}', [HomeController::class, 'readPortfolio'])->name('portfolio.read');
    //service users
    Route::get('service',[HomeController::class,'service'])->name('service');
    //about users
    Route::get('about',[HomeController::class,'about'])->name('about');
    //contact users
    Route::get('contact',[HomeController::class,'contact'])->name('contact');
    // REGISTER
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');


    // Sobat Scalify
    Route::get('/sobat-scalify',[HomeController::class,'SobatScalify'])->name('sobat-scalify');
    //Documentation
    Route::resource('documentation',DocumentationController::class);

// LOGIN
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
// LOGOUT
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// portfolio
// Route::get('/portfolio', [HomeController::class, 'portfolio_1'])->name('portfolio');

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

Route::get('/fix-storage', function () {
    // 1. Hapus symlink lama jika error/korup
    if (File::exists(public_path('storage'))) {
        File::deleteDirectory(public_path('storage'));
    }
    
    // 2. Buat symlink baru
    Artisan::call('storage:link');
    
    return 'Symlink storage berhasil dibuat!';
});


