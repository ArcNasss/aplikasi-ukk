@extends('layouts.petugas')

@section('title', ' Pengembalian')

@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="d-flex align-items-center mb-4">
        <h4 class="mb-0 font-weight-bold">Daftar Pengembalian</h4>
        <div class="ml-auto">
            <a href="{{route('pengembalian.create')}}" class="btn btn-primary btn-sm " style="border-radius: 8px;">
                <i class="fas fa-plus mr-2"></i> Tambah Pengembalian
            </a>
        </div>
    </div>


    <!-- Table Card -->
    <div class="card shadow-sm" style="border-radius: 12px; border: none;">
        <div class="card-body p-3">
            <div class="row align-items-center justify-content-between mb-4">
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari nama atau judul buku..." style="border-radius: 8px 0 0 8px; border-right: none;">
                        <div class="input-group-append">
                            <span class="input-group-text bg-white" style="border-radius: 0 8px 8px 0; border-left: none;">
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
                            <th class="border-0 py-3">Nomor Indentitas</th>
                            <th class="border-0 py-3">Judul Buku</th>
                            <th class="border-0 py-3">Tanggal Pengajuan</th>
                            <th class="border-0 py-3">Tanggal Pengembalian</th>
                            <th class="border-0 py-3">Status</th>
                            <th class="border-0 py-3 text-right">Denda</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($returns as $index => $return)
                            <tr style="border-bottom: 1px solid #e9ecef;">
                            <td class="px-4 py-3 align-middle">{{ $index + 1 }}</td>
                            <td class="py-3 align-middle">{{ $return->borrow->user->name ?? '' }}</td>
                            <td class="py-3 align-middle">{{ $return->borrow->user->identity_number ?? '' }}</td>
                            <td class="py-3 align-middle">{{ $return->borrow->bookItem->book->title ?? '' }}</td>
                            <td class="py-3 align-middle">{{ $return->borrow->created_at->format('d/m/Y') ?? '' }}</td>
                            <td class="py-3 align-middle">{{ $return->created_at->format('d/m/Y') ?? '' }}</td>
                            <td class="py-3 align-middle">
                                @if($return->status == 'dikembalikan')
                                    <span class="badge px-3 py-2" style="background-color: #10b981; color: white; border-radius: 20px; font-weight: 500;">Dikembalikan</span>
                                @elseif($return->status == 'terlambat')
                                    <span class="badge px-3 py-2" style="background-color: #f59e0b; color: white; border-radius: 20px; font-weight: 500;">Terlambat</span>
                                @elseif($return->status == 'hilang')
                                    <span class="badge px-3 py-2" style="background-color: #ef4444; color: white; border-radius: 20px; font-weight: 500;">Hilang</span>
                                @elseif($return->status == 'rusak')
                                    <span class="badge px-3 py-2" style="background-color: #f97316; color: white; border-radius: 20px; font-weight: 500;">Rusak</span>
                                @endif
                            </td>
                            <td class="py-3 align-middle text-right">
                                <span class="font-weight-bold {{ $return->denda > 0 ? 'text-danger' : 'text-success' }}">
                                    Rp {{ number_format($return->denda, 0, ',', '.') }}
                                </span>
                            </td>
                        </tr>

                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">Tidak ada data pengembalian.</td>
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
                    <small class="text-muted mr-3">Menampilkan 1 dari 50 halaman</small>
                </div>
                <div>
                    <nav class="d-inline-block">
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" style="border-radius: 8px 0 0 8px;">Previous</a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="#" style="background: #4f73df;">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">3</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#" style="border-radius: 0 8px 8px 0;">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
