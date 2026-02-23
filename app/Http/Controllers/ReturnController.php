<?php

namespace App\Http\Controllers;

use App\Models\ReturnBook;
use Illuminate\Http\Request;
use App\Models\Borrow;
class ReturnController extends Controller
{
    // Admin: View all returns - read only
    public function adminIndex(){
        $returns = ReturnBook::with(['borrow.user', 'borrow.bookItem.book'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.pengembalian.index', compact('returns'));
    }

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

        // Hitung denda otomatis
        $denda = 0;

        if ($request->status == 'hilang') {
            // Denda buku hilang: Rp 100.000
            $denda = 100000;
        } elseif ($request->status == 'rusak') {
            // Denda buku rusak: Rp 100.000
            $denda = 100000;
        } elseif ($request->status == 'terlambat') {
            // Denda keterlambatan: Rp 2.000 per hari
            $tanggalKembali = \Carbon\Carbon::parse($borrow->tanggal_kembali);
            $tanggalPengembalian = \Carbon\Carbon::today(); // Use today() instead of now() to get date without time

            // Cek apakah benar-benar terlambat (tanggal pengembalian > tanggal tempo)
            if ($tanggalPengembalian->gt($tanggalKembali)) {
                $hariTerlambat = (int) $tanggalKembali->diffInDays($tanggalPengembalian); // Cast to int for whole days
                $denda = $hariTerlambat * 2000;
            }
        }

        // Update stock buku
        $borrow->bookItem->update(['status' => 'available']);

        $return = ReturnBook::create([
            'borrows_id' => $borrow->id,
            'tanggal_pengembalian' => now(),
            'status' => $request->status,
            'denda' => $denda,
        ]);

        return redirect()->route('pengembalian.index')->with('success', 'Pengembalian buku berhasil ditambahkan. Denda: Rp ' . number_format($denda, 0, ',', '.'));
    }
}
