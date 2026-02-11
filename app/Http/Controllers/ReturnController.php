<?php

namespace App\Http\Controllers;

use App\Models\ReturnBook;
use Illuminate\Http\Request;
use App\Models\Borrow;
class ReturnController extends Controller
{
    public function index() {

        $returns = ReturnBook::with(['borrow.user', 'borrow.bookItem.book'])->orderBy('created_at', 'desc')->get();
        return view('petugas.pengembalian.index', compact('returns'));
    }

    public function create(Request $request){
        $borrow = null;
        $notFound = false;

        if ($request->has('nomor_peminjaman')) {
            $borrow = Borrow::with(['user', 'bookItem.book'])
                ->where('id', $request->nomor_peminjaman)
                ->where('status', 'disetujui')
                ->whereNotIn('id', function($query) {
                    $query->select('borrows_id')->from('return_books');
                })
                ->first();

            if (!$borrow) {
                $notFound = true;
            }
        }

        return view('petugas.pengembalian.create', compact('borrow', 'notFound'));
    }

    public function store(Request $request) {
        $request->validate([
            'borrow_id' => 'required|exists:borrows,id',
            'status' => 'required|in:dikembalikan,terlambat,hilang,rusak'
        ]);

        $borrow = Borrow::with(['user', 'bookItem.book'])->findOrFail($request->borrow_id);

        // Check if already returned
        $existingReturn = ReturnBook::where('borrows_id', $borrow->id)->first();
        if($existingReturn){
            return redirect()->back()->with('error', 'Peminjaman ini sudah dikembalikan.');
        }

        // Update stock buku
        $borrow->bookItem->update(['status' => 'available']);
        $return = ReturnBook::create([
            'borrows_id' => $borrow->id,
            'tanggal_pengembalian' => now(),
            'status' => $request->status,
            'denda' => $request->denda ?? 0,
        ]);

        return redirect()->route('pengembalian.index')->with('success', 'Pengembalian buku berhasil ditambahkan.');
    }
}
