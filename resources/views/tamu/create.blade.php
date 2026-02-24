@extends('layouts.peminjam')

@section('title', 'Create buku tamu')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Buku Tamu</h5>
                </div>
                <div class="card-body p-0">
                    <div class="border rounded mx-3 my-3">
                        <!-- Form Header -->
                        <div class="px-3 py-2" style="background-color: #e8f0fe; border-bottom: 1px solid #dee2e6;">
                            <span class="text-primary fw-semibold">Form Tambah Anggota</span>
                        </div>

                        <!-- Form Body -->
                        <div class="p-4">
                            <form action="{{ route('guestbook.store') }}" method="POST">
                                @csrf

                                <div class="row mb-3 align-items-center">
                                    <label for="nama" class="col-sm-2 col-form-label fw-semibold">Nama</label>
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control @error('name') is-invalid @enderror"
                                            id="name"
                                            name="name"
                                            placeholder="Masukkan Nama Anggota"
                                        >
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4 align-items-center">
                                    <label for="keperluan" class="col-sm-2 col-form-label fw-semibold">Keperluan</label>
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control @error('needs') is-invalid @enderror"
                                            id="needs"
                                            name="needs"
                                            placeholder="Masukkan Keperluan"
                                        >
                                        @error('needs')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Buttons -->
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="" class="btn btn-outline-secondary px-4">
                                        batal
                                    </a>
                                    <button type="submit" class="btn btn-primary px-4">
                                        Tambah
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
