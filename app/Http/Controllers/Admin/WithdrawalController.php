<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Withdrawal;

class WithdrawalController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) ($request->query('q') ?? $request->query('search') ?? ''));
        $status = $request->query('status');
        $source = $request->query('source');

        $stats = \Illuminate\Support\Facades\DB::table('withdrawals')
            ->selectRaw('COUNT(*) as total_count')
            ->selectRaw('SUM(CASE WHEN status = "Pending" THEN 1 ELSE 0 END) as pending_count')
            ->selectRaw('SUM(CASE WHEN status = "Pending" THEN amount ELSE 0 END) as pending_amount')
            ->selectRaw('SUM(CASE WHEN status = "Completed" THEN 1 ELSE 0 END) as completed_count')
            ->selectRaw('SUM(CASE WHEN status = "Completed" THEN amount ELSE 0 END) as completed_amount')
            ->first();

        $totalCount = $stats->total_count ?? 0;
        $pendingCount = $stats->pending_count ?? 0;
        $pendingAmount = $stats->pending_amount ?? 0;
        $completedCount = $stats->completed_count ?? 0;
        $completedAmount = $stats->completed_amount ?? 0;

        $withdrawals = Withdrawal::with('affiliate')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('bank_info', 'like', "%{$search}%")
                        ->orWhereHas('affiliate', function ($sub) use ($search) {
                            $sub->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->when($status && in_array($status, [Withdrawal::STATUS_PENDING, Withdrawal::STATUS_COMPLETED]), function ($q) use ($status) {
                $q->where('status', $status);
            })
            ->when($source && in_array($source, [Withdrawal::SOURCE_COMMISSION, Withdrawal::SOURCE_WALLET]), function ($q) use ($source) {
                $q->where('source', $source);
            })
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.withdrawals.index', compact(
            'withdrawals',
            'totalCount',
            'pendingCount',
            'pendingAmount',
            'completedCount',
            'completedAmount'
        ));
    }

    public function approve(Request $request, Withdrawal $withdrawal)
    {
        if ($withdrawal->status !== Withdrawal::STATUS_PENDING) {
            return back()->with('error', 'Penarikan ini sudah diproses sebelumnya.');
        }

        $request->validate([
            'proof' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('proof')) {
            $path = $request->file('proof')->store('withdrawals', 'public');
            
            $withdrawal->update([
                'status' => Withdrawal::STATUS_COMPLETED,
                'proof_of_payment' => $path,
                'processed_at' => now(),
            ]);
            
            $withdrawal->affiliate->notify(new \App\Notifications\AffiliateNotification(
                'Penarikan Berhasil!', 
                'Penarikan ' . Withdrawal::sourceLabel($withdrawal->source) . ' sebesar Rp ' . number_format($withdrawal->amount, 0, ',', '.') . ' telah ditransfer ke rekening Anda.', 
                'success'
            ));

            return back()->with('success', 'Penarikan berhasil diselesaikan dan bukti telah diunggah.');
        }

        return back()->with('error', 'Gagal mengunggah bukti pembayaran.');
    }
}
