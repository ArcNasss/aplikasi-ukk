<?php

namespace App\Http\Controllers;

use App\Models\BookItem;
use Illuminate\Http\Request;
use App\Models\Borrow;
use Illuminate\Support\Facades\Auth;

class BorrowController extends Controller
{

    public function index(){
        $borrows = Borrow::with(['user', 'bookItem.book'])->where('status', 'pending')->orderBy('created_at', 'desc')->get();

        return view('petugas.peminjaman.index', compact('borrows') );

    }

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

    // setujui peminjaman
    public function approve($id) {
        $borrow = Borrow::findOrfail($id);

        if($borrow){
            $borrow->update([
                'status' => 'disetujui',
                'tanggal_pinjam' => now(),
                'tanggal_kembali' => now()->addDays(7),
                'petugas_id' => Auth::id(),
            ]);

            return redirect()->back()->with('success', 'Peminjaman berhasil disetujui.');
        }

    }

    // tolak peminjaman
    public function reject($id) {
        $borrow = Borrow::findOrFail($id);

        if($borrow){
            $borrow->update([
                'status' => 'ditolak',
                'petugas_id' => Auth::id(),
            ]);
        }

        return redirect()->back()->with('success', 'Peminjaman berhasil ditolak.');
    }
}
