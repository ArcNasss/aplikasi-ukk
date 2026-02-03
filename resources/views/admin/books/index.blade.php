@extends('layouts.app')

@section('title', 'Kelola Buku')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 text-gray-800 mb-0">Kelola Buku</h1>
        <small class="text-muted">Manajemen data buku perpustakaan</small>
    </div>
    <div>
        <a href="#" class="btn btn-success btn-sm mr-2">
            <i class="fas fa-file-excel mr-1"></i> Export Excel
        </a>
        <a href="#" class="btn btn-primary btn-sm">
            <i class="fas fa-plus mr-1"></i> Tambah Buku
        </a>
    </div>
</div>

<!-- Search & Filter -->
<div class="card shadow mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('book.list') }}">
            <div class="row align-items-center">

                <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                        </div>
                        <input type="text" name="search" class="form-control"
                               placeholder="Cari judul buku / penulis / penerbit..." value="{{ request('search') }}">
                    </div>
                </div>

                <div class="col-md-3">
                    <select name="category_id" class="form-control form-control-sm">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary btn-sm btn-block">
                        <i class="fas fa-search mr-1"></i> Cari
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

<!-- Table -->
<div class="card shadow">
    <div class="card-body p-0">
        <div class="table-responsive">

            <table class="table table-hover table-bordered mb-0">
                <thead class="bg-primary text-white">
                <tr>
                    <th style="width:60px" class="text-center">No.</th>
                    <th style="width:90px">Cover</th>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>Kategori</th>
                    <th class="text-center">Stok</th>
                    <th>Status</th>
                    <th style="width:120px" class="text-center">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @forelse($books as $index => $book)
                <tr>
                    <td class="text-center">{{ $books->firstItem() + $index }}</td>
                    <td>
                        <img src="https://via.placeholder.com/60x80" class="img-thumbnail" alt="cover">
                    </td>
                    <td class="font-weight-bold">{{ $book->title }}</td>
                    <td>{{ $book->writer ?? '-' }}</td>
                    <td>
                        @php
                            $badgeColor = 'info';
                            if($book->category) {
                                $categoryName = strtolower($book->category->name);
                                if(str_contains($categoryName, 'ipa') || str_contains($categoryName, 'sains')) {
                                    $badgeColor = 'primary';
                                } elseif(str_contains($categoryName, 'sejarah')) {
                                    $badgeColor = 'warning';
                                } elseif(str_contains($categoryName, 'novel') || str_contains($categoryName, 'fiksi')) {
                                    $badgeColor = 'info';
                                } else {
                                    $badgeColor = 'secondary';
                                }
                            }
                        @endphp
                        <span class="badge badge-{{ $badgeColor }} px-3 py-2">{{ $book->category->name ?? 'Tidak ada kategori' }}</span>
                    </td>
                    <td class="text-center">{{ $book->stock }}</td>
                    <td>
                        @if($book->stock > 0)
                            <span class="badge badge-success px-3 py-2">Tersedia</span>
                        @else
                            <span class="badge badge-danger px-3 py-2">Habis</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <button class="btn btn-warning btn-sm action-edit" disabled>
                            <i class="fas fa-edit"></i>
                        </button>
                        <form action="{{ route('book.delete', $book->id) }}" method="POST" style="display:inline;" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm action-delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-4">
                        <i class="fas fa-book fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Tidak ada buku ditemukan</p>
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($books->hasPages())
        <div class="d-flex justify-content-between align-items-center p-3">
            <small class="text-muted">Menampilkan {{ $books->firstItem() ?? 0 }} - {{ $books->lastItem() ?? 0 }} dari {{ $books->total() }} data</small>
            <div>
                {{ $books->links('pagination::bootstrap-4') }}
            </div>
        </div>
        @else
        <div class="p-3">
            <small class="text-muted">Menampilkan {{ $books->count() }} dari {{ $books->total() }} data</small>
        </div>
        @endif

    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {

    // Delete confirmation
    $('.delete-form').on('submit', function(e) {
        e.preventDefault();

        if (confirm("Yakin mau hapus buku ini?")) {
            this.submit();
        }
    });

    // Auto hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);

});
</script>
@endpush


