<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        if (Auth::attempt($request->only('username', 'password'))) {
            $request->session()->regenerate();
            if (auth()->user()->level == "1") {
                return redirect()->intended('dashboard');
            } else {
                return redirect()->intended('info/bill');
            }
        }
        // dd(auth()->user()->level);
        return redirect('/')->with(
            'loginError',
            'Username dan Password Tidak Sesuai/Ditemukan'
        );
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return redirect('/');
    }
}