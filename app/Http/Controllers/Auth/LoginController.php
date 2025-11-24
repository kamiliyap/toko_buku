<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __construct()
    {
        // hanya guest yang boleh lihat login, kecuali logout
        $this->middleware('guest')->except('logout');
    }

    /**
     * Tampilkan form login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses login.
     */
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Jangan pakai remember dulu (karena belum ada kolom remember_token)
        // $remember = $request->boolean('remember');

        // Coba login
        if (Auth::attempt($credentials)) {
            // regenerate session biar lebih aman
            $request->session()->regenerate();

            $user = Auth::user();

            // Kalau user punya kolom is_admin dan nilainya true, arahkan ke dashboard admin
            if (isset($user->is_admin) && $user->is_admin) {
                return redirect()->intended(route('admin.dashboard'));
            }

            // Kalau bukan admin, arahkan ke halaman utama
            return redirect()->intended('/');
        }

        // Kalau gagal login
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.']
            // atau pakai: 'email' => [__('auth.failed')],
        ]);
    }

    /**
     * Logout user.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
