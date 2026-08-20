<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BusinessCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $affiliate = Auth::guard('affiliate')->user();
        
        $blogs = Blog::where('affiliate_id', $affiliate->id)
            ->latest()
            ->paginate(10);
            
        return view('affiliate.blogs.index', compact('affiliate', 'blogs'));
    }

    public function create()
    {
        $affiliate = Auth::guard('affiliate')->user();
        $categories = BusinessCategory::all();
        
        return view('affiliate.blogs.create', compact('affiliate', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'business_category_id' => 'required|exists:business_categories,id',
            'content' => 'required|string',
            'featured_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $affiliate = Auth::guard('affiliate')->user();

        // Handle image upload
        $imagePath = $request->file('featured_image')->store('blogs', 'public');
        
        // Find default blog category (fallback)
        $defaultBlogCategory = \App\Models\BlogCategory::first();

        $blog = new Blog();
        $blog->title = $request->title;
        $blog->slug = Str::slug($request->title) . '-' . time();
        $blog->content = $request->content;
        $blog->excerpt = Str::limit(strip_tags($request->content), 150);
        $blog->featured_image = $imagePath;
        $blog->author_id = 1; // Default Admin as author (will be overridden by affiliate_id in UI if needed)
        $blog->affiliate_id = $affiliate->id;
        $blog->business_category_id = $request->business_category_id;
        $blog->category_id = $defaultBlogCategory ? $defaultBlogCategory->id : 1;
        $blog->is_published = false;
        
        // Generate simple meta for SEO
        $blog->meta_title = $request->title;
        $blog->meta_description = Str::limit(strip_tags($request->content), 150);
        $blog->reading_time = max(1, ceil(str_word_count(strip_tags($request->content)) / 200));
        
        $blog->save();

        return redirect()->route('affiliate.blogs.index')->with('success', 'Artikel berhasil dikirim! Menunggu review dari Admin.');
    }
}
