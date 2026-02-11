@extends('layouts.peminjam')

@section('content')
<div class="container-fluid">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent px-0">
            <li class="breadcrumb-item">
                <a href="{{ route('peminjam.book.list') }}">
                    <i class="fas fa-book mr-1"></i> Katalog Buku
                </a>
            </li>
            <li class="breadcrumb-item active">Detail Buku</li>
        </ol>
    </nav>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <!-- Book Cover & Action -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <!-- Book Cover -->
                    <img src="{{ $book->foto_url }}"
                         class="img-fluid rounded mb-3 shadow-sm"
                         alt="{{ $book->judul }}"
                         style="max-height: 400px; object-fit: cover;">

                    <!-- Stock Status -->
                    <div class="mb-3">
                        @if($book->stock > 0)
                            <span class="badge badge-success badge-lg px-4 py-2" style="font-size: 14px;">
                                <i class="fas fa-check-circle mr-1"></i> Tersedia - {{ $book->stock }} Stok
                            </span>
                        @else
                            <span class="badge badge-danger badge-lg px-4 py-2" style="font-size: 14px;">
                                <i class="fas fa-times-circle mr-1"></i> Tidak Tersedia
                            </span>
                        @endif
                    </div>

                    <!-- Action Button -->
                    @if($book->stock > 0)
                        <a href="#" class="btn btn-primary btn-block btn-lg mb-2">
                            <i class="fas fa-book-reader mr-2"></i> Pinjam Buku
                        </a>
                    @else
                        <button class="btn btn-secondary btn-block btn-lg mb-2" disabled>
                            <i class="fas fa-ban mr-2"></i> Tidak Tersedia
                        </button>
                    @endif

                    <a href="{{ route('peminjam.book.list') }}" class="btn btn-outline-secondary btn-block">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Katalog
                    </a>
                </div>
            </div>
        </div>

        <!-- Book Details -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body">
                    <!-- Category Badge -->
                    <span class="badge badge-primary px-3 py-2 mb-3" style="font-size: 13px;">
                        <i class="fas fa-tag mr-1"></i> {{ $book->category->name ?? 'Tanpa Kategori' }}
                    </span>

                    <!-- Title -->
                    <h2 class="font-weight-bold mb-3" style="color: #2c3e50;">
                        {{ $book->judul }}
                    </h2>

                    <!-- Meta Info -->
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-user text-primary mr-3 mt-1" style="font-size: 18px;"></i>
                                <div>
                                    <small class="text-muted d-block">Penulis</small>
                                    <strong>{{ $book->penulis }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-building text-primary mr-3 mt-1" style="font-size: 18px;"></i>
                                <div>
                                    <small class="text-muted d-block">Penerbit</small>
                                    <strong>{{ $book->penerbit }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-calendar text-primary mr-3 mt-1" style="font-size: 18px;"></i>
                                <div>
                                    <small class="text-muted d-block">Tahun Terbit</small>
                                    <strong>{{ $book->tahun }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-box text-primary mr-3 mt-1" style="font-size: 18px;"></i>
                                <div>
                                    <small class="text-muted d-block">Stok Tersedia</small>
                                    <strong>{{ $book->stock }} dari {{ $book->bookItems->count() }} Item</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Synopsis -->
                    <div class="mt-4">
                        <h5 class="font-weight-bold mb-3" style="color: #34495e;">
                            <i class="fas fa-file-alt mr-2"></i> Sinopsis
                        </h5>
                        @if($book->synopsis)
                            <p class="text-justify" style="line-height: 1.8; color: #555;">
                                {{ $book->synopsis }}
                            </p>
                        @else
                            <p class="text-muted font-italic">
                                <i class="fas fa-info-circle mr-1"></i> Sinopsis tidak tersedia untuk buku ini.
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Book Items List -->
            @if($book->bookItems->count() > 0)
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light">
                    <h6 class="mb-0 font-weight-bold">
                        <i class="fas fa-barcode mr-2"></i> Daftar Item Buku ({{ $book->bookItems->count() }} Item)
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="bg-light sticky-top">
                                <tr>
                                    <th style="width: 50px;" class="text-center">No.</th>
                                    <th>Kode Buku</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($book->bookItems as $index => $item)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td><code class="text-dark">{{ $item->kode_buku }}</code></td>
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
                </div>
            </div>
            @endif
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
});
</script>
@endpush
