<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Portfolio;
use Illuminate\Http\Request;


class HomeController extends Controller
{

    public function landing()
    {
        $latestBlogs = Blog::published()
            ->latest('published_at')
            ->take(3)
            ->get();
        $latestPortfolios = Portfolio::active()
        ->orderBy('completion_date', 'desc')
        ->take(3)
        ->get();

        return view('pages.landing.index', compact('latestBlogs','latestPortfolios'));
    }


    public function blogs()
    {
        $featured = Blog::published()
            ->featured()
            ->latest('published_at')
            ->take(3)
            ->get();

        // 4 blog paling populer
        $popular = Blog::published()
            ->orderByDesc('view_count')
            ->take(4)
            ->get();

        $blogs = Blog::published()
            ->latest('published_at')
            ->paginate(10);

        $categories = BlogCategory::where('is_active', 1)
            ->orderBy('display_order')
            ->get();

        return view('pages.blogs.index', compact('blogs', 'featured', 'popular', 'categories'));
    }




    public function readBlog($slug)
    {
        $blog = Blog::published()
            ->where('slug', $slug)
            ->with(['author', 'category'])
            ->firstOrFail();

        // Tambah view count
        $blog->increment('view_count');

        // Ambil artikel lain untuk rekomendasi
        $related = Blog::published()
            ->where('category_id', $blog->category_id)
            ->where('id', '!=', $blog->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('pages.blogs.read', compact('blog', 'related'));
    }

    public function portfolio()
{
    // Gunakan paginate agar ada ->total()
    $portfolios = Portfolio::active()
        ->orderBy('display_order', 'asc')
        ->paginate(12); // bebas mau 6, 9, 12, dll

    // Ambil portfolio populer
    $popularPortfolios = Portfolio::active()
        ->orderBy('view_count', 'desc')
        ->take(5)
        ->get();

    return view('pages.portfolio.index', compact('portfolios', 'popularPortfolios'));
}


    public function readPortfolio($slug)
    {
        $portfolio = Portfolio::where('slug', $slug)->active()->firstOrFail();

        // Increment view count
        $portfolio->increment('view_count');

        // Pastikan technologies selalu array
        if (!is_array($portfolio->technologies)) {
            $portfolio->technologies = $portfolio->technologies
                ? json_decode($portfolio->technologies, true)
                : [];
        }

        // Ambil portfolio populer
        $popularPortfolios = Portfolio::active()->orderBy('view_count', 'desc')->take(5)->get();

        return view('pages.portfolio.read', compact('portfolio', 'popularPortfolios'));
    }


    public function service(){
        return view('pages.service.index'); 
    }
    public function about(){
        return view('pages.about.index'); 
    }
    public function contact(){
        return view('pages.contact');
    }
}
