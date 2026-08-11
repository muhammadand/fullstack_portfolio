<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BusinessCategory;
use Illuminate\Support\Str;

class BusinessCategoryController extends Controller
{
    public function index()
    {
        $categories = BusinessCategory::latest()->get();
        return view('admin.business-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.business-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'wa_template' => 'nullable|string',
            'project_price' => 'required|numeric',
            'domain_price' => 'required|numeric',
        ]);

        $validated['slug'] = Str::slug($request->name);
        
        if (BusinessCategory::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $validated['slug'] . '-' . time();
        }

        BusinessCategory::create($validated);

        return redirect()->route('admin.business_categories.index')->with('success', 'Kategori Bisnis berhasil ditambahkan.');
    }

    public function edit(BusinessCategory $business_category)
    {
        return view('admin.business-categories.edit', compact('business_category'));
    }

    public function update(Request $request, BusinessCategory $business_category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'wa_template' => 'nullable|string',
            'project_price' => 'required|numeric',
            'domain_price' => 'required|numeric',
        ]);

        $validated['slug'] = Str::slug($request->name);
        
        if ($business_category->slug !== $validated['slug'] && BusinessCategory::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $validated['slug'] . '-' . time();
        }

        $business_category->update($validated);

        return redirect()->route('admin.business_categories.index')->with('success', 'Kategori Bisnis berhasil diperbarui.');
    }

    public function destroy(BusinessCategory $business_category)
    {
        if($business_category->proposals()->count() > 0) {
            return redirect()->route('admin.business_categories.index')->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh beberapa proposal.');
        }
        $business_category->delete();
        return redirect()->route('admin.business_categories.index')->with('success', 'Kategori Bisnis berhasil dihapus.');
    }
}
