<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ClientProposal;
use App\Models\BusinessCategory;
use Illuminate\Support\Str;

class ClientProposalController extends Controller
{
    public function index()
    {
        $proposals = ClientProposal::with('category')->latest()->get();
        return view('admin.client-proposals.index', compact('proposals'));
    }

    public function create()
    {
        $categories = BusinessCategory::all();
        return view('admin.client-proposals.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'business_category_id' => 'nullable|exists:business_categories,id',
            'brand_name' => 'required|string|max:255',
            'client_name' => 'nullable|string|max:255',
            'wa_number' => 'required|string|max:20',
            'wa_template' => 'nullable|string',
            'project_price' => 'required|numeric',
            'domain_price' => 'required|numeric',
        ]);

        $validated['slug'] = Str::slug($request->brand_name);
        
        // Ensure slug is unique
        if (ClientProposal::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $validated['slug'] . '-' . time();
        }

        ClientProposal::create($validated);

        return redirect()->route('admin.client_proposals.index')->with('success', 'Client Proposal berhasil ditambahkan.');
    }

    public function edit(ClientProposal $client_proposal)
    {
        $categories = BusinessCategory::all();
        return view('admin.client-proposals.edit', compact('client_proposal', 'categories'));
    }

    public function update(Request $request, ClientProposal $client_proposal)
    {
        $validated = $request->validate([
            'business_category_id' => 'nullable|exists:business_categories,id',
            'brand_name' => 'required|string|max:255',
            'client_name' => 'nullable|string|max:255',
            'wa_number' => 'required|string|max:20',
            'wa_template' => 'nullable|string',
            'project_price' => 'required|numeric',
            'domain_price' => 'required|numeric',
        ]);

        $validated['slug'] = Str::slug($request->brand_name);
        
        // Ensure slug is unique if changed
        if ($client_proposal->slug !== $validated['slug'] && ClientProposal::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $validated['slug'] . '-' . time();
        }

        $client_proposal->update($validated);

        return redirect()->route('admin.client_proposals.index')->with('success', 'Client Proposal berhasil diperbarui.');
    }

    public function destroy(ClientProposal $client_proposal)
    {
        $client_proposal->delete();
        return redirect()->route('admin.client_proposals.index')->with('success', 'Client Proposal berhasil dihapus.');
    }

    /**
     * Webhook Endpoint untuk Scraper WhatsApp
     */
    public function handleWebhook(Request $request)
    {
        // Validasi input dari scraper
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'category' => 'nullable|string|max:100',
        ]);

        $slug = Str::slug($validated['name']);
        
        // Pastikan slug unik
        if (ClientProposal::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . time();
        }

        $categoryId = null;
        $waTemplate = 'Halo tim Scalify, saya tertarik untuk diskusi lebih lanjut.';
        $projectPrice = 4500000;
        $domainPrice = 1200000;

        if (!empty($validated['category'])) {
            $category = BusinessCategory::where('name', 'like', '%' . $validated['category'] . '%')
                        ->orWhere('slug', Str::slug($validated['category']))
                        ->first();
            
            if ($category) {
                $categoryId = $category->id;
                $waTemplate = $category->wa_template ?? $waTemplate;
                $projectPrice = $category->project_price;
                $domainPrice = $category->domain_price;
            }
        }

        // Simpan data otomatis ke database
        $proposal = ClientProposal::create([
            'business_category_id' => $categoryId,
            'slug' => $slug,
            'brand_name' => $validated['name'],
            'client_name' => $validated['name'],
            'wa_number' => $validated['phone'],
            'wa_template' => $waTemplate,
            'project_price' => $projectPrice,
            'domain_price' => $domainPrice,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data dari scraper berhasil disimpan menjadi draft proposal!',
            'data' => $proposal
        ], 201);
    }
}
