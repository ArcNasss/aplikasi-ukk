<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookItem;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Tampilkan daftar buku dengan search & filter kategori
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
            'tahun' => 'required|integer',
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
     * Tampilkan form edit buku
     */
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $categories = Category::orderBy('name', 'asc')->get();
        return view('admin.books.edit', compact('book', 'categories'));
    }

    /**
     * Update buku di database
     */
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

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
            'judul.required' => 'Judul buku wajib diisi',
            'category_id.required' => 'Kategori wajib dipilih',
            'category_id.exists' => 'Kategori tidak valid',
            'penulis.required' => 'Nama penulis wajib diisi',
            'penerbit.required' => 'Nama penerbit wajib diisi',
            'tahun.required' => 'Tahun terbit wajib diisi',
            'tahun.integer' => 'Tahun harus berupa angka',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Format gambar harus JPG, JPEG, atau PNG',
            'foto.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        try {
            // Handle upload foto jika ada
            $fotoPath = $book->foto;
            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada
                if ($book->foto && Storage::disk('public')->exists($book->foto)) {
                    Storage::disk('public')->delete($book->foto);
                }

                $file = $request->file('foto');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $fotoPath = $file->storeAs('books', $fileName, 'public');
            }

            // Update data
            $book->update([
                'category_id' => $validated['category_id'],
                'judul' => $validated['judul'],
                'synopsis' => $validated['synopsis'],
                'foto' => $fotoPath,
                'penulis' => $validated['penulis'],
                'penerbit' => $validated['penerbit'],
                'tahun' => $validated['tahun'],
            ]);

            return redirect()->route('book.list')
                ->with('success', 'Buku berhasil diupdate!');

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

        // Hapus foto jika ada
        if ($book->foto && Storage::disk('public')->exists($book->foto)) {
            Storage::disk('public')->delete($book->foto);
        }

        $book->delete();

        return back()->with('success', 'Buku berhasil dihapus!');
    }

    /**
     * Tampilkan form tambah kode buku (book item)
     */
    public function addItem($id)
    {
        $book = Book::with('bookItems')->findOrFail($id);
        return view('admin.books.add_item', compact('book'));
    }

    /**
     * Simpan kode buku baru (book item)
     * Setiap kode buku yang ditambahkan akan menambah stok otomatis
     */
    public function storeItem(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'kode_buku' => 'required|string|max:255|unique:book_items,kode_buku',
            'status' => 'required|in:available,borrowed,damaged,lost',
        ], [
            'kode_buku.required' => 'Kode buku wajib diisi',
            'kode_buku.unique' => 'Kode buku sudah digunakan',
            'status.required' => 'Status wajib dipilih',
            'status.in' => 'Status tidak valid',
        ]);

        try {
            // Simpan book item
            BookItem::create([
                'book_id' => $book->id,
                'kode_buku' => $validated['kode_buku'],
                'status' => $validated['status'],
            ]);

            return redirect()->route('book.addItem', $book->id)
                ->with('success', 'Kode buku berhasil ditambahkan! Stok bertambah.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
