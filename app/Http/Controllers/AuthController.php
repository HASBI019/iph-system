<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // 🔐 Tampilkan halaman login
    public function loginForm()
    {
        return view('auth.login');
    }

    // ✅ Proses login
    public function loginSubmit(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 🔍 Logging untuk debugging
        Log::info('Percobaan login untuk email: ' . $request->email);

        // Coba login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // ✅ Logging sukses
            Log::info('Login berhasil: ' . Auth::user()->email);

            // 🚀 Langsung redirect, jangan gunakan intended (karena akses awal biasanya langsung ke /login)
            return redirect('/admin/dashboard');
        }

        // ❌ Kalau gagal login
        Log::warning('Login gagal untuk email: ' . $request->email);
        return back()->with('error', 'Email atau password salah.');
    }

    // 🚪 Proses logout
    public function logout(Request $request)
    {
        // Logging user logout
        if (Auth::check()) {
            Log::info('Logout oleh: ' . Auth::user()->email);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Berhasil logout.');
    }
}
