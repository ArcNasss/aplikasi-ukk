<?php

namespace App\Http\Controllers;

use App\Models\BookItem;
use Illuminate\Http\Request;
use App\Models\Borrow;

class BorrowController extends Controller
{
    public function store(Request $request){

        //dd($request);
        $request->validate([
            'book_id' => 'required|exists:books,id',

        ]);
        $existBookItem = BookItem::where('book_id', $request->book_id)->where('status', 'available')->first();

        if(!$existBookItem){
            return redirect()->back()->with('error', 'Maaf, tidak ada buku tersedia untuk dipinjam.');
        };



        // Simpan data peminjaman
        Borrow::create([
            'user_id' => auth()->id(),
            'book_item_id' => $existBookItem->id,
            'tanggal_pinjam' => null,
            'tanggal_kembali' => null,
            'status' => 'pending',
        ]);

        return redirect()->route('peminjaman.list')->with('success', 'Permintaan peminjaman berhasil dikirim.');
    }
}
