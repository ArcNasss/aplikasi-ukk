<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function listBooks(Request $request)
    {
        $query = Book::with('category');
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('title', 'like', '%' . $search . '%');
        }

        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        $books = $query->orderBy('created_at', 'desc')->paginate(10);
        $categories = Category::all();

        return view('admin.books.index', compact('books', 'categories'));
    }

    public function deleteBook($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return back()->with('success', 'Buku berhasil dihapus!');
    }
}
