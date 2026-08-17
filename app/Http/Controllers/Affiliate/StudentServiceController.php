<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentService;
use App\Models\Affiliate;
use App\Models\ClientProposal;
use App\Models\BusinessCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StudentServiceController extends Controller
{
    public function index()
    {
        $servicesByCategory = StudentService::where('is_active', true)
                                ->get()
                                ->groupBy('category');
        
        // Dapatkan data affiliate saat ini
        $affiliate = Auth::guard('affiliate')->user();
        
        // Dapatkan template chat yang global (tanpa business category) atau milik affiliate ini
        $chatTemplates = \App\Models\ChatTemplate::where(function($query) use ($affiliate) {
            $query->whereNull('business_category_id')
                  ->whereNull('affiliate_id');
        })->orWhere('affiliate_id', $affiliate->id)->get();
        
        $myLeads = \App\Models\StudentLead::where('affiliate_id', $affiliate->id)->latest()->get();
        
        return view('affiliate.student_services.index', compact('servicesByCategory', 'affiliate', 'chatTemplates', 'myLeads'));
    }

    public function generateProposal(Request $request)
    {
        $affiliate = Auth::guard('affiliate')->user();
        
        $request->validate([
            'wa_number' => 'nullable|string',
            'student_lead_id' => 'nullable|exists:student_leads,id',
            'service_name' => 'required|string',
            'chat_message' => 'required|string'
        ]);
        
        $waNumber = $request->wa_number;
        $existingLead = null;

        if ($request->student_lead_id) {
            $existingLead = \App\Models\StudentLead::find($request->student_lead_id);
            if ($existingLead) {
                $waNumber = $existingLead->wa_number;
            }
        }

        // Pastikan waNumber tidak kosong
        if (empty($waNumber)) {
            return redirect()->back()->with('error', 'Nomor WA harus diisi atau pilih prospek.');
        }

        // Cari atau gunakan kategori default untuk student services
        $category = BusinessCategory::firstOrCreate(
            ['slug' => 'skripsi-ecommerce'],
            ['name' => 'Skripsi - E-Commerce']
        );

        // Buat slug unik untuk landing page proposal ini
        // Kita gunakan nama service + timestamp acak
        $slug = Str::slug($request->service_name . '-' . time() . '-' . rand(100, 999));

        $proposal = ClientProposal::create([
            'business_category_id' => $category->id,
            'brand_name' => $request->service_name,
            'slug' => $slug,
            'wa_number' => $waNumber,
            'project_price' => 1500000,
            'domain_price' => 0, // Mungkin mhs tdk butuh domain di awal
            'affiliate_id' => $affiliate->id,
            'status' => 'contacted',
        ]);

        if ($existingLead) {
            $existingLead->update([
                'client_proposal_id' => $proposal->id,
                'status' => 'contacted',
            ]);
        } else {
            \App\Models\StudentLead::create([
                'wa_number' => $waNumber,
                'needs' => $request->service_name,
                'affiliate_id' => $affiliate->id,
                'client_proposal_id' => $proposal->id,
                'status' => 'contacted',
            ]);
        }

        // Buat link landing page
        $landingUrl = url("/landing/{$slug}");

        // Replace link affiliate default menjadi link proposal spesifik jika template-nya memiliki format tersebut
        $finalMessage = $request->chat_message;
        $finalMessage .= "\n\nCek penawarannya di sini ya bro:\n" . $landingUrl;

        // Redirect ke whatsapp
        // Format wa
        $phone = preg_replace('/[^0-9]/', '', $request->wa_number);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        $waUrl = "https://wa.me/{$phone}?text=" . urlencode($finalMessage);

        return redirect()->away($waUrl);
    }
}
