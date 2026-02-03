<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;
use App\Models\Category;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard dengan statistik
     */
    public function index()
    {
        $totalBooks = Book::count();
        $totalUsers = User::count();
        $totalCategories = Category::count();

        // TODO: akan diisi dari model Borrowing (sekarang belum ada)
        $totalBorrowed = 0;
        $totalReturned = 0;

        return view('admin.dashboard', compact(
            'totalBooks',
            'totalUsers',
            'totalCategories',
            'totalBorrowed',
            'totalReturned'
        ));
    }
}
