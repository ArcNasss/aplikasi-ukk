<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;
use App\Models\Category;
use App\Models\Borrow;
use App\Models\ReturnBook;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard dengan statistik
     */
    public function index()
    {
        $totalBooks = Book::count();
        $totalUsers = User::where('role', 'peminjam')->count();
        $totalCategories = Category::count();

        // Ambil data dari database
        $totalBorrowed = Borrow::whereIn('status', ['pending', 'disetujui'])->count();
        $totalReturned = ReturnBook::count();

        // Data untuk Line Chart - Statistik peminjaman per bulan (tahun ini)
        $currentYear = date('Y');
        $monthlyBorrowings = [];
        for ($month = 1; $month <= 12; $month++) {
            $count = Borrow::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->count();
            $monthlyBorrowings[] = $count;
        }

        // Data untuk Donut Chart - Riwayat Aktivitas
        $totalPeminjaman = Borrow::count();
        $totalPengembalian = ReturnBook::whereIn('status', ['dikembalikan', 'terlambat', 'rusak'])->count();
        $totalBukuHilang = ReturnBook::where('status', 'hilang')->count();

        return view('admin.dashboard', compact(
            'totalBooks',
            'totalUsers',
            'totalCategories',
            'totalBorrowed',
            'totalReturned',
            'monthlyBorrowings',
            'totalPeminjaman',
            'totalPengembalian',
            'totalBukuHilang'
        ));
    }


    public function petugasDashboard()
    {
        // Stats untuk dashboard petugas
        $jumlahKeterlambatan = ReturnBook::where('status', 'terlambat')->count();
        $jumlahBukuHilang = ReturnBook::where('status', 'hilang')->count();
        $jumlahDendaDiberikan = ReturnBook::where('denda', '>', 0)->count();
        $totalDenda = ReturnBook::sum('denda');

        // Data untuk Line Chart - Statistik peminjaman per bulan (tahun ini)
        $currentYear = date('Y');
        $monthlyBorrowings = [];
        for ($month = 1; $month <= 12; $month++) {
            $count = Borrow::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->count();
            $monthlyBorrowings[] = $count;
        }

        // Data untuk Donut Chart - Riwayat Aktivitas
        $totalPeminjaman = Borrow::count();
        $totalPengembalian = ReturnBook::whereIn('status', ['dikembalikan', 'terlambat', 'rusak'])->count();
        $totalBukuHilang = ReturnBook::where('status', 'hilang')->count();

        return view('petugas.dashboard', compact(
            'jumlahKeterlambatan',
            'jumlahBukuHilang',
            'jumlahDendaDiberikan',
            'totalDenda',
            'monthlyBorrowings',
            'totalPeminjaman',
            'totalPengembalian',
            'totalBukuHilang'
        ));
    }
}
