<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegisterForm() {
        return view('auth.register');
    }


    public function register(Request $request) {
        $request->validate([
            "name" => "required|string|max:255",
            "nomor_identitas" => "required|integer|unique:users,nomor_identitas",
            "password" => "required|string|min:8|confirmed",
        ]);

        $user = User::create([
            "name" => $request->name,
            "nomor_identitas" => $request->nomor_identitas,
            "password" => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return redirect()->route('login');
    }


    public function showLoginForm() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            "nomor_identitas" => "required|integer",
            "password" => "required|string",
        ]);

        $user = User::where('nomor_identitas', $request->nomor_identitas)->first();
        if($user && Hash::check($request->password, $user->password)){
            Auth::login($user);
            $role = $user->role;

            switch ($role) {
                case 'admin': return redirect()->route('dashboard');
                break;
                case 'petugas': return "halo petugas";
                break;
                case 'peminjam': return "halo peminjam";
                break;
                default: return "sinten?";
            }
        }

        return back()->withErrors(['nomor_identitas' => 'Nomor Identitas atau password salah'])->withInput();
    }
}
