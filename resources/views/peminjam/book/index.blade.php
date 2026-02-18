@extends('layouts.peminjam')

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="card mb-4 border-0 text-white" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
        <div class="card-body">
            <h5 class="mb-1">Temukan Buku Favoritmu!</h5>
            <p class="mb-3" style="font-size:14px">
                Jelajahi ribuan koleksi buku dari berbagai kategori, baca, pinjam dan kembangkan wawasanmu
            </p>

            <form method="GET" action="{{ route('peminjam.book.list') }}">
                <div class="form-row">
                    <div class="col-md-7 mb-2">
                        <input type="text" name="search" class="form-control"
                               placeholder="Cari judul buku, buku, atau penulis..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3 mb-2">
                        <select name="category_id" class="form-control">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-2">
                        <button type="submit" class="btn btn-block" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); color: white; font-weight: 500; border: none;">
                            <i class="fa fa-search"></i> Cari
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Koleksi Terbaru --}}
    <h6 class="font-weight-bold mb-1" style="color: black; font-size:24px;">Koleksi Terbaru</h6>
    <p class="text-muted mb-4" style="font-size:14px">
        Buku-buku yang baru saja ditambahkan
    </p>

    <div class="row">

        @forelse($books as $book)
        {{-- Card Buku --}}
        <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-sm border-0 position-relative rounded">

                {{-- badge status --}}
                @if($book->stock > 0)
                    <span class="badge badge-success position-absolute"
                          style="top:10px; right:10px; z-index:2;">
                        Tersedia
                    </span>
                @else
                    <span class="badge badge-danger position-absolute"
                          style="top:10px; right:10px; z-index:2;">
                        Habis
                    </span>
                @endif

                {{-- image --}}
                <div class="position-relative overflow-hidden"
                     onmouseover="this.children[1].style.opacity=1; this.children[0].style.transform='scale(1.15)'"
                     onmouseout="this.children[1].style.opacity=0; this.children[0].style.transform='scale(1)'">

                    <img src="{{ $book->foto_url }}"
                         class="card-img-top"
                         style="height:140px; object-fit:cover; transition:.4s;"
                         alt="{{ $book->judul }}">

                    {{-- overlay --}}
                    <div class="position-absolute w-100 h-100 d-flex justify-content-center align-items-center"
                         style="top:0; background:rgba(0,0,0,.55); opacity:0; transition:.3s;">
                        <a href="{{ route('peminjam.book.show', $book->id) }}"
                           class="btn btn-light btn-sm rounded-pill d-flex align-items-center px-3">
                            <i class="fa fa-eye mr-2"></i>
                            Detail
                        </a>
                    </div>
                </div>

                {{-- body --}}
                <div class="card-body py-3 px-3">
                    <span class="badge badge-light text-primary mb-2" style="font-size: 11px;">
                        {{ $book->category->name ?? 'Tanpa Kategori' }}
                    </span>

                    <h6 class="font-weight-bold mb-1" style="color: black; font-size: 15px;">
                        {{ Str::limit($book->judul, 30) }}
                    </h6>
                    <p class="text-muted small mb-2" style="font-size: 12px;">
                        <i class="fas fa-user mr-1"></i> {{ Str::limit($book->penulis, 25) }}
                    </p>
                    <hr class="my-2">

                    <small class="text-muted" style="font-size: 12px;">
                        <i class="fas fa-box mr-1"></i> {{ $book->stock }} Stok
                    </small>
                </div>

            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle fa-3x mb-3"></i>
                <h5>Tidak ada buku ditemukan</h5>
                <p class="mb-0">Coba cari dengan kata kunci lain atau pilih kategori berbeda</p>
            </div>
        </div>
        @endforelse

    </div>

</div>
@endsection
