<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Tampilkan daftar user dengan search & filter role
     */
    public function index(Request $request)
    {
        $query = User::where('role', '!=', 'admin');

        // Search: nama atau nomor identitas
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('nomor_identitas', 'like', '%' . $search . '%');
            });
        }

        // Filter: role (petugas/peminjam)
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Tampilkan form tambah user baru
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Simpan user baru ke database
     * Validasi: nama, nomor identitas (unique, harus angka), role, password (min 8 karakter)
     */
    public function store(Request $request)
    {
        // Validasi input sesuai dengan field yang ada di form
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'identitas' => 'required|integer|unique:users,nomor_identitas',
            'role' => ['required', Rule::in(['admin', 'petugas', 'peminjam'])],
            'password' => 'required|string|min:8',
        ], [
            // Custom error messages (bahasa Indonesia)
            'nama.required' => 'Nama lengkap wajib diisi',
            'nama.max' => 'Nama maksimal 255 karakter',
            'identitas.required' => 'Nomor identitas wajib diisi',
            'identitas.integer' => 'Nomor identitas harus berupa angka',
            'identitas.unique' => 'Nomor identitas sudah terdaftar',
            'role.required' => 'Role wajib dipilih',
            'role.in' => 'Role tidak valid. Harus: admin, petugas, atau peminjam',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
        ]);

        try {
            // Buat user baru dengan password ter-hash
            User::create([
                'name' => $validated['nama'],
                'nomor_identitas' => $validated['identitas'],
                'role' => $validated['role'],
                'password' => Hash::make($validated['password']),
            ]);

            // Redirect ke halaman daftar user dengan pesan sukses
            return redirect()->route('user.list')
                ->with('success', 'User berhasil ditambahkan!');

        } catch (\Exception $e) {
            // Jika terjadi error, redirect kembali dengan pesan error
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Hapus user berdasarkan ID
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
    }
}
