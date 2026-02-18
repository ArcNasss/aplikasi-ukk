@extends('layouts.petugas')

@section('title', 'Daftar Denda')

@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 font-weight-bold">Daftar Denda</h4>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exportModal">
            <i class="fas fa-file-excel mr-2"></i>Export Excel
        </button>
    </div>

    <!-- Alert untuk success message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Table Card -->
    <div class="card shadow-sm" style="border-radius: 12px; border: none; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="border-collapse: separate; border-spacing: 0;">
                    <thead style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); color: white;">
                        <tr>
                            <th class="border-0 py-3 px-4" style="font-weight: 600;">No.</th>
                            <th class="border-0 py-3" style="font-weight: 600;">Peminjam</th>
                            <th class="border-0 py-3" style="font-weight: 600;">Judul Buku</th>
                            <th class="border-0 py-3" style="font-weight: 600;">Kode Buku</th>
                            <th class="border-0 py-3" style="font-weight: 600;">Tanggal Pinjam</th>
                            <th class="border-0 py-3" style="font-weight: 600;">Tempo</th>
                            <th class="border-0 py-3" style="font-weight: 600;">Tanggal Kembali</th>
                            <th class="border-0 py-3 text-center" style="font-weight: 600;">Jenis Denda</th>
                            <th class="border-0 py-3 text-center" style="font-weight: 600;">Keterlambatan</th>
                            <th class="border-0 py-3 text-center" style="font-weight: 600;">Jumlah Denda</th>
                            <th class="border-0 py-3 text-center" style="font-weight: 600;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dendas as $index => $denda)
                        <tr style="border-bottom: 1px solid #e9ecef;">
                            <td class="px-4 py-3 align-middle">{{ $index + 1 }}</td>
                            <td class="py-3 align-middle">
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($denda['user_name']) }}&background=random&color=fff&bold=true"
                                         class="rounded-circle mr-2" width="35" height="35" alt="Avatar">
                                    <div>
                                        <div style="font-weight: 500;">{{ $denda['user_name'] }}</div>
                                        <small class="text-muted">{{ $denda['user_nomor_identitas'] }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 align-middle">
                                <div style="font-weight: 600; color: #2d3748;">{{ $denda['book_title'] }}</div>
                            </td>
                            <td class="py-3 align-middle">
                                <span class="badge badge-secondary">{{ $denda['book_code'] }}</span>
                            </td>
                            <td class="py-3 align-middle">
                                {{ $denda['tanggal_pinjam'] ? $denda['tanggal_pinjam']->format('d/m/Y') : '-  ' }}
                            </td>
                            <td class="py-3 align-middle">
                                {{ $denda['tanggal_kembali'] ? $denda['tanggal_kembali']->format('d/m/Y') : '-' }}
                            </td>
                            <td class="py-3 align-middle">
                                {{ $denda['tanggal_pengembalian'] ? \Carbon\Carbon::parse($denda['tanggal_pengembalian'])->format('d/m/Y') : '-' }}
                            </td>
                            <td class="py-3 align-middle text-center">
                                @if($denda['status'] == 'terlambat')
                                    <span class="badge px-3 py-2" style="background-color: #f59e0b; color: white; border-radius: 20px; font-weight: 500; font-size: 0.85rem;">Terlambat</span>
                                @elseif($denda['status'] == 'hilang')
                                    <span class="badge px-3 py-2" style="background-color: #ef4444; color: white; border-radius: 20px; font-weight: 500; font-size: 0.85rem;">Hilang</span>
                                @elseif($denda['status'] == 'rusak')
                                    <span class="badge px-3 py-2" style="background-color: #f97316; color: white; border-radius: 20px; font-weight: 500; font-size: 0.85rem;">Rusak</span>
                                @endif
                            </td>
                            <td class="py-3 align-middle text-center">
                                @if($denda['hari_terlambat'])
                                    <span class="font-weight-bold text-danger">{{ $denda['hari_terlambat'] }} Hari</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="py-3 align-middle text-center">
                                <span class="font-weight-bold text-danger" style="font-size: 1rem;">
                                    Rp {{ number_format($denda['denda'], 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="py-3 align-middle text-center">
                                @if($denda['type'] == 'return' && !$denda['is_paid'])
                                    <form action="{{ route('denda.markPaid', $denda['id']) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm" title="Tandai Sudah Dibayar" onclick="return confirm('Apakah denda sudah dibayar?')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @elseif($denda['type'] == 'return' && $denda['is_paid'])
                                    <span class="badge badge-success px-3 py-2" style="border-radius: 20px; font-size: 0.85rem;">
                                        <i class="fas fa-check-circle mr-1"></i> Lunas
                                    </span>
                                @else
                                    <span class="badge badge-warning px-3 py-2" style="border-radius: 20px; font-size: 0.85rem;">
                                        <i class="fas fa-clock mr-1"></i> Belum Kembali
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                    <p>Tidak ada data denda</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer with Summary -->
        <div class="card-footer py-3 px-4" style="background: #f8f9fa; border-radius: 0 0 12px 12px; border-top: 1px solid #e9ecef;">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <small class="text-muted">
                        Total: {{ $dendas->count() }} denda | Total Nilai: <span class="font-weight-bold text-danger">Rp {{ number_format($dendas->sum('denda'), 0, ',', '.') }}</span>
                    </small>
                </div>
                <div class="col-md-6 text-right">
                    <small class="text-muted">
                        Lunas: {{ $dendas->where('is_paid', true)->count() }} | Belum: {{ $dendas->where('is_paid', false)->count() }}
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Export Modal -->
<div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportModalLabel">Export Laporan Denda</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('denda.export') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="start_date">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>
                    <div class="form-group">
                        <label for="end_date">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-download mr-2"></i>Download Excel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
