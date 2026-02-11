<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrow;

class BorrowController extends Controller
{
    public function store(Request $request){
        // Validasi input
        $request->validate([
            'book_item_id' => 'required|exists:book_items,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',

        ]);

        // Simpan data peminjaman
        Borrow::create([
            'user_id' => auth()->id(),
            'book_item_id' => $request->book_item_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'pending',
        ]);

        return redirect()->route('peminjaman.list')->with('success', 'Permintaan peminjaman berhasil dikirim.');
    }
}
