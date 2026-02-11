@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')

<div class="container-fluid">
    <h5 class="mb-4 text-secondary">Edit User</h5>

    <div class="card shadow-sm">
        <!-- HEADER CARD -->
        <div class="card-header bg-light">
            <strong class="text-primary">Form Edit User</strong>
        </div>

        <!-- BODY CARD -->
        <div class="card-body">
            <form action="{{ route('user.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- NAMA LENGKAP -->
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <div class="col-md-9">
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                               placeholder="Masukan Nama Lengkap" value="{{ old('nama', $user->name) }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- NOMOR IDENTITAS -->
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Nomor Identitas (NISN) <span class="text-danger">*</span></label>
                    <div class="col-md-9">
                        <input type="number" name="identitas" class="form-control @error('identitas') is-invalid @enderror"
                               placeholder="Masukan Nomor Identitas" value="{{ old('identitas', $user->nomor_identitas) }}" required>
                        @error('identitas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle"></i> Harus berupa angka dan unik
                        </small>
                    </div>
                </div>

                <!-- ROLE -->
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Role <span class="text-danger">*</span></label>
                    <div class="col-md-9">
                        <select name="role" class="form-control @error('role') is-invalid @enderror" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="petugas" {{ old('role', $user->role) == 'petugas' ? 'selected' : '' }}>Petugas</option>
                            <option value="peminjam" {{ old('role', $user->role) == 'peminjam' ? 'selected' : '' }}>Peminjam</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- PASSWORD -->
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Password</label>
                    <div class="col-md-9">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                               placeholder="Kosongkan jika tidak ingin mengubah password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle"></i> Kosongkan jika tidak ingin mengubah password
                        </small>
                    </div>
                </div>

                <!-- BUTTON -->
                <div class="text-right mt-4">
                    <a href="{{ route('user.list') }}" class="btn btn-secondary px-4 mr-2">
                        <i class="fas fa-times mr-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save mr-1"></i> Update
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection
