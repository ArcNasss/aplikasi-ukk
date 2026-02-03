<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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
     * Hapus user berdasarkan ID
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
    }
}
