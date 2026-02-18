@extends('layouts.admin')

@section('title', 'Kelola User')

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
    <h1 class="h3 text-gray-800">Kelola User</h1>
    <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus mr-1"></i> Tambah User
    </a>
</div>

<!-- Search -->
<div class="card shadow mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('user.list') }}">
            <div class="row align-items-center">

                <div class="col-md-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                        </div>
                        <input type="text" name="search" class="form-control" placeholder="Cari nama atau Nomor Identitas" value="{{ request('search') }}">
                    </div>
                </div>

                <div class="col-md-2">
                    <select name="role" class="form-control form-control-sm">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="petugas" {{ request('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                        <option value="peminjam" {{ request('role') == 'peminjam' ? 'selected' : '' }}>Peminjam</option>
                    </select>
                </div>

                <div class="col-md-2">
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
            <table class="table table-bordered table-hover mb-0">
                <thead class="bg-primary text-white">
                <tr>
                    <th style="width:60px">No.</th>
                    <th>Nama</th>
                    <th>NISN</th>
                    <th>Role</th>
                    <th>Tanggal Daftar</th>
                    <th style="width:120px">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @forelse($users as $index => $user)
                <tr>
                    <td class="text-center">{{ $users->firstItem() + $index }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-{{ $user->role == 'admin' ? 'primary' : ($user->role == 'petugas' ? 'success' : 'info') }} text-white d-flex align-items-center justify-content-center mr-3"
                                 style="width:40px;height:40px;font-weight:bold;">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                            <div>
                                <div class="font-weight-bold">{{ $user->name }}</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $user->nomor_identitas }}</td>
                    <td>
                        @if($user->role == 'admin')
                            <span class="badge badge-primary px-3 py-2">Admin</span>
                        @elseif($user->role == 'petugas')
                            <span class="badge badge-success px-3 py-2">Petugas</span>
                        @else
                            <span class="badge badge-info px-3 py-2">Peminjam</span>
                        @endif
                    </td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    <td class="text-center">
                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning btn-sm mr-1">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('user.delete', $user->id) }}" method="POST" style="display:inline;" class="delete-form">
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
                    <td colspan="6" class="text-center py-4">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Tidak ada user ditemukan</p>
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
        <div class="d-flex justify-content-between align-items-center p-3">
            <small class="text-muted">Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} data</small>
            <div>
                {{ $users->links('pagination::bootstrap-4') }}
            </div>
        </div>
        @else
        <div class="p-3">
            <small class="text-muted">Menampilkan {{ $users->count() }} dari {{ $users->total() }} data</small>
        </div>
        @endif

    </div>
</div>

@endsection





