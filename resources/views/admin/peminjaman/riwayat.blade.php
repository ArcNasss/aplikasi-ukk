{{-- @extends('layouts.app')

@section('title', 'Riwayat Peminjaman')

@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 font-weight-bold">Riwayat Peminjaman</h4>
        <div>
            <button class="btn btn-success btn-sm" style="border-radius: 8px;">
                <i class="fas fa-download"></i> Export Excel
            </button>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card shadow-sm mb-3" style="border-radius: 12px; border: none;">
        <div class="card-body p-3">
            <div class="row align-items-center">
                <div class="col-md-3 mb-2 mb-md-0">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0" style="border-radius: 8px 0 0 8px; border: 1px solid #dee2e6;">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0" placeholder="Cari nama atau judul buku..." style="border-radius: 0 8px 8px 0; border: 1px solid #dee2e6; border-left: none;">
                    </div>
                </div>
                <div class="col-md-2 mb-2 mb-md-0">
                    <select class="form-control" style="border-radius: 8px; border: 1px solid #dee2e6; padding: 0.375rem 0.75rem;">
                        <option value="">Semua Status</option>
                        <option value="dikembalikan">Dikembalikan</option>
                        <option value="dipinjam">Dipinjam</option>
                        <option value="terlambat">Terlambat</option>
                    </select>
                </div>
                <div class="col-md-4 mb-2 mb-md-0">
                    <div class="d-flex align-items-center">
                        <input type="text" class="form-control" value="27/01/2026" style="border-radius: 8px; border: 1px solid #dee2e6; padding: 0.375rem 0.75rem;">
                        <span class="mx-2 text-muted">-</span>
                        <input type="text" class="form-control" value="03/01/2026" style="border-radius: 8px; border: 1px solid #dee2e6; padding: 0.375rem 0.75rem;">
                    </div>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('peminjaman.create') }}" class="btn btn-primary w-100" style="border-radius: 8px; background: #5B6EF5; border: none; padding: 0.5rem 1rem; font-weight: 500;">
                        <i class="fas fa-plus"></i> Tambah peminjaman
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card shadow-sm" style="border-radius: 12px; border: none; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="border-collapse: separate; border-spacing: 0;">
                    <thead style="background: #5668E3; color: white;">
                        <tr>
                            <th class="border-0 py-3 px-4" style="font-weight: 600;">No.</th>
                            <th class="border-0 py-3" style="font-weight: 600;">Nama User</th>
                            <th class="border-0 py-3" style="font-weight: 600;">Judul Buku</th>
                            <th class="border-0 py-3" style="font-weight: 600;">Tanggal Pinjam</th>
                            <th class="border-0 py-3" style="font-weight: 600;">Tanggal Kembali</th>
                            <th class="border-0 py-3 text-center" style="font-weight: 600;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border-bottom: 1px solid #e9ecef;">
                            <td class="px-4 py-3 align-middle">1</td>
                            <td class="py-3 align-middle">Nasril Ilham SA</td>
                            <td class="py-3 align-middle">Sang Pemimpi</td>
                            <td class="py-3 align-middle">22/01/2026</td>
                            <td class="py-3 align-middle">28/01/2026</td>
                            <td class="py-3 align-middle text-center">
                                <span class="badge px-3 py-2" style="background-color: #10b981; color: white; border-radius: 20px; font-weight: 500; font-size: 0.85rem;">Dikembalikan</span>
                            </td>
                        </tr>
                        <tr style="border-bottom: 1px solid #e9ecef;">
                            <td class="px-4 py-3 align-middle">2</td>
                            <td class="py-3 align-middle">Dimas Setyawan</td>
                            <td class="py-3 align-middle">Filosofi Teras</td>
                            <td class="py-3 align-middle">22/01/2026</td>
                            <td class="py-3 align-middle">28/01/2026</td>
                            <td class="py-3 align-middle text-center">
                                <span class="badge px-3 py-2" style="background-color: #f59e0b; color: white; border-radius: 20px; font-weight: 500; font-size: 0.85rem;">Dipinjam</span>
                            </td>
                        </tr>
                        <tr style="border-bottom: 1px solid #e9ecef;">
                            <td class="px-4 py-3 align-middle">3</td>
                            <td class="py-3 align-middle">Doni Ganteng</td>
                            <td class="py-3 align-middle">Negeri 5 Menara</td>
                            <td class="py-3 align-middle">22/01/2026</td>
                            <td class="py-3 align-middle">28/01/2026</td>
                            <td class="py-3 align-middle text-center">
                                <span class="badge px-3 py-2" style="background-color: #ef4444; color: white; border-radius: 20px; font-weight: 500; font-size: 0.85rem;">Terlambat</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer with Statistics and Pagination -->
        <div class="card-footer py-3 px-4" style="background: #5668E3; border-radius: 0 0 12px 12px; border-top: none;">
            <div class="row align-items-center">
                <div class="col-12 mb-2">
                    <small class="text-white">Menampilkan 1 dari 50 halaman</small>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-center" style="gap: 1.5rem;">
                        <span class="text-white d-flex align-items-center">
                            <i class="fas fa-book-open me-2"></i>
                            <strong>Total Peminjaman : 150</strong>
                        </span>
                        <span class="text-white d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-2" style="color: #ef4444;"></i>
                            <strong>Total Terlambat : <span style="color: #ef4444;">0</span></strong>
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <nav class="d-flex justify-content-end">
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item">
                                <a class="page-link" href="#" style="border-radius: 6px; border: 1px solid white; background: transparent; color: white; margin: 0 2px; padding: 5px 10px; font-size: 0.875rem;">Previous</a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="#" style="border-radius: 6px; background: white; border: 1px solid white; color: #5668E3; margin: 0 2px; padding: 5px 12px; font-weight: 600; font-size: 0.875rem;">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#" style="border-radius: 6px; border: 1px solid white; background: transparent; color: white; margin: 0 2px; padding: 5px 12px; font-size: 0.875rem;">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#" style="border-radius: 6px; border: 1px solid white; background: transparent; color: white; margin: 0 2px; padding: 5px 12px; font-size: 0.875rem;">3</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#" style="border-radius: 6px; border: 1px solid white; background: transparent; color: white; margin: 0 2px; padding: 5px 10px; font-size: 0.875rem;">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
