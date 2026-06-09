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
use App\Http\Controllers\UserController;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\CareersController;
use App\Http\Controllers\CareerApplicationController;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Blog;
use App\Models\Portfolio;
use App\Models\Career;

Route::get('/generate-sitemap', function () {
    $sitemap = Sitemap::create();

    // 1. Halaman Utama
    $sitemap->add(Url::create('/')
        ->setLastModificationDate(now())
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
        ->setPriority(1.0));

    // 2. Halaman Statis / Publik Utama
    $sitemap->add(Url::create('/service')
        ->setLastModificationDate(now())
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
        ->setPriority(0.8));

    $sitemap->add(Url::create('/about')
        ->setLastModificationDate(now())
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
        ->setPriority(0.7));

    $sitemap->add(Url::create('/contact')
        ->setLastModificationDate(now())
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
        ->setPriority(0.7));

    $sitemap->add(Url::create('/sobat-scalify')
        ->setLastModificationDate(now())
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
        ->setPriority(0.8));

    // 3. Halaman Indeks Dinamis
    $sitemap->add(Url::create('/s/blogs')
        ->setLastModificationDate(now())
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
        ->setPriority(0.9));

    $sitemap->add(Url::create('/s/portfolio')
        ->setLastModificationDate(now())
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
        ->setPriority(0.9));

    $sitemap->add(Url::create('/s/careers')
        ->setLastModificationDate(now())
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
        ->setPriority(0.8));

    // 4. Artikel Blog Dinamis
    $blogs = Blog::published()->get();
    foreach ($blogs as $blog) {
        $sitemap->add(Url::create("/s/blog/{$blog->slug}")
            ->setLastModificationDate($blog->updated_at ?? now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(0.8));
    }

    // 5. Item Portofolio Dinamis
    $portfolios = Portfolio::active()->get();
    foreach ($portfolios as $portfolio) {
        $sitemap->add(Url::create("/s/portfolio/{$portfolio->slug}")
            ->setLastModificationDate($portfolio->updated_at ?? now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(0.8));
    }

    // 6. Lowongan Karir Dinamis
    $careers = Career::where('is_active', 1)->get();
    foreach ($careers as $career) {
        $sitemap->add(Url::create("/s/careers/{$career->slug}")
            ->setLastModificationDate($career->updated_at ?? now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(0.7));
    }

    $sitemap->writeToFile(public_path('sitemap.xml'));

    return 'Sitemap dinamis berhasil dibuat!';
});


//administrator
    Route::get('/dashboard/admin', [AdminController::class, 'admin'])->name('dashboard.admin');
    Route::get('/admin/view-stats', [AdminController::class, 'viewStats'])->name('admin.view.stats');

    // Notifications
    Route::post('/notifications/{id}/mark-as-read', [App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::delete('/notifications/{id}', [App\Http\Controllers\Admin\NotificationController::class, 'destroy'])->name('notifications.destroy');

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

    // Careers
    Route::resource('careers', CareersController::class);
    Route::post('careers/upload-image', [CareersController::class, 'uploadImage'])->name('careers.upload-image');

    // Careers Application
    Route::resource('career-applications', CareerApplicationController::class);

    // Users
    Route::resource('users', UserController::class);

    // Profile
    Route::get('profile', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::put('profile', [UserController::class, 'updateProfile'])->name('profile.update');

    //Public Routes
    Route::get('/',[HomeController::class,'indexCompanyProfile'])->name('index.company.profile');

    // Redirect 301 dari route lama (landing/*) ke route baru (s/*) untuk menjaga SEO
    Route::redirect('landing/blogs', '/s/blogs', 301);
    Route::redirect('landing/blog/{slug}', '/s/blog/{slug}', 301);
    Route::redirect('landing/portfolio', '/s/portfolio', 301);
    Route::redirect('landing/portfolio/{slug}', '/s/portfolio/{slug}', 301);
    Route::redirect('landing/careers', '/s/careers', 301);
    Route::redirect('landing/careers/{slug}', '/s/careers/{slug}', 301);

    //blogs user
    Route::get('s/blogs', [HomeController::class, 'blogs'])->name('landing.blogs');
    Route::get('s/blog/{slug}', [HomeController::class, 'readBlog'])->name('blogs.read');
    //portfolio users
    Route::get('s/portfolio', [HomeController::class, 'portfolio'])->name('landing.portfolio');
    Route::get('s/portfolio/{slug}', [HomeController::class, 'readPortfolio'])->name('portfolio.read');
    
    //careers users
    Route::get('s/careers', [App\Http\Controllers\CareersController::class, 'listCareers'])->name('landing.careers');
    Route::get('s/careers/{slug}', [App\Http\Controllers\CareersController::class, 'getByslug'])->name('careers.read');

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


