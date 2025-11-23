<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AuthHelper;
use Illuminate\Support\Facades\DB;



class AdminController extends Controller
{


    public function admin()
    {
        // Cek apakah user sudah login
        if ($resp = AuthHelper::mustLogin()) {
            return $resp;
        }

        // === ⬇️ Ambil Data Dashboard ===

        // Total views
        $totalBlogViews = \App\Models\Blog::sum('view_count');
        $totalPortfolioViews = \App\Models\Portfolio::sum('view_count');

        // Count item
        $totalBlogs = \App\Models\Blog::count();
        $totalPortfolios = \App\Models\Portfolio::count();

        // Top 5
        $topBlogs = \App\Models\Blog::orderBy('view_count', 'desc')
            ->take(5)
            ->get(['id', 'title', 'view_count']);

        $topPortfolios = \App\Models\Portfolio::orderBy('view_count', 'desc')
            ->take(5)
            ->get(['id', 'title', 'view_count']);
        $totalViews = $totalBlogViews + $totalPortfolioViews;

        return view('dashboard.admin', compact(
            'totalBlogViews',
            'totalPortfolioViews',
            'totalBlogs',
            'totalPortfolios',
            'topBlogs',
            'topPortfolios',
            'totalViews'
        ));
    }
    public function viewStats(Request $request)
    {
        $start = $request->start ?? now()->subDays(30)->toDateString();
        $end   = $request->end ?? now()->toDateString();
        $type  = $request->type ?? 'blogs';

        $blogs = collect();
        $portfolios = collect();

        if ($type === 'blogs' || $type === 'both') {
            $blogs = DB::table('blogs')
                ->selectRaw('DATE(created_at) as date, SUM(view_count) as total')
                ->whereBetween(DB::raw('DATE(created_at)'), [$start, $end])
                ->groupBy('date')
                ->orderBy('date')
                ->get();
        }

        if ($type === 'portfolios' || $type === 'both') {
            $portfolios = DB::table('portfolios')
                ->selectRaw('DATE(created_at) as date, SUM(view_count) as total')
                ->whereBetween(DB::raw('DATE(created_at)'), [$start, $end])
                ->groupBy('date')
                ->orderBy('date')
                ->get();
        }

        return response()->json([
            'blogs' => $blogs,
            'portfolios' => $portfolios,
        ]);
    }
}
