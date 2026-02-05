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
     * Tampilkan form tambah buku
     */
    public function create()
    {
        // Ambil semua kategori untuk dropdown
        $categories = Category::orderBy('name', 'asc')->get();
        return view('admin.books.create', compact('categories'));
    }

    /**
     * Simpan buku baru ke database
     * Validasi: judul, kategori, penulis, penerbit, tahun, foto (optional)
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'synopsis' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ], [
            // Custom error messages
            'judul.required' => 'Judul buku wajib diisi',
            'category_id.required' => 'Kategori wajib dipilih',
            'category_id.exists' => 'Kategori tidak valid',
            'penulis.required' => 'Nama penulis wajib diisi',
            'penerbit.required' => 'Nama penerbit wajib diisi',
            'tahun.required' => 'Tahun terbit wajib diisi',
            'tahun.integer' => 'Tahun harus berupa angka',
            'tahun.min' => 'Tahun tidak valid (minimal 1900)',
            'tahun.max' => 'Tahun tidak valid',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Format gambar harus JPG, JPEG, atau PNG',
            'foto.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        try {
            // Handle upload foto jika ada
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $fotoPath = $file->storeAs('books', $fileName, 'public');
            }

            // Simpan ke database
            Book::create([
                'category_id' => $validated['category_id'],
                'judul' => $validated['judul'],
                'synopsis' => $validated['synopsis'],
                'foto' => $fotoPath,
                'penulis' => $validated['penulis'],
                'penerbit' => $validated['penerbit'],
                'tahun' => $validated['tahun'],
            ]);

            // Redirect dengan pesan sukses
            return redirect()->route('book.list')
                ->with('success', 'Buku berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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
