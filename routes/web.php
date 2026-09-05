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
use App\Http\Controllers\SpecialPageController;
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
Route::patch('blogs/{blog}/publish', [BlogController::class, 'publish'])->name('blogs.publish');
Route::post('blogs/generate-ai', [BlogController::class, 'generateAi'])->name('blogs.generate_ai');
Route::resource('blogs', BlogController::class);
Route::post('blogs/upload-image', [BlogController::class, 'uploadImage'])->name('blogs.upload-image');

// Careers
Route::resource('careers', CareersController::class);
Route::post('careers/upload-image', [CareersController::class, 'uploadImage'])->name('careers.upload-image');

// Careers Application
Route::resource('career-applications', CareerApplicationController::class);

// Users
Route::resource('users', UserController::class);

// Affiliate Partners Management
Route::get('admin/affiliates', [App\Http\Controllers\Admin\AffiliateController::class, 'index'])->name('admin.affiliates.index');
Route::post('admin/affiliates', [App\Http\Controllers\Admin\AffiliateController::class, 'store'])->name('admin.affiliates.store');
Route::get('admin/affiliates/{affiliate}', [App\Http\Controllers\Admin\AffiliateController::class, 'show'])->name('admin.affiliates.show');
Route::post('admin/affiliates/{affiliate}/approve', [App\Http\Controllers\Admin\AffiliateController::class, 'approve'])->name('admin.affiliates.approve');
Route::post('admin/affiliates/{affiliate}/reject', [App\Http\Controllers\Admin\AffiliateController::class, 'reject'])->name('admin.affiliates.reject');
Route::post('admin/affiliates/{affiliate}/commission', [App\Http\Controllers\Admin\AffiliateController::class, 'addCommission'])->name('admin.affiliates.commission');
Route::post('admin/affiliates/{affiliate}/lynk-settings', [App\Http\Controllers\Admin\AffiliateController::class, 'updateLynkSettings'])->name('admin.affiliates.lynk_settings');

// Withdrawals Management
Route::get('admin/withdrawals', [App\Http\Controllers\Admin\WithdrawalController::class, 'index'])->name('admin.withdrawals.index');
Route::post('admin/withdrawals/{withdrawal}/approve', [App\Http\Controllers\Admin\WithdrawalController::class, 'approve'])->name('admin.withdrawals.approve');

// Manajemen Client Proposals
Route::resource('admin/business-categories', App\Http\Controllers\Admin\BusinessCategoryController::class)->names([
    'index' => 'admin.business_categories.index',
    'create' => 'admin.business_categories.create',
    'store' => 'admin.business_categories.store',
    'edit' => 'admin.business_categories.edit',
    'update' => 'admin.business_categories.update',
    'destroy' => 'admin.business_categories.destroy',
]);

// Manajemen Produk Digital (Lynk.id)
Route::resource('admin/digital-products', App\Http\Controllers\Admin\DigitalProductController::class)->names([
    'index' => 'admin.digital_products.index',
    'create' => 'admin.digital_products.create',
    'store' => 'admin.digital_products.store',
    'edit' => 'admin.digital_products.edit',
    'update' => 'admin.digital_products.update',
    'destroy' => 'admin.digital_products.destroy',
]);

Route::resource('admin/client-proposals', App\Http\Controllers\Admin\ClientProposalController::class)->names([
    'index' => 'admin.client_proposals.index',
    'create' => 'admin.client_proposals.create',
    'store' => 'admin.client_proposals.store',
    'edit' => 'admin.client_proposals.edit',
    'update' => 'admin.client_proposals.update',
    'destroy' => 'admin.client_proposals.destroy',
]);
Route::post('admin/client-proposals/bulk-update-price', [App\Http\Controllers\Admin\ClientProposalController::class, 'bulkUpdatePrice'])->name('admin.client_proposals.bulk_update_price');
Route::post('admin/client-proposals/{client_proposal}/wa-template', [App\Http\Controllers\Admin\ClientProposalController::class, 'updateWaTemplate'])->name('admin.client_proposals.update_wa');

Route::resource('admin/chat-templates', App\Http\Controllers\Admin\ChatTemplateController::class)->except(['create', 'show', 'edit'])->names([
    'index' => 'admin.chat_templates.index',
    'store' => 'admin.chat_templates.store',
    'update' => 'admin.chat_templates.update',
    'destroy' => 'admin.chat_templates.destroy',
]);

// Profile
Route::get('profile', [UserController::class, 'editProfile'])->name('profile.edit');
Route::put('profile', [UserController::class, 'updateProfile'])->name('profile.update');

//Public Routes
Route::get('/', [HomeController::class, 'indexCompanyProfile'])->name('index.company.profile');

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
Route::get('service', [HomeController::class, 'service'])->name('service');
//about users
Route::get('about', [HomeController::class, 'about'])->name('about');
//contact users
Route::get('contact', [HomeController::class, 'contact'])->name('contact');
// REGISTER
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');


// Sobat Scalify
Route::get('/sobat-scalify', [HomeController::class, 'SobatScalify'])->name('sobat-scalify');
Route::get('/layanan/scm', [HomeController::class, 'scmService'])->name('layanan.scm');
Route::get('/partner-program', [HomeController::class, 'partnerProgram'])->name('partner.program');
//Documentation
Route::resource('documentation', DocumentationController::class);

// Sobat Scalify Affiliate (Public/Guest)
Route::get('/partner/register', [App\Http\Controllers\AffiliateController::class, 'registerForm'])->name('affiliate.register');
Route::post('/partner/register', [App\Http\Controllers\AffiliateController::class, 'registerSubmit'])->name('affiliate.register.submit');
Route::get('/partner/login', [App\Http\Controllers\AffiliateController::class, 'loginForm'])->name('affiliate.login');
Route::get('/partner/magic-login/{affiliate}', [App\Http\Controllers\AffiliateController::class, 'magicLogin'])->name('affiliate.magic_login');
Route::get('/partner/magic-login-qr', [App\Http\Controllers\AffiliateController::class, 'magicLoginQr'])->name('affiliate.magic_login_qr');
Route::get('/magic-login/admin/{user}', [App\Http\Controllers\UserController::class, 'magicLogin'])->name('users.magic_login')->middleware('signed');
Route::post('/partner/login', [App\Http\Controllers\AffiliateController::class, 'loginSubmit'])->name('affiliate.login.submit');
Route::post('/api/track-wa-click', [App\Http\Controllers\AffiliateController::class, 'trackClick']);
Route::post('/api/blogs/{blog}/track-click', [App\Http\Controllers\HomeController::class, 'trackBlogClick']);

// Sobat Scalify Affiliate (Auth protected)
Route::middleware(['auth:affiliate'])->group(function () {
    Route::get('/partner/dashboard', [App\Http\Controllers\AffiliateController::class, 'dashboard'])->name('affiliate.dashboard');
    Route::get('/partner/history', [App\Http\Controllers\AffiliateController::class, 'history'])->name('affiliate.history');
    Route::get('/partner/ideas/{slug}', [\App\Http\Controllers\Affiliate\TargetIdeaController::class, 'show'])->name('affiliate.ideas.show');
    Route::get('/partner/proposals', [App\Http\Controllers\AffiliateController::class, 'proposals'])->name('affiliate.proposals');
    Route::post('/partner/proposals', [App\Http\Controllers\AffiliateController::class, 'generateProposal'])->name('affiliate.proposals.generate');
    Route::post('/partner/proposals/{id}/claim', [App\Http\Controllers\AffiliateController::class, 'claimProposal'])->name('affiliate.proposals.claim');
    Route::post('/partner/proposals/{id}/generate-ai-chat', [App\Http\Controllers\AffiliateController::class, 'generateAiChat'])->name('affiliate.proposals.generate_ai_chat');
    Route::post('/partner/logout', [App\Http\Controllers\AffiliateController::class, 'logout'])->name('affiliate.logout');
    Route::post('/partner/withdraw', [App\Http\Controllers\AffiliateController::class, 'withdraw'])->name('affiliate.withdraw');

    // Push Subscriptions
    Route::post('/partner/push/subscribe', [\App\Http\Controllers\PushSubscriptionController::class, 'update'])->name('affiliate.push.subscribe');

    // Notifications
    Route::post('/partner/notifications/{id}/read', [App\Http\Controllers\AffiliateController::class, 'markNotificationRead'])->name('affiliate.notifications.read');
    Route::post('/partner/notifications/clear', [App\Http\Controllers\AffiliateController::class, 'clearNotifications'])->name('affiliate.notifications.clear');

    // Gamification / Points
    Route::post('/partner/claim-points', [App\Http\Controllers\AffiliateController::class, 'claimDailyPoints'])->name('affiliate.claim_points');
    Route::get('/partner/streak', [App\Http\Controllers\AffiliateController::class, 'streak'])->name('affiliate.streak');
    Route::get('/partner/store', [App\Http\Controllers\AffiliateController::class, 'store'])->name('affiliate.store');

    // Guide & Growth Hub
    Route::get('/partner/guide', [App\Http\Controllers\AffiliateController::class, 'guide'])->name('affiliate.guide');
    Route::post('/partner/ai-social-post', [App\Http\Controllers\AffiliateController::class, 'generateSocialPost'])->name('affiliate.ai_social_post');
    Route::post('/partner/ai-handle-objection', [App\Http\Controllers\AffiliateController::class, 'handleObjection'])->name('affiliate.ai_handle_objection');

    // Student Services
    Route::get('/partner/student-services', [App\Http\Controllers\Affiliate\StudentServiceController::class, 'index'])->name('affiliate.student_services.index');
    Route::post('/partner/student-services/generate', [App\Http\Controllers\Affiliate\StudentServiceController::class, 'generateProposal'])->name('affiliate.student_services.generate');

    // Student Leads
    Route::get('/partner/student-leads', [App\Http\Controllers\Affiliate\StudentLeadController::class, 'index'])->name('affiliate.student_leads.index');
    Route::post('/partner/student-leads', [App\Http\Controllers\Affiliate\StudentLeadController::class, 'store'])->name('affiliate.student_leads.store');
    Route::put('/partner/student-leads/{id}', [App\Http\Controllers\Affiliate\StudentLeadController::class, 'update'])->name('affiliate.student_leads.update');
    Route::post('/partner/student-leads/{id}/claim', [App\Http\Controllers\Affiliate\StudentLeadController::class, 'claim'])->name('affiliate.student_leads.claim');
    Route::post('/partner/student-leads/{id}/generate-ai-chat', [App\Http\Controllers\Affiliate\StudentLeadController::class, 'generateAiChat'])->name('affiliate.student_leads.generate_ai_chat');

    // Affiliate Blogs
    Route::get('/partner/blogs', [App\Http\Controllers\Affiliate\BlogController::class, 'index'])->name('affiliate.blogs.index');
    Route::get('/partner/blogs/performance', [App\Http\Controllers\Affiliate\BlogController::class, 'performance'])->name('affiliate.blogs.performance');
    Route::get('/partner/blogs/create', [App\Http\Controllers\Affiliate\BlogController::class, 'create'])->name('affiliate.blogs.create');
    Route::post('/partner/blogs/generate-ai', [App\Http\Controllers\Affiliate\BlogController::class, 'generateAi'])->name('affiliate.blogs.generate_ai');
    Route::post('/partner/blogs', [App\Http\Controllers\Affiliate\BlogController::class, 'store'])->name('affiliate.blogs.store');

    // Digital Products (Lynk.id)
    Route::get('/partner/digital-products', [\App\Http\Controllers\Affiliate\DigitalProductController::class, 'index'])->name('affiliate.digital_products.index');

    // Profile
    Route::get('/partner/profile', [App\Http\Controllers\AffiliateController::class, 'profile'])->name('affiliate.profile');
    Route::post('/partner/profile', [App\Http\Controllers\AffiliateController::class, 'updateProfile'])->name('affiliate.profile.update');

    // Chat Templates
    Route::get('/partner/chat-templates', [App\Http\Controllers\AffiliateChatTemplateController::class, 'index'])->name('affiliate.chat_templates.index');
    Route::post('/partner/chat-templates', [App\Http\Controllers\AffiliateChatTemplateController::class, 'store'])->name('affiliate.chat_templates.store');
    Route::put('/partner/chat-templates/{chat_template}', [App\Http\Controllers\AffiliateChatTemplateController::class, 'update'])->name('affiliate.chat_templates.update');
    Route::delete('/partner/chat-templates/{chat_template}', [App\Http\Controllers\AffiliateChatTemplateController::class, 'destroy'])->name('affiliate.chat_templates.destroy');
});

// LOGIN
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
// LOGOUT
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// portfolio
// Route::get('/portfolio', [HomeController::class, 'portfolio_1'])->name('portfolio');

// Special Landing Pages & Proposals
use App\Http\Controllers\ClientProposalController;

Route::get('/landing/{slug}', [ClientProposalController::class, 'landing'])->name('landing.dynamic');
Route::get('/proposal/{slug}', [ClientProposalController::class, 'proposal'])->name('proposal.dynamic');
Route::get('/client/cafe/{slug}/landing', [ClientProposalController::class, 'landingCafe'])->name('landing.cafe');
Route::get('/client/cafe/{slug}/proposal', [ClientProposalController::class, 'proposalCafe'])->name('proposal.cafe');
Route::get('/client/rental-mobil/{slug}/admin-demo', [ClientProposalController::class, 'adminDemoRental'])->name('demo.admin.rental');
Route::get('/client/parfum/{slug}/admin-demo', [ClientProposalController::class, 'adminDemoParfum'])->name('demo.admin.parfum');

// Endpoint rahasia untuk trigger deploy (migrasi & cache) dari GitHub Actions (Tanpa SSH)
Route::get('/secret-deploy-trigger-12345', function () {
    try {
        // Jalankan migrasi spesifik secara berurutan
        \Illuminate\Support\Facades\Artisan::call('migrate', [
            '--path' => 'database/migrations/2026_09_05_051625_add_lynk_id_link_to_affiliates_table.php',
            '--force' => true
        ]);

        \Illuminate\Support\Facades\Artisan::call('migrate', [
            '--path' => 'database/migrations/2026_09_05_052128_create_digital_products_table.php',
            '--force' => true
        ]);

        \Illuminate\Support\Facades\Artisan::call('migrate', [
            '--path' => 'database/migrations/2026_09_05_062934_adjust_commission_rate_to_affiliates_and_digital_products.php',
            '--force' => true
        ]);

        // Jalankan Seeder yang diperlukan
        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'ClientProposalSeeder', '--force' => true]);
        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'BusinessCategorySeeder', '--force' => true]);
        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'StudentServiceSeeder', '--force' => true]);
        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'DigitalProductSeeder', '--force' => true]);

        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
        return "Deploy commands executed successfully!";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});

// Endpoint rahasia untuk trigger Pengingat Notifikasi Harian via GitHub Actions
Route::get('/secret-trigger-reminders-999', function (\Illuminate\Http\Request $request) {
    @set_time_limit(300);
    @ini_set('max_execution_time', '300');

    try {
        $params = [];
        if ($request->has('force') || $request->query('force') == '1' || $request->query('force') == 'true') {
            $params['--force'] = true;
        }

        \Illuminate\Support\Facades\Artisan::call('affiliate:remind-checkin', $params);
        $output = \Illuminate\Support\Facades\Artisan::output();

        return response()->json([
            'status' => 'success',
            'message' => 'Notifikasi pengingat berhasil diproses!',
            'output' => trim($output)
        ]);
    } catch (\Throwable $e) {
        \Illuminate\Support\Facades\Log::error('Error trigger reminders: ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});

// Route webhook scraper sudah dipindahkan ke routes/api.php

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
