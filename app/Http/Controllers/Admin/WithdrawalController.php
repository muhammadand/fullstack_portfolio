<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Withdrawal;

class WithdrawalController extends Controller
{
    public function index()
    {
        $withdrawals = Withdrawal::with('affiliate')->latest()->get();
        return view('admin.withdrawals.index', compact('withdrawals'));
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
