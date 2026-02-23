@extends('layouts.admin')

@section('title', 'Tambah Kode Buku')

@section('content')
<div class="container-fluid">

    <!-- Alert Messages -->
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

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Back Button -->
    <div class="mb-3">
        <a href="{{ route('book.list') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar Buku
        </a>
    </div>

    <!-- Book Info Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <strong><i class="fas fa-book mr-2"></i>Informasi Buku</strong>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-2 text-center">
                    <img src="{{ $book->foto_url }}" class="img-thumbnail" alt="cover" style="width:120px; height:160px; object-fit:cover;">
                </div>
                <div class="col-md-10">
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td style="width:150px" class="font-weight-bold">Judul</td>
                            <td>: {{ $book->judul }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Penulis</td>
                            <td>: {{ $book->penulis }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Penerbit</td>
                            <td>: {{ $book->penerbit }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Kategori</td>
                            <td>: <span class="badge badge-info">{{ $book->category->name ?? '-' }}</span></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Stok Tersedia</td>
                            <td>: <span class="badge badge-success px-3 py-2">{{ $book->stock }} Item</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Form Add Item -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <strong><i class="fas fa-plus-circle mr-2"></i>Tambah Kode Buku</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('book.storeItem', $book->id) }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>Kode Buku <span class="text-danger">*</span></label>
                            <input type="text" name="kode_buku" 
                                   class="form-control @error('kode_buku') is-invalid @enderror"
                                   placeholder="Contoh: BK-001" 
                                   value="{{ old('kode_buku') }}" 
                                   required
                                   autofocus>
                            @error('kode_buku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i> Kode buku harus unik dan belum pernah digunakan
                            </small>
                        </div>

                        <div class="form-group">
                            <label>Status Item <span class="text-danger">*</span></label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                <option value="">Pilih Status</option>
                                <option value="available" {{ old('status') == 'available' ? 'selected' : '' }} selected>Tersedia (Available)</option>
                                <option value="borrowed" {{ old('status') == 'borrowed' ? 'selected' : '' }}>Sedang Dipinjam (Borrowed)</option>
                                <option value="damaged" {{ old('status') == 'damaged' ? 'selected' : '' }}>Rusak (Damaged)</option>
                                <option value="lost" {{ old('status') == 'lost' ? 'selected' : '' }}>Hilang (Lost)</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i> Status 'Tersedia' akan menambah stok buku
                            </small>
                        </div>

                        <div class="text-right mt-4">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-save mr-1"></i> Tambah Item
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <!-- List of Existing Items -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <strong><i class="fas fa-list mr-2"></i>Daftar Kode Buku ({{ $book->bookItems->count() }} Item)</strong>
                </div>
                <div class="card-body p-0">
                    @if($book->bookItems->count() > 0)
                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-sm table-hover table-striped mb-0">
                                <thead class="bg-light sticky-top">
                                    <tr>
                                        <th style="width:50px" class="text-center">No.</th>
                                        <th>Kode Buku</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($book->bookItems as $index => $item)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td><code>{{ $item->kode_buku }}</code></td>
                                        <td class="text-center">
                                            @if($item->status == 'available')
                                                <span class="badge badge-success">Tersedia</span>
                                            @elseif($item->status == 'borrowed')
                                                <span class="badge badge-warning">Dipinjam</span>
                                            @elseif($item->status == 'damaged')
                                                <span class="badge badge-danger">Rusak</span>
                                            @elseif($item->status == 'lost')
                                                <span class="badge badge-dark">Hilang</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada kode buku</p>
                            <small class="text-muted">Tambahkan kode buku untuk menambah stok</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Auto hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);

    // Auto focus on kode_buku input
    $('input[name="kode_buku"]').focus();
});
</script>
@endpush
