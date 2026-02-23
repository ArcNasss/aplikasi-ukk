@extends('layouts.admin')

@section('title', 'Tambah Buku')

@section('content')
<div class="container-fluid">

    <h5 class="mb-4 text-secondary">Tambah Buku</h5>

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- Alert Error --}}
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

    <div class="card shadow-sm">
        <!-- HEADER CARD -->
        <div class="card-header bg-light">
            <strong class="text-primary">Form Tambah Buku</strong>
        </div>

        <!-- BODY -->
        <div class="card-body">
            <form action="{{ route('book.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- ROW 1 -->
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Judul Buku <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                               placeholder="Masukkan Judul Buku" value="{{ old('judul') }}" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>Kategori <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>Penulis <span class="text-danger">*</span></label>
                        <input type="text" name="penulis" class="form-control @error('penulis') is-invalid @enderror"
                               placeholder="Nama Penulis" value="{{ old('penulis') }}" required>
                        @error('penulis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- ROW 2 -->
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Penerbit <span class="text-danger">*</span></label>
                        <input type="text" name="penerbit" class="form-control @error('penerbit') is-invalid @enderror"
                               placeholder="Nama Penerbit" value="{{ old('penerbit') }}" required>
                        @error('penerbit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>Tahun Terbit <span class="text-danger">*</span></label>
                        <input type="number" name="tahun" class="form-control @error('tahun') is-invalid @enderror"
                               placeholder="2024" value="{{ old('tahun') }}" min="1900" max="{{ date('Y') + 1 }}" required>
                        @error('tahun')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>Foto Cover Buku</label>
                        <div class="custom-file">
                            <input type="file" name="foto"
                                   class="custom-file-input @error('foto') is-invalid @enderror" id="cover"
                                   accept="image/*">
                            <label class="custom-file-label" for="cover">
                                Choose file
                            </label>
                        </div>
                        @error('foto')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            Format: JPG, JPEG, PNG, Maksimal 2MB
                        </small>
                    </div>
                </div>

                <!-- SINOPSIS -->
                <div class="form-group">
                    <label>Sinopsis</label>
                    <textarea name="synopsis" rows="4" class="form-control @error('synopsis') is-invalid @enderror"
                              placeholder="Masukkan sinopsis atau deskripsi buku (opsional)">{{ old('synopsis') }}</textarea>
                    @error('synopsis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- BUTTON -->
                <div class="text-right mt-4">
                    <a href="{{ route('book.list') }}" class="btn btn-secondary px-4 mr-2">
                        <i class="fas fa-times mr-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save mr-1"></i> Tambah
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Custom file input label update
    $('.custom-file-input').on('change', function () {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    // Auto hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
</script>
@endpush
