<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ClientProposal;
use App\Models\BusinessCategory;
use Illuminate\Support\Str;

class ClientProposalController extends Controller
{
    public function index(Request $request)
    {
        $query = ClientProposal::with(['category', 'affiliate'])->latest();

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('brand_name', 'like', "%{$search}%")
                    ->orWhere('client_name', 'like', "%{$search}%")
                    ->orWhere('wa_number', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('business_category_id', $request->category_id);
        }

        $proposals = $query->paginate(15)->appends($request->all());
        $chatTemplates = \App\Models\ChatTemplate::whereNull('affiliate_id')->get();
        $categories = BusinessCategory::all();

        return view('admin.client-proposals.index', compact('proposals', 'chatTemplates', 'categories'));
    }

    public function bulkUpdatePrice(Request $request)
    {
        $request->validate([
            'project_price' => 'nullable|numeric|min:0',
            'domain_price' => 'nullable|numeric|min:0',
            'scope' => 'required|string|in:all,category,selected',
            'target_category_id' => 'nullable|exists:business_categories,id',
            'selected_ids' => 'nullable|array',
            'selected_ids.*' => 'exists:client_proposals,id',
        ]);

        if (!$request->filled('project_price') && !$request->filled('domain_price')) {
            return redirect()->back()->with('error', 'Silakan masukkan minimal salah satu harga (Harga Project atau Harga Domain) yang ingin diubah.');
        }

        $query = ClientProposal::query();

        if ($request->scope === 'category') {
            if (!$request->filled('target_category_id')) {
                return redirect()->back()->with('error', 'Pilih kategori yang ingin diubah harganya.');
            }
            $query->where('business_category_id', $request->target_category_id);
        } elseif ($request->scope === 'selected') {
            if (empty($request->selected_ids)) {
                return redirect()->back()->with('error', 'Tidak ada data proposal yang dicentang / dipilih.');
            }
            $query->whereIn('id', $request->selected_ids);
        }

        $updateData = [];
        if ($request->filled('project_price')) {
            $updateData['project_price'] = $request->project_price;
        }
        if ($request->filled('domain_price')) {
            $updateData['domain_price'] = $request->domain_price;
        }

        $count = $query->update($updateData);

        return redirect()->route('admin.client_proposals.index', $request->only(['category_id', 'search']))->with('success', "Berhasil memperbarui harga untuk {$count} proposal klien.");
    }

    public function proposalCafe($slug)
    {
        $client = ClientProposal::where('slug', $slug)->firstOrFail();
        return view('client-proposals.cafe.proposal', compact('client'));
    }

    public function adminDemoRental($slug)
    {
        $client = ClientProposal::where('slug', $slug)->firstOrFail();
        return view('client-proposals.rental-mobil.admin-demo', compact('client'));
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
            'business_category_id' => 'nullable|integer',
            'affiliate_id' => 'nullable|integer',
            'contacts' => 'required|array',
            'contacts.*.brand_name' => 'required|string|max:255',
            'contacts.*.wa_number' => 'required|string|max:20',
        ]);

        $categoryId = $validated['business_category_id'] ?? null;
        $category = $categoryId ? BusinessCategory::find($categoryId) : null;

        $projectPrice = $category ? ($category->project_price ?? 4500000) : 4500000;
        $domainPrice = $category ? ($category->domain_price ?? 1200000) : 1200000;

        $proposals = [];

        foreach ($validated['contacts'] as $contact) {
            $slug = Str::slug($contact['brand_name']);

            // Pastikan slug unik
            $originalSlug = $slug;
            $counter = 1;
            while (ClientProposal::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            // Simpan data otomatis ke database
            $proposal = ClientProposal::create([
                'business_category_id' => $categoryId,
                'slug' => $slug,
                'brand_name' => $contact['brand_name'],
                'client_name' => $contact['brand_name'],
                'wa_number' => $contact['wa_number'],
                'wa_template' => null,
                'project_price' => $projectPrice,
                'domain_price' => $domainPrice,
            ]);

            $proposals[] = $proposal;
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data dari scraper berhasil disimpan menjadi draft proposal!',
            'data' => $proposals
        ], 201);
    }

    public function updateWaTemplate(Request $request, ClientProposal $client_proposal)
    {
        $request->validate([
            'wa_template' => 'required|string'
        ]);

        $client_proposal->update([
            'wa_template' => $request->wa_template
        ]);

        return redirect()->back()->with('success', 'Template pesan WhatsApp berhasil disimpan.');
    }
}
