<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * FORM REGISTER
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * PROSES REGISTER
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'nullable|string|in:super_admin,admin,editor',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        User::create($validator->validated());

        return redirect()->route('login')->with('success', 'Berhasil mendaftar. Silakan login.');
    }

    /**
     * FORM LOGIN
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * PROSES LOGIN (TANPA JWT)
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (! Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Email atau password salah'
            ])->withInput();
        }

        // Login sukses → arahkan berdasarkan role
        return $this->redirectByRole(Auth::user());
    }

    /**
     * REDIRECT BERDASARKAN ROLE
     */
    protected function redirectByRole($user)
    {
        if ($user->role === 'super_admin') {
            return redirect()->route('dashboard.admin');
        }

        if ($user->role === 'admin') {
            return redirect()->route('dashboard.admin');
        }

        if ($user->role === 'editor') {
            return redirect()->route('dashboard.editor');
        }

        return redirect('/'); // fallback
    }

    /**
     * LOGOUT
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Berhasil logout');
    }
}
