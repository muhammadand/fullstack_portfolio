<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ClientProposal;
use Illuminate\Support\Str;

class ClientProposalController extends Controller
{
    public function index()
    {
        $proposals = ClientProposal::latest()->get();
        return view('admin.client-proposals.index', compact('proposals'));
    }

    public function create()
    {
        return view('admin.client-proposals.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
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
        return view('admin.client-proposals.edit', compact('client_proposal'));
    }

    public function update(Request $request, ClientProposal $client_proposal)
    {
        $validated = $request->validate([
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
}
