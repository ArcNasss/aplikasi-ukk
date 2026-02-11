<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

/**
 * Controller untuk halaman peminjam - menampilkan katalog buku
 */
class PeminjamBookController extends Controller
{
    /**
     * Tampilkan daftar buku untuk peminjam (katalog)
     */
    public function index(Request $request)
    {
        $query = Book::with('category')
                     ->withCount(['bookItems as stock' => function($q) {
                         $q->where('status', 'available');
                     }]);

        // Search: judul buku, penulis, penerbit
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('penulis', 'like', '%' . $search . '%')
                  ->orWhere('penerbit', 'like', '%' . $search . '%');
            });
        }

        // Filter: kategori
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        $books = $query->orderBy('created_at', 'desc')->get();
        $categories = Category::all();

        return view('peminjam.book.index', compact('books', 'categories'));
    }

    /**
     * Tampilkan detail buku
     */
    public function show($id)
    {
        $book = Book::with(['category', 'bookItems'])
                    ->withCount(['bookItems as stock' => function($q) {
                        $q->where('status', 'available');
                    }])
                    ->findOrFail($id);

        return view('peminjam.book.show', compact('book'));
    }
}
