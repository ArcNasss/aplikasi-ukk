<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Tampilkan daftar buku dengan search & filter kategori
     */
    public function index(Request $request)
    {
        $query = Book::with('category');

        // Search: judul buku
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('title', 'like', '%' . $search . '%');
        }

        // Filter: kategori
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        $books = $query->orderBy('created_at', 'desc')->paginate(10);
        $categories = Category::all();

        return view('admin.books.index', compact('books', 'categories'));
    }

    /**
     * Hapus buku berdasarkan ID
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return back()->with('success', 'Buku berhasil dihapus!');
    }
}
