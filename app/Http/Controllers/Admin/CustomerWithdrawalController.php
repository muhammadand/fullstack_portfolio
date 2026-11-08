<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerWithdrawal;
use App\Services\CustomerBalanceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Penarikan saldo customer top up: admin transfer manual ke e-wallet lalu menandai selesai, atau menolak.
 */
class CustomerWithdrawalController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', CustomerWithdrawal::STATUS_PENDING);
        $status = array_key_exists($status, CustomerWithdrawal::STATUS_META) ? $status : CustomerWithdrawal::STATUS_PENDING;

        $withdrawals = CustomerWithdrawal::with(['customer:id,name,email', 'processor:id,name'])
            ->where('status', $status)
            ->orderBy($status === CustomerWithdrawal::STATUS_PENDING ? 'id' : 'processed_at', $status === CustomerWithdrawal::STATUS_PENDING ? 'asc' : 'desc')
            ->paginate(20)->withQueryString();

        $counts = CustomerWithdrawal::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');
        $pendingTotal = (float) CustomerWithdrawal::where('status', CustomerWithdrawal::STATUS_PENDING)->sum('net_amount');

        return view('admin.customer_withdrawals.index', compact('withdrawals', 'status', 'counts', 'pendingTotal'));
    }

    public function complete(Request $request, CustomerWithdrawal $withdrawal, CustomerBalanceService $balance): RedirectResponse
    {
        $data = $request->validate([
            'transfer_reference' => ['nullable', 'string', 'max:100'],
        ]);

        if (!$balance->complete($withdrawal, $request->user(), $data['transfer_reference'] ?? null)) {
            return back()->with('error', "Penarikan {$withdrawal->withdrawal_no} sudah diproses sebelumnya.");
        }

        return back()->with('success', "Penarikan {$withdrawal->withdrawal_no} ditandai selesai.");
    }

    public function reject(Request $request, CustomerWithdrawal $withdrawal, CustomerBalanceService $balance): RedirectResponse
    {
        $data = $request->validate([
            'reason' => ['required', 'string', 'max:255'],
        ], ['reason.required' => 'Alasan penolakan wajib diisi.']);

        if (!$balance->reject($withdrawal, $request->user(), $data['reason'])) {
            return back()->with('error', "Penarikan {$withdrawal->withdrawal_no} sudah diproses sebelumnya.");
        }

        return back()->with('success', "Penarikan {$withdrawal->withdrawal_no} ditolak, saldo customer dikembalikan.");
    }
}
