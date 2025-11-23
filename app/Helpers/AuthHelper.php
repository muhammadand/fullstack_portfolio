<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class AuthHelper
{
    public static function mustLogin()
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        return null; // artinya sukses
    }
}
