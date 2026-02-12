@extends('layouts.peminjam')

@section('title', 'Riwayat Peminjaman')

@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="d-flex align-items-center mb-4">
        <h4 class="mb-0 font-weight-bold">Riwayat Peminjaman</h4>
    </div>

    <!-- Table Card -->
    <div class="card shadow-sm" style="border-radius: 12px; border: none;">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background: #4f73df; color: white;">
                        <tr>
                            <th class="border-0 py-3 px-4">No.</th>
                            <th class="border-0 py-3">Judul Buku</th>
                            <th class="border-0 py-3">Kode Buku</th>
                            <th class="border-0 py-3">Tanggal Pinjam</th>
                            <th class="border-0 py-3">Tanggal Harus Kembali</th>
                            <th class="border-0 py-3">Tanggal Dikembalikan</th>
                            <th class="border-0 py-3">Status</th>
                            <th class="border-0 py-3 text-right">Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($borrows as $index => $borrow)
                        <tr style="border-bottom: 1px solid #e9ecef;">
                            <td class="px-4 py-3 align-middle">{{ $borrows->firstItem() + $index }}</td>
                            <td class="py-3 align-middle">
                                <div>
                                    <div style="font-weight: 600; color: #2d3748;">{{ $borrow->bookItem->book->judul }}</div>
                                    <small class="text-muted">{{ $borrow->bookItem->book->penulis }}</small>
                                </div>
                            </td>
                            <td class="py-3 align-middle">
                                <span class="badge badge-secondary">{{ $borrow->bookItem->kode_buku }}</span>
                            </td>
                            <td class="py-3 align-middle">{{ $borrow->tanggal_pinjam ? $borrow->tanggal_pinjam->format('d/m/Y') : '-' }}</td>
                            <td class="py-3 align-middle">{{ $borrow->tanggal_kembali ? $borrow->tanggal_kembali->format('d/m/Y') : '-' }}</td>
                            <td class="py-3 align-middle">
                                {{ $borrow->returnBook ? $borrow->returnBook->created_at->format('d/m/Y') : '-' }}
                            </td>
                            <td class="py-3 align-middle">
                                @if($borrow->status == 'pending')
                                    <span class="badge px-3 py-2" style="background-color: #f59e0b; color: white; border-radius: 20px; font-weight: 500;">Pending</span>
                                @elseif($borrow->status == 'disetujui')
                                    @if($borrow->returnBook)
                                        @if($borrow->returnBook->status == 'dikembalikan')
                                            <span class="badge px-3 py-2" style="background-color: #10b981; color: white; border-radius: 20px; font-weight: 500;">Dikembalikan</span>
                                        @elseif($borrow->returnBook->status == 'terlambat')
                                            <span class="badge px-3 py-2" style="background-color: #f59e0b; color: white; border-radius: 20px; font-weight: 500;">Terlambat</span>
                                        @elseif($borrow->returnBook->status == 'hilang')
                                            <span class="badge px-3 py-2" style="background-color: #ef4444; color: white; border-radius: 20px; font-weight: 500;">Hilang</span>
                                        @elseif($borrow->returnBook->status == 'rusak')
                                            <span class="badge px-3 py-2" style="background-color: #f97316; color: white; border-radius: 20px; font-weight: 500;">Rusak</span>
                                        @endif
                                    @else
                                        <span class="badge px-3 py-2" style="background-color: #3b82f6; color: white; border-radius: 20px; font-weight: 500;">Dipinjam</span>
                                    @endif
                                @elseif($borrow->status == 'ditolak')
                                    <span class="badge px-3 py-2" style="background-color: #ef4444; color: white; border-radius: 20px; font-weight: 500;">Ditolak</span>
                                @endif
                            </td>
                            <td class="py-3 align-middle text-right">
                                @if($borrow->returnBook && $borrow->returnBook->denda > 0)
                                    <span class="font-weight-bold text-danger">
                                        Rp {{ number_format($borrow->returnBook->denda, 0, ',', '.') }}
                                    </span>
                                @else
                                    <span class="text-success">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                    <p>Belum ada riwayat peminjaman</p>
                                </div>
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
                    <nav class="d-inline-block">
                        {{ $borrows->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
