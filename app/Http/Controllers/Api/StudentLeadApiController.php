<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentLead;
use Illuminate\Support\Facades\Log;

class StudentLeadApiController extends Controller
{
    /**
     * Bulk store student leads (usually as Global leads).
     * Endpoint: POST /api/student-leads/bulk
     */
    public function bulkStore(Request $request)
    {
        $request->validate([
            'leads' => 'required|array',
            'leads.*.wa_number' => 'required|string',
            'leads.*.name' => 'nullable|string|max:255',
            'leads.*.needs' => 'nullable|string|max:255',
            'leads.*.university' => 'nullable|string|max:255',
        ]);

        $insertedCount = 0;
        $failedCount = 0;

        foreach ($request->leads as $leadData) {
            try {
                // Hindari duplikasi jika wa_number sudah ada
                $exists = StudentLead::where('wa_number', $leadData['wa_number'])->exists();
                if (!$exists) {
                    StudentLead::create([
                        'wa_number' => $leadData['wa_number'],
                        'name' => $leadData['name'] ?? null,
                        'needs' => $leadData['needs'] ?? 'Belum Diketahui',
                        'university' => $leadData['university'] ?? null,
                        'status' => 'new',
                        'affiliate_id' => null, // Default to Global
                    ]);
                    $insertedCount++;
                } else {
                    $failedCount++; // Duplicate
                }
            } catch (\Exception $e) {
                Log::error("Failed to insert lead via API: " . $e->getMessage());
                $failedCount++;
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Proses bulk insert selesai.',
            'data' => [
                'inserted' => $insertedCount,
                'failed_or_duplicate' => $failedCount
            ]
        ], 200);
    }
}
