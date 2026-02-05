@extends('layouts.app')

@section('title', 'Tambah Kategori Buku')

@section('content')
<div class="container-fluid">

    <!-- JUDUL HALAMAN -->
    <h5 class="mb-3 text-muted">Tambah Kategori Buku</h5>

    <!-- CARD -->
    <div class="card shadow-sm" style="max-width: 1000px;">
        <!-- HEADER -->
        <div class="card-header py-2" style="background-color:#eef6ff;">
            <span class="font-weight-bold text-primary">Form Tambah Kategori</span>
        </div>

        <!-- BODY -->
        <div class="card-body px-4 py-4">
            <form action="{{ route('category.store') }}" method="POST">
                @csrf

                <!-- FORM ROW -->
                <div class="form-group row align-items-center">
                    <label class="col-md-3 col-form-label">
                        Nama Kategori <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-9">
                        <input type="text"
                               name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="Masukkan Nama Kategori"
                               value="{{ old('name') }}"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle"></i> Nama kategori harus unik
                        </small>
                    </div>
                </div>

                <!-- BUTTON -->
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('category.list') }}"
                       class="btn btn-secondary px-4 mr-2">
                        <i class="fas fa-times mr-1"></i> Batal
                    </a>
                    <button type="submit"
                            class="btn btn-primary px-4">
                        <i class="fas fa-save mr-1"></i> Tambah
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
