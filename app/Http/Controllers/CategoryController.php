<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Tampilkan daftar kategori dengan jumlah buku & search
     */
    public function index(Request $request)
    {
        $query = Category::withCount('books');

        // Search: nama kategori
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', '%' . $search . '%');
        }

        $categories = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Hapus kategori berdasarkan ID
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
    }
}
