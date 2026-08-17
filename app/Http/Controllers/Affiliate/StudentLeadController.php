<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentLead;
use Illuminate\Support\Facades\Auth;

class StudentLeadController extends Controller
{
    public function index(Request $request)
    {
        $affiliate = Auth::guard('affiliate')->user();
        
        if ($affiliate->status !== 'approved') {
            return redirect()->route('affiliate.dashboard')->with('error', 'Akun Anda belum disetujui.');
        }

        $tab = $request->get('tab', 'global'); // 'global' or 'my_leads'

        $query = StudentLead::latest();

        if ($tab === 'my_leads') {
            $query->where('affiliate_id', $affiliate->id);
        } else {
            $query->whereNull('affiliate_id');
        }
        
        $leads = $query->simplePaginate(10)->withQueryString();

        return view('affiliate.student_leads.index', compact('affiliate', 'leads', 'tab'));
    }

    public function claim($id)
    {
        $affiliate = Auth::guard('affiliate')->user();
        $lead = StudentLead::findOrFail($id);

        if ($lead->affiliate_id) {
            return redirect()->back()->with('error', 'Data ini sudah diklaim oleh partner lain.');
        }

        $lead->update([
            'affiliate_id' => $affiliate->id,
            'status' => 'contacted' // or whatever logic you prefer
        ]);

        return redirect()->route('affiliate.student_leads.index', ['tab' => 'my_leads'])->with('success', 'Data Mahasiswa berhasil diklaim.');
    }

    public function store(Request $request)
    {
        $affiliate = Auth::guard('affiliate')->user();
        
        $request->validate([
            'wa_number' => 'required|string',
            'name' => 'nullable|string|max:255',
            'needs' => 'nullable|string|max:255',
        ]);

        StudentLead::create([
            'wa_number' => $request->wa_number,
            'name' => $request->name,
            'needs' => $request->needs ?? 'Belum Diketahui',
            'affiliate_id' => $affiliate->id,
            'status' => 'new',
        ]);

        return redirect()->route('affiliate.student_leads.index', ['tab' => 'my_leads'])->with('success', 'Prospek Mahasiswa berhasil ditambahkan.');
    }
}
