@extends('layouts.admin')

@section('title', 'Daftar Pengembalian')

@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 font-weight-bold">Daftar Pengembalian</h4>
    </div>

    <!-- Table Card -->
    <div class="card shadow-sm" style="border-radius: 12px; border: none; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="border-collapse: separate; border-spacing: 0;">
                    <thead style="background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); color: white;">
                        <tr>
                            <th class="border-0 py-3 px-4" style="font-weight: 600;">No.</th>
                            <th class="border-0 py-3" style="font-weight: 600;">Peminjam</th>
                            <th class="border-0 py-3" style="font-weight: 600;">Judul Buku</th>
                            <th class="border-0 py-3" style="font-weight: 600;">Kode Buku</th>
                            <th class="border-0 py-3" style="font-weight: 600;">Tanggal Pinjam</th>
                            <th class="border-0 py-3" style="font-weight: 600;">Tanggal Kembali</th>
                            <th class="border-0 py-3" style="font-weight: 600;">Tanggal Pengembalian</th>
                            <th class="border-0 py-3 text-center" style="font-weight: 600;">Status</th>
                            <th class="border-0 py-3 text-center" style="font-weight: 600;">Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($returns as $index => $return)
                        <tr style="border-bottom: 1px solid #e9ecef;">
                            <td class="px-4 py-3 align-middle">{{ $returns->firstItem() + $index }}</td>
                            <td class="py-3 align-middle">
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($return->borrow->user->name) }}&background=random&color=fff&bold=true"
                                         class="rounded-circle mr-2" width="35" height="35" alt="Avatar">
                                    <div>
                                        <div style="font-weight: 500;">{{ $return->borrow->user->name }}</div>
                                        <small class="text-muted">{{ $return->borrow->user->nomor_identitas }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 align-middle">
                                <div>
                                    <div style="font-weight: 600; color: #2d3748;">{{ $return->borrow->bookItem->book->judul }}</div>
                                    <small class="text-muted">{{ $return->borrow->bookItem->book->penulis }}</small>
                                </div>
                            </td>
                            <td class="py-3 align-middle">
                                <span class="badge badge-secondary">{{ $return->borrow->bookItem->kode_buku }}</span>
                            </td>
                            <td class="py-3 align-middle">
                                {{ $return->borrow->tanggal_pinjam ? $return->borrow->tanggal_pinjam->format('d/m/Y') : '-' }}
                            </td>
                            <td class="py-3 align-middle">
                                {{ $return->borrow->tanggal_kembali ? $return->borrow->tanggal_kembali->format('d/m/Y') : '-' }}
                            </td>
                            <td class="py-3 align-middle">
                                {{ \Carbon\Carbon::parse($return->tanggal_pengembalian)->format('d/m/Y') }}
                            </td>
                            <td class="py-3 align-middle text-center">
                                @if($return->status == 'dikembalikan')
                                    <span class="badge px-3 py-2" style="background-color: #10b981; color: white; border-radius: 20px; font-weight: 500; font-size: 0.85rem;">Dikembalikan</span>
                                @elseif($return->status == 'terlambat')
                                    <span class="badge px-3 py-2" style="background-color: #f59e0b; color: white; border-radius: 20px; font-weight: 500; font-size: 0.85rem;">Terlambat</span>
                                @elseif($return->status == 'hilang')
                                    <span class="badge px-3 py-2" style="background-color: #ef4444; color: white; border-radius: 20px; font-weight: 500; font-size: 0.85rem;">Hilang</span>
                                @elseif($return->status == 'rusak')
                                    <span class="badge px-3 py-2" style="background-color: #f97316; color: white; border-radius: 20px; font-weight: 500; font-size: 0.85rem;">Rusak</span>
                                @endif
                            </td>
                            <td class="py-3 align-middle text-center">
                                <span class="font-weight-bold {{ $return->denda > 0 ? 'text-danger' : 'text-success' }}">
                                    Rp {{ number_format($return->denda, 0, ',', '.') }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                    <p>Belum ada data pengembalian</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer with Pagination -->
        <div class="card-footer py-3 px-4" style="background: #f8f9fa; border-radius: 0 0 12px 12px; border-top: 1px solid #e9ecef;">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <small class="text-muted">
                        Menampilkan {{ $returns->firstItem() ?? 0 }} - {{ $returns->lastItem() ?? 0 }} dari {{ $returns->total() }} data
                    </small>
                </div>
                <div class="col-md-6">
                    <nav class="d-flex justify-content-end">
                        {{ $returns->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
