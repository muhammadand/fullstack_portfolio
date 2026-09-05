<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DigitalProduct;
use Illuminate\Support\Facades\Auth;

class DigitalProductController extends Controller
{
    public function index(Request $request)
    {
        $affiliate = Auth::guard('affiliate')->user();

        $query = DigitalProduct::active()->ordered();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('short_description', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $products = $query->get();
        $categories = DigitalProduct::active()->distinct()->pluck('category')->filter()->values();

        return view('affiliate.digital_products.index', compact('affiliate', 'products', 'categories'));
    }
}
