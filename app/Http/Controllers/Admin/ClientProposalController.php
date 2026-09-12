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

        if ($request->filled('owner_status')) {
            if ($request->owner_status === 'claimed') {
                $query->whereNotNull('affiliate_id');
            } elseif ($request->owner_status === 'unclaimed') {
                $query->whereNull('affiliate_id');
            }
        }

        $proposals = $query->paginate(15)->appends($request->all());
        $chatTemplates = \App\Models\ChatTemplate::whereNull('affiliate_id')->get();
        $categories = BusinessCategory::all();

        $totalProposals = ClientProposal::count();
        $claimedProposals = ClientProposal::whereNotNull('affiliate_id')->count();
        $unclaimedProposals = ClientProposal::whereNull('affiliate_id')->count();

        return view('admin.client-proposals.index', compact(
            'proposals',
            'chatTemplates',
            'categories',
            'totalProposals',
            'claimedProposals',
            'unclaimedProposals'
        ));
    }

    public function bulkUpdatePrice(Request $request)
    {
        $request->validate([
            'price_silver' => 'nullable|numeric|min:0',
            'price_gold' => 'nullable|numeric|min:0',
            'price_diamond' => 'nullable|numeric|min:0',
            'price_platinum' => 'nullable|numeric|min:0',
            'scope' => 'required|string|in:all,category,selected',
            'target_category_id' => 'nullable|exists:business_categories,id',
            'selected_ids' => 'nullable|array',
            'selected_ids.*' => 'exists:client_proposals,id',
        ]);

        if (!$request->filled('price_silver') && !$request->filled('price_gold') && !$request->filled('price_diamond') && !$request->filled('price_platinum')) {
            return redirect()->back()->with('error', 'Silakan masukkan minimal salah satu harga paket yang ingin diubah.');
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
        if ($request->filled('price_silver')) {
            $updateData['price_silver'] = $request->price_silver;
        }
        if ($request->filled('price_gold')) {
            $updateData['price_gold'] = $request->price_gold;
        }
        if ($request->filled('price_diamond')) {
            $updateData['price_diamond'] = $request->price_diamond;
        }
        if ($request->filled('price_platinum')) {
            $updateData['price_platinum'] = $request->price_platinum;
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
            'price_silver' => 'nullable|numeric|min:0',
            'price_gold' => 'nullable|numeric|min:0',
            'price_diamond' => 'nullable|numeric|min:0',
            'price_platinum' => 'nullable|numeric|min:0',
            'renewal_silver' => 'nullable|string|max:100',
            'renewal_gold' => 'nullable|string|max:100',
            'renewal_diamond' => 'nullable|string|max:100',
            'renewal_platinum' => 'nullable|string|max:100',
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
            'price_silver' => 'nullable|numeric|min:0',
            'price_gold' => 'nullable|numeric|min:0',
            'price_diamond' => 'nullable|numeric|min:0',
            'price_platinum' => 'nullable|numeric|min:0',
            'renewal_silver' => 'nullable|string|max:100',
            'renewal_gold' => 'nullable|string|max:100',
            'renewal_diamond' => 'nullable|string|max:100',
            'renewal_platinum' => 'nullable|string|max:100',
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
                'price_silver' => 700000,
                'price_gold' => 1600000,
                'price_diamond' => 2000000,
                'price_platinum' => 3000000,
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

    public function detectDuplicates(Request $request)
    {
        $duplicates = \Illuminate\Support\Facades\DB::table('client_proposals')
            ->select('wa_number', \Illuminate\Support\Facades\DB::raw('count(*) as count'))
            ->groupBy('wa_number')
            ->having('count', '>', 1)
            ->get();
        
        return response()->json(['duplicates' => $duplicates]);
    }

    public function cleanDuplicates(Request $request)
    {
        $duplicates = \Illuminate\Support\Facades\DB::table('client_proposals')
            ->select('wa_number', \Illuminate\Support\Facades\DB::raw('MIN(id) as keep_id'))
            ->groupBy('wa_number')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        $deletedCount = 0;
        foreach ($duplicates as $duplicate) {
            $deleted = \Illuminate\Support\Facades\DB::table('client_proposals')
                ->where('wa_number', $duplicate->wa_number)
                ->where('id', '!=', $duplicate->keep_id)
                ->delete();
            $deletedCount += $deleted;
        }

        return redirect()->back()->with('success', "Berhasil membersihkan {$deletedCount} data duplikat.");
    }
}
