<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomerBalanceException;
use App\Models\CustomerWithdrawal;
use App\Services\CustomerBalanceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * Akun customer top up: saldo (refund order gagal), riwayat, dan penarikan ke e-wallet.
 */
class CustomerAccountController extends Controller
{
    public function account()
    {
        /** @var \App\Models\Customer $customer */
        $customer = Auth::guard('customer')->user();

        return view('customer.account', [
            'customer'          => $customer,
            'orders'            => $customer->orders()->latest()->paginate(10),
            'mutations'         => $customer->balanceMutations()->latest('id')->limit(10)->get(),
            'pendingWithdrawal' => $customer->withdrawals()->where('status', CustomerWithdrawal::STATUS_PENDING)->latest('id')->first(),
            'withdrawals'       => $customer->withdrawals()->latest('id')->limit(5)->get(),
        ]);
    }

    public function withdrawForm()
    {
        /** @var \App\Models\Customer $customer */
        $customer = Auth::guard('customer')->user();

        if ($customer->withdrawals()->where('status', CustomerWithdrawal::STATUS_PENDING)->exists()) {
            return redirect()->route('customer.account')->with('error', 'Masih ada penarikan yang sedang diproses.');
        }

        return view('customer.withdraw', ['customer' => $customer]);
    }

    public function storeWithdrawal(Request $request, CustomerBalanceService $balance): RedirectResponse
    {
        /** @var \App\Models\Customer $customer */
        $customer = Auth::guard('customer')->user();

        $request->merge(['account_no' => preg_replace('/\D/', '', (string) $request->input('account_no'))]);

        $data = $request->validate([
            'amount'       => ['required', 'integer', 'min:' . CustomerWithdrawal::MIN_AMOUNT],
            'ewallet'      => ['required', Rule::in(CustomerWithdrawal::EWALLETS)],
            'account_no'   => ['required', 'regex:/^0?8\d{7,12}$/'],
            'account_name' => ['required', 'string', 'max:100'],
        ], [
            'amount.min'          => 'Minimal penarikan Rp ' . number_format(CustomerWithdrawal::MIN_AMOUNT, 0, ',', '.') . '.',
            'ewallet.in'          => 'Pilih e-wallet tujuan.',
            'account_no.regex'    => 'Nomor e-wallet tidak valid. Gunakan nomor HP yang terdaftar, contoh 0812xxxxxxxx.',
            'account_name.required' => 'Nama pemilik akun e-wallet wajib diisi.',
        ]);

        try {
            $withdrawal = $balance->requestWithdrawal(
                $customer, (float) $data['amount'], $data['ewallet'], $data['account_no'], trim($data['account_name'])
            );
        } catch (CustomerBalanceException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->route('customer.account')->with('success',
            'Penarikan diajukan. Rp ' . number_format((float) $withdrawal->net_amount, 0, ',', '.') . " akan dikirim ke {$withdrawal->ewallet} setelah diproses admin.");
    }
}
