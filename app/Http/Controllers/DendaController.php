<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\ReturnBook;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class DendaController extends Controller
{
    // Petugas: View all denda
    public function index()
    {
        // Ambil data dari:
        // 1. Peminjaman yang sudah lewat tempo (status disetujui dan tanggal_kembali < hari ini)
        // 2. Pengembalian yang status terlambat, hilang, atau rusak

        $dendaFromBorrows = Borrow::with(['user', 'bookItem.book'])
            ->where('status', 'disetujui')
            ->whereDate('tanggal_kembali', '<', Carbon::today())
            ->whereNotIn('id', function($query) {
                $query->select('borrows_id')->from('return_books');
            })
            ->get()
            ->map(function($borrow) {
                $hariTerlambat = Carbon::today()->diffInDays($borrow->tanggal_kembali);
                $denda = $hariTerlambat * 2000;

                return [
                    'type' => 'borrow',
                    'id' => $borrow->id,
                    'user_name' => $borrow->user->name,
                    'user_nomor_identitas' => $borrow->user->nomor_identitas,
                    'book_title' => $borrow->bookItem->book->judul ?? '-',
                    'book_code' => $borrow->bookItem->kode_buku ?? '-',
                    'tanggal_pinjam' => $borrow->tanggal_pinjam,
                    'tanggal_kembali' => $borrow->tanggal_kembali,
                    'tanggal_pengembalian' => null,
                    'status' => 'terlambat',
                    'hari_terlambat' => $hariTerlambat,
                    'denda' => $denda,
                    'is_paid' => false
                ];
            });

        $dendaFromReturns = ReturnBook::with(['borrow.user', 'borrow.bookItem.book'])
            ->whereIn('status', ['terlambat', 'hilang', 'rusak'])
            ->where('denda', '>', 0)
            ->get()
            ->map(function($return) {
                $hariTerlambat = null;
                if ($return->status == 'terlambat') {
                    $hariTerlambat = Carbon::parse($return->tanggal_pengembalian)
                        ->diffInDays($return->borrow->tanggal_kembali);
                }

                return [
                    'type' => 'return',
                    'id' => $return->id,
                    'user_name' => $return->borrow->user->name ?? '-',
                    'user_nomor_identitas' => $return->borrow->user->nomor_identitas ?? '-',
                    'book_title' => $return->borrow->bookItem->book->judul ?? '-',
                    'book_code' => $return->borrow->bookItem->kode_buku ?? '-',
                    'tanggal_pinjam' => $return->borrow->tanggal_pinjam,
                    'tanggal_kembali' => $return->borrow->tanggal_kembali,
                    'tanggal_pengembalian' => $return->tanggal_pengembalian,
                    'status' => $return->status,
                    'hari_terlambat' => $hariTerlambat,
                    'denda' => $return->denda,
                    'is_paid' => $return->is_paid ?? false
                ];
            });

        // Gabungkan kedua collection
        $dendas = $dendaFromBorrows->concat($dendaFromReturns)
            ->sortByDesc('denda');

        return view('petugas.denda.index', compact('dendas'));
    }

    // Mark denda as paid
    public function markAsPaid($id)
    {
        $return = ReturnBook::findOrFail($id);
        $return->update(['is_paid' => true]);

        return redirect()->back()->with('success', 'Denda berhasil ditandai sebagai sudah dibayar.');
    }

    // Admin: View all denda (read only)
    public function adminIndex()
    {
        $dendaFromBorrows = Borrow::with(['user', 'bookItem.book'])
            ->where('status', 'disetujui')
            ->whereDate('tanggal_kembali', '<', Carbon::today())
            ->whereNotIn('id', function($query) {
                $query->select('borrows_id')->from('return_books');
            })
            ->get()
            ->map(function($borrow) {
                $hariTerlambat = Carbon::today()->diffInDays($borrow->tanggal_kembali);
                $denda = $hariTerlambat * 2000;

                return [
                    'type' => 'borrow',
                    'id' => $borrow->id,
                    'user_name' => $borrow->user->name,
                    'user_nomor_identitas' => $borrow->user->nomor_identitas,
                    'book_title' => $borrow->bookItem->book->judul ?? '-',
                    'book_code' => $borrow->bookItem->kode_buku ?? '-',
                    'tanggal_pinjam' => $borrow->tanggal_pinjam,
                    'tanggal_kembali' => $borrow->tanggal_kembali,
                    'tanggal_pengembalian' => null,
                    'status' => 'terlambat',
                    'hari_terlambat' => $hariTerlambat,
                    'denda' => $denda,
                    'is_paid' => false
                ];
            });

        $dendaFromReturns = ReturnBook::with(['borrow.user', 'borrow.bookItem.book'])
            ->whereIn('status', ['terlambat', 'hilang', 'rusak'])
            ->where('denda', '>', 0)
            ->get()
            ->map(function($return) {
                $hariTerlambat = null;
                if ($return->status == 'terlambat') {
                    $hariTerlambat = Carbon::parse($return->tanggal_pengembalian)
                        ->diffInDays($return->borrow->tanggal_kembali);
                }

                return [
                    'type' => 'return',
                    'id' => $return->id,
                    'user_name' => $return->borrow->user->name ?? '-',
                    'user_nomor_identitas' => $return->borrow->user->nomor_identitas ?? '-',
                    'book_title' => $return->borrow->bookItem->book->judul ?? '-',
                    'book_code' => $return->borrow->bookItem->kode_buku ?? '-',
                    'tanggal_pinjam' => $return->borrow->tanggal_pinjam,
                    'tanggal_kembali' => $return->borrow->tanggal_kembali,
                    'tanggal_pengembalian' => $return->tanggal_pengembalian,
                    'status' => $return->status,
                    'hari_terlambat' => $hariTerlambat,
                    'denda' => $return->denda,
                    'is_paid' => $return->is_paid ?? false
                ];
            });

        $dendas = $dendaFromBorrows->concat($dendaFromReturns)
            ->sortByDesc('denda');

        return view('admin.denda.index', compact('dendas'));
    }

    // Download invoice for specific user
    public function downloadInvoice($userId)
    {
        $user = User::findOrFail($userId);

        // Ambil semua denda untuk user ini
        $dendaItems = [];

        // Dari peminjaman yang terlambat
        $borrowDendas = Borrow::with(['bookItem.book'])
            ->where('user_id', $userId)
            ->where('status', 'disetujui')
            ->whereDate('tanggal_kembali', '<', Carbon::today())
            ->whereNotIn('id', function($query) {
                $query->select('borrows_id')->from('return_books');
            })
            ->get()
            ->map(function($borrow) {
                $hariTerlambat = Carbon::today()->diffInDays($borrow->tanggal_kembali);
                $denda = $hariTerlambat * 2000;

                return [
                    'book_title' => $borrow->bookItem->book->judul ?? '-',
                    'status' => 'terlambat',
                    'hari_terlambat' => $hariTerlambat,
                    'denda' => $denda,
                ];
            });

        // Dari pengembalian dengan denda
        $returnDendas = ReturnBook::with(['borrow.bookItem.book'])
            ->whereHas('borrow', function($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->whereIn('status', ['terlambat', 'hilang', 'rusak'])
            ->where('denda', '>', 0)
            ->get()
            ->map(function($return) {
                $hariTerlambat = null;
                if ($return->status == 'terlambat') {
                    $hariTerlambat = Carbon::parse($return->tanggal_pengembalian)
                        ->diffInDays($return->borrow->tanggal_kembali);
                }

                return [
                    'book_title' => $return->borrow->bookItem->book->judul ?? '-',
                    'status' => $return->status,
                    'hari_terlambat' => $hariTerlambat,
                    'denda' => $return->denda,
                ];
            });

        $dendaItems = $borrowDendas->concat($returnDendas)->toArray();

        if (empty($dendaItems)) {
            return redirect()->back()->with('error', 'Tidak ada denda untuk user ini.');
        }

        // Generate invoice number
        $invoiceNumber = 'INV-' . strtoupper(uniqid());

        // Generate PDF
        $pdf = Pdf::loadView('invoice.denda', [
            'user' => $user,
            'dendaItems' => $dendaItems,
            'invoiceNumber' => $invoiceNumber
        ]);

        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('invoice-denda-' . $user->name . '-' . date('Y-m-d') . '.pdf');
    }
}
