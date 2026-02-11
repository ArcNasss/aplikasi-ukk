<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Controller untuk autentikasi (login & register)
 */
class AuthController extends Controller
{
    // Tampilkan form register
    public function showRegisterForm() {
        return view('auth.register');
    }

    // Proses register user baru
    public function register(Request $request) {
        $request->validate([
            "name" => "required|string|max:255",
            "nomor_identitas" => "required|integer|unique:users,nomor_identitas",
            "password" => "required|string|min:8|confirmed",
        ]);

        User::create([
            "name" => $request->name,
            "nomor_identitas" => $request->nomor_identitas,
            "password" => Hash::make($request->password),
            'role' => 'peminjam',
        ]);

        return redirect()->route('login');
    }

    // Tampilkan form login
    public function showLoginForm() {
        return view('auth.login');
    }

    // Proses login & redirect berdasarkan role
    public function login(Request $request) {
        $request->validate([
            "nomor_identitas" => "required|integer",
            "password" => "required|string",
        ]);

        $user = User::where('nomor_identitas', $request->nomor_identitas)->first();

        if($user && Hash::check($request->password, $user->password)){
            Auth::login($user);

            // Redirect sesuai role user
            switch ($user->role) {
                case 'admin': return redirect()->route('admin.dashboard');
                case 'petugas': return redirect()->route('petugas.dashboard');
                case 'peminjam': return redirect()->route('peminjam.book.list');
                default: return "sinten?";
            }
        }

        return back()->withErrors(['nomor_identitas' => 'Nomor Identitas atau password salah'])->withInput();
    }

    // Proses logout
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda berhasil logout');
    }
}
