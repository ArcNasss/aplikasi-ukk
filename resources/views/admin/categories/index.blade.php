@extends('layouts.admin')

@section('title', 'Kategori Buku')

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

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 text-gray-800 mb-0">Kategori Buku</h1>
        <small class="text-muted">Manajemen kategori buku perpustakaan</small>
    </div>
    <a href="{{ route('category.create') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus mr-1"></i> Tambah Kategori
    </a>
</div>

<!-- SEARCH -->
<div class="card shadow-sm mb-3">
    <div class="card-body py-2">
        <form method="GET" action="{{ route('category.list') }}">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-white">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                </div>
                <input type="text" name="search" class="form-control" placeholder="Cari kategori..." value="{{ request('search') }}">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- TOTAL BAR -->
<div class="card shadow-sm mb-4">
    <div class="card-body bg-primary text-white py-3">
        <div class="d-flex align-items-center">
            <div class="bg-white text-primary rounded p-2 mr-3">
                <i class="fas fa-layer-group"></i>
            </div>
            <div>
                <div class="small text-uppercase">Total Kategori</div>
                <div class="h4 mb-0 font-weight-bold">{{ $categories->total() }}</div>
            </div>
        </div>
    </div>
</div>

<!-- GRID -->
<div class="row" id="categoryGrid">

    @forelse($categories as $category)
    <!-- CARD -->
    <div class="col-xl-3 col-lg-4 col-md-6 mb-3 category-card">
        <div class="card shadow-sm h-100">
            <div class="card-body p-3">

                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="bg-primary text-white rounded p-2">
                        <i class="fas fa-book"></i>
                    </div>

                    <!-- DROPDOWN TITIK TIGA -->
                    <div class="dropdown">
                        <button class="btn btn-link text-dark p-0" data-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right shadow-sm">
                            <a href="{{ route('category.edit', $category->id) }}" class="dropdown-item">
                                <i class="fas fa-edit text-warning mr-2"></i> Edit
                            </a>
                            <form action="{{ route('category.delete', $category->id) }}" method="POST" style="display:inline;" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item action-delete">
                                    <i class="fas fa-trash text-danger mr-2"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <span class="badge badge-light text-primary mb-1">Kategori</span>
                <h6 class="font-weight-bold mb-1">{{ $category->name }}</h6>

                <small class="text-muted d-block mb-2">
                    Total Buku: <b>{{ $category->books_count }}</b> Buku
                </small>

                <small class="text-muted">Dibuat: {{ $category->created_at->format('d/m/Y') }}</small>

            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-layer-group fa-3x text-muted mb-3"></i>
                <p class="text-muted mb-0">Tidak ada kategori ditemukan</p>
            </div>
        </div>
    </div>
    @endforelse

</div>

<!-- PAGINATION -->
@if($categories->hasPages())
<div class="d-flex justify-content-between align-items-center mt-3">
    <small class="text-muted">Menampilkan {{ $categories->firstItem() ?? 0 }} - {{ $categories->lastItem() ?? 0 }} dari {{ $categories->total() }} data</small>
    <div>
        {{ $categories->links('pagination::bootstrap-4') }}
    </div>
</div>
@else
<div class="mt-3">
    <small class="text-muted">Menampilkan {{ $categories->count() }} dari {{ $categories->total() }} data</small>
</div>
@endif

@endsection




