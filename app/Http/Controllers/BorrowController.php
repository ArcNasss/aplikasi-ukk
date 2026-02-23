<?php

namespace App\Http\Controllers;

use App\Models\BookItem;
use Illuminate\Http\Request;
use App\Models\Borrow;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\BorrowReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class BorrowController extends Controller
{
    // Admin: View all borrowings (all statuses) - read only
    public function adminIndex(){
        $borrows = Borrow::with(['user', 'bookItem.book', 'petugas'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.peminjaman.index', compact('borrows'));
    }

    public function index(){
        $borrows = Borrow::with(['user', 'bookItem.book', 'petugas'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

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
            'user_id' => Auth::id(),
            'book_item_id' => $existBookItem->id,
            'tanggal_pinjam' => null,
            'tanggal_kembali' => null,
            'status' => 'pending',
        ]);

        return redirect()->route('peminjam.history')->with('success', 'Permintaan peminjaman berhasil dikirim.');
    }

    // setujui peminjaman
    public function approve($id) {
        $borrow = Borrow::with('bookItem')->findOrfail($id);

        if($borrow){
            $borrow->update([
                'status' => 'disetujui',
                'tanggal_pinjam' => now(),
                'tanggal_kembali' => now()->addDays(7),
                'petugas_id' => Auth::id(),
            ]);

            // Update status book item menjadi borrowed agar tidak bisa dipinjam lagi
            if($borrow->bookItem) {
                $borrow->bookItem->update(['status' => 'borrowed']);
            }

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

    // Cetak kartu peminjaman
    public function printCard($id) {
        $borrow = Borrow::with(['user', 'bookItem.book', 'petugas'])->findOrFail($id);

        // Pastikan status disetujui
        if($borrow->status !== 'disetujui') {
            return redirect()->back()->with('error', 'Kartu peminjaman hanya bisa dicetak untuk peminjaman yang sudah disetujui.');
        }

        return view('petugas.peminjaman.print-card', compact('borrow'));
    }

    // Download kartu peminjaman sebagai PDF
    public function downloadCard($id) {
        $borrow = Borrow::with(['user', 'bookItem.book', 'petugas'])->findOrFail($id);

        // Pastikan status disetujui
        if($borrow->status !== 'disetujui') {
            return redirect()->back()->with('error', 'Kartu peminjaman hanya bisa didownload untuk peminjaman yang sudah disetujui.');
        }

        // Generate PDF
        $pdf = Pdf::loadView('petugas.peminjaman.card-pdf', compact('borrow'))
            ->setPaper('a4', 'landscape');

        $filename = 'Kartu-Peminjaman-' . str_pad($borrow->id, 6, '0', STR_PAD_LEFT) . '.pdf';

        return $pdf->download($filename);
    }

    // Export Excel - Petugas
    public function exportExcel(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();

        $filename = 'Laporan-Peminjaman-' . $startDate->format('Ymd') . '-' . $endDate->format('Ymd') . '.xlsx';

        return Excel::download(new BorrowReportExport($startDate, $endDate), $filename);
    }

    // Export Excel - Admin
    public function adminExportExcel(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();

        $filename = 'Laporan-Peminjaman-' . $startDate->format('Ymd') . '-' . $endDate->format('Ymd') . '.xlsx';

        return Excel::download(new BorrowReportExport($startDate, $endDate), $filename);
    }
}
