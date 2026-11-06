<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:gurus,username',
            'password' => 'required|string|min:4|confirmed',
        ], [
            'username.unique' => 'Username ini sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi sandi tidak sama.',
        ]);

        Guru::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login-guru')->with('success', 'Akun berhasil dibuat! Silakan masuk.');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/dashboard-guru');
        }

        return back()->withErrors(['login_error' => 'Username atau kata sandi salah.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // DIUBAH KE BERANDA UTAMA ( / )
        return redirect('/');
    }
}
