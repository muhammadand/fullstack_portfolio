<?php

namespace App\Http\Controllers;

use App\Models\ChatTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AffiliateChatTemplateController extends Controller
{
    public function index(Request $request)
    {
        $affiliate = Auth::guard('affiliate')->user();
        $selectedProduct = $request->query('product_type');

        // Query ringan: select kolom yang dibutuhkan saja dan eager load businessCategory untuk cegah N+1
        $templates = ChatTemplate::query()
            ->select(['id', 'affiliate_id', 'name', 'product_type', 'business_category_id', 'content', 'created_at'])
            ->with(['businessCategory:id,name'])
            ->where('affiliate_id', $affiliate->id)
            ->when($selectedProduct, function ($q, $product) {
                $q->where('product_type', $product);
            })
            ->latest('id')
            ->get();

        $categories = \App\Models\BusinessCategory::query()
            ->select(['id', 'name'])
            ->orderBy('name')
            ->get();

        return view('affiliate.chat_templates.index', compact('templates', 'affiliate', 'categories', 'selectedProduct'));
    }

    public function store(Request $request)
    {
        $affiliate = Auth::guard('affiliate')->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'product_type' => 'nullable|string|in:website,review_card',
            'content' => 'required|string',
            'business_category_id' => 'nullable',
            'new_business_category' => 'nullable|string|max:255',
        ]);

        if (empty($validated['product_type'])) {
            $validated['product_type'] = 'website';
        }

        if (!empty($validated['new_business_category'])) {
            $newCategory = \App\Models\BusinessCategory::create([
                'name' => $validated['new_business_category'],
                'slug' => \Illuminate\Support\Str::slug($validated['new_business_category'])
            ]);
            $validated['business_category_id'] = $newCategory->id;
        } elseif (isset($validated['business_category_id']) && $validated['business_category_id'] === 'new') {
            $validated['business_category_id'] = null;
        }

        unset($validated['new_business_category']);

        $validated['affiliate_id'] = $affiliate->id;

        ChatTemplate::create($validated);

        return redirect()->back()->with('success', 'Template chat berhasil ditambahkan.');
    }

    public function update(Request $request, ChatTemplate $chat_template)
    {
        $affiliate = Auth::guard('affiliate')->user();

        if ($chat_template->affiliate_id !== $affiliate->id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'product_type' => 'nullable|string|in:website,review_card',
            'content' => 'required|string',
            'business_category_id' => 'nullable',
            'new_business_category' => 'nullable|string|max:255',
        ]);

        if (empty($validated['product_type'])) {
            $validated['product_type'] = $chat_template->product_type ?? 'website';
        }

        if (!empty($validated['new_business_category'])) {
            $newCategory = \App\Models\BusinessCategory::create([
                'name' => $validated['new_business_category'],
                'slug' => \Illuminate\Support\Str::slug($validated['new_business_category'])
            ]);
            $validated['business_category_id'] = $newCategory->id;
        } elseif (isset($validated['business_category_id']) && $validated['business_category_id'] === 'new') {
            $validated['business_category_id'] = null;
        }

        unset($validated['new_business_category']);

        $chat_template->update($validated);

        return redirect()->back()->with('success', 'Template chat berhasil diupdate.');
    }

    public function destroy(ChatTemplate $chat_template)
    {
        $affiliate = Auth::guard('affiliate')->user();

        if ($chat_template->affiliate_id !== $affiliate->id) {
            abort(403, 'Unauthorized action.');
        }

        $chat_template->delete();

        return redirect()->back()->with('success', 'Template chat berhasil dihapus.');
    }
}
