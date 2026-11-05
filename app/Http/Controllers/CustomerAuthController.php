<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * Registrasi & login customer (guard "customer"), terpisah dari admin (web) dan partner (affiliate).
 */
class CustomerAuthController extends Controller
{
    /** Bonus poin untuk akun baru (sama dengan welcome bonus modul travel). */
    public const WELCOME_POINTS = 50;

    public function showLoginForm()
    {
        return view('customer.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::guard('customer')->attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('topup.index'));
    }

    public function showRegisterForm()
    {
        return view('customer.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'email', 'max:255', Rule::unique('customers', 'email')],
            'phone'    => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\s-]+$/'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $customer = Customer::create($data + ['points' => self::WELCOME_POINTS, 'source' => Customer::SOURCE_TOPUP]);

        Auth::guard('customer')->login($customer);
        $request->session()->regenerate();

        return redirect()->intended(route('topup.index'))
            ->with('success', 'Akun berhasil dibuat. Selamat datang, ' . $customer->name . '!');
    }

    public function account()
    {
        $customer = Auth::guard('customer')->user();

        return view('customer.account', [
            'customer' => $customer,
            'orders'   => $customer->orders()->latest()->paginate(10),
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('customer')->logout();
        $request->session()->regenerateToken();

        return redirect()->route('topup.index')->with('success', 'Anda sudah keluar.');
    }
}
