@extends('layouts.petugas')

@section('title', 'Pengajuan Peminjaman')

@section('content')
    <div class="container-fluid px-4">
        <!-- Header Section -->
        <div class="d-flex align-items-center mb-4">
            <h4 class="mb-0 font-weight-bold">Daftar Peminjaman</h4>
        </div>

        <!-- Table Card -->
        <div class="card shadow-sm" style="border-radius: 12px; border: none;">
            <div class="card-body p-3">
                <div class="row align-items-center justify-content-between mb-4">
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari nama atau judul buku..."
                                style="border-radius: 8px 0 0 8px; border-right: none;">
                            <div class="input-group-append">
                                <span class="input-group-text bg-white"
                                    style="border-radius: 0 8px 8px 0; border-left: none;">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" style="border-radius: 8px;">
                            <option value="">Semua Status</option>
                            <option value="dikembalikan">Dikembalikan</option>
                            <option value="dipinjam">Dipinjam</option>
                            <option value="terlambat">Terlambat</option>
                        </select>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background: #4f73df; color: white;">
                            <tr>
                                <th class="border-0 py-3 px-4">No.</th>
                                <th class="border-0 py-3">Nama</th>
                                <th class="border-0 py-3">Nomor Identitas</th>
                                <th class="border-0 py-3">Judul Buku</th>
                                <th class="border-0 py-3">Tanggal Pengajuan</th>
                                <th class="border-0 py-3">Status</th>
                                <th class="border-0 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                           @forelse ($borrows as $index => $borrow)
                                <tr>
                                    <td class="px-4 py-3 align-middle">{{ $borrows->firstItem() + $index }}</td>
                                    <td class="py-3 align-middle">{{ $borrow->user->name }}</td>
                                    <td class="py-3 align-middle">{{ $borrow->user->nomor_identitas ?? $borrow->user->email }}</td>
                                    <td class="py-3 align-middle">{{ $borrow->bookItem->book->judul ?? '' }}</td>
                                    <td class="py-3 align-middle">{{ $borrow->created_at->format('d/m/Y') }}</td>
                                    <td class="py-3 align-middle">
                                        @if($borrow->status == 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif($borrow->status == 'disetujui')
                                            <span class="badge badge-success">Disetujui</span>
                                        @else
                                            <span class="badge badge-danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="py-3 align-middle">
                                        <div class="d-flex gap-2">
                                            @if($borrow->status == 'pending')
                                                <form action="{{route('peminjaman.approve', $borrow->id)}}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-success btn-sm" title="Setujui">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                </form>
                                                <form action="{{route('peminjaman.reject', $borrow->id)}}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Tolak">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </form>
                                            @elseif($borrow->status == 'disetujui')
                                                <a href="{{route('peminjaman.downloadCard', $borrow->id)}}" class="btn btn-primary btn-sm" title="Download Kartu PDF">
                                                    <i class="fa fa-download"></i> Download Kartu
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                           @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        Tidak ada data peminjaman.
                                    </td>
                                </tr>
                           @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Footer with Statistics and Pagination -->
            <div class="card-footer bg-white py-3" style="border-radius: 0 0 12px 12px; border-top: 1px solid #e9ecef;">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <small class="text-muted mr-3">
                            Menampilkan {{ $borrows->firstItem() ?? 0 }} - {{ $borrows->lastItem() ?? 0 }} dari {{ $borrows->total() }} data
                        </small>
                    </div>
                    <div>
                        {{ $borrows->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
