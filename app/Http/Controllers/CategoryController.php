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
     * Tampilkan form tambah kategori
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Simpan kategori baru ke database
     * Validasi: name (required, unique)
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ], [
            // Custom error messages
            'name.required' => 'Nama kategori wajib diisi',
            'name.max' => 'Nama kategori maksimal 255 karakter',
            'name.unique' => 'Nama kategori sudah ada, gunakan nama lain',
        ]);

        try {
            // Simpan kategori baru
            Category::create([
                'name' => $validated['name'],
            ]);

            // Redirect dengan pesan sukses
            return redirect()->route('category.list')
                ->with('success', 'Kategori berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Hapus kategori berdasarkan ID
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
    }
}
