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
        
        return view('affiliate.student_services.index', compact('servicesByCategory', 'affiliate', 'chatTemplates'));
    }

    public function generateProposal(Request $request)
    {
        $affiliate = Auth::guard('affiliate')->user();
        
        $request->validate([
            'wa_number' => 'required|string',
            'service_name' => 'required|string',
            'chat_message' => 'required|string'
        ]);

        // Cari atau gunakan kategori default untuk student services
        $category = BusinessCategory::firstOrCreate(
            ['slug' => 'skripsi-ecommerce'],
            ['name' => 'Skripsi - E-Commerce']
        );

        // Buat slug unik untuk landing page proposal ini
        // Kita gunakan nama service + timestamp acak
        $slug = Str::slug($request->service_name . '-' . time() . '-' . rand(100, 999));

        ClientProposal::create([
            'business_category_id' => $category->id,
            'brand_name' => $request->service_name,
            'slug' => $slug,
            'wa_number' => $request->wa_number,
            'project_price' => 1500000,
            'domain_price' => 0, // Mungkin mhs tdk butuh domain di awal
            'affiliate_id' => $affiliate->id,
            'status' => 'contacted',
        ]);

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
