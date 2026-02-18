@extends('layouts.petugas')

@section('title', 'Tambah Pengembalian')

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
<div class="mb-4">
    <h1 class="h4 font-weight-bold text-gray-800">Tambah Pengembalian</h1>
</div>

<!-- Search Card -->
<div class="card shadow mb-4">
    <div class="card-header bg-white py-3">
        <h6 class="m-0 font-weight-bold text-primary">Cari Data Peminjaman</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('pengembalian.create') }}">
            <div class="form-group row">
                <label for="nomor_peminjaman" class="col-sm-3 col-form-label">Nomor Peminjaman</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <input type="text"
                               class="form-control"
                               id="nomor_peminjaman"
                               name="nomor_peminjaman"
                               placeholder="Masukkan Nomor Peminjaman"
                               value="{{ request('nomor_peminjaman') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search mr-1"></i> Cari
                            </button>
                        </div>
                    </div>
                    <small class="form-text text-muted">Cari peminjaman berdasarkan nomor ID peminjaman</small>
                </div>
            </div>
        </form>

        <!-- Alert jika tidak ditemukan -->
        @if($notFound)
            <div class="alert alert-danger mt-3">
                <i class="fas fa-exclamation-circle mr-2"></i>
                Peminjaman tidak ditemukan atau sudah dikembalikan
            </div>
        @endif
    </div>
</div>

<!-- Data Peminjaman Card -->
@if($borrow)
<div class="card shadow mb-4">
    <div class="card-header bg-white py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Peminjaman</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th width="30%">Nomor Peminjaman</th>
                        <td>: {{ $borrow->id }}</td>
                    </tr>
                    <tr>
                        <th>Nama Peminjam</th>
                        <td>: {{ $borrow->user->name }}</td>
                    </tr>
                    <tr>
                        <th>Nomor Identitas</th>
                        <td>: {{ $borrow->user->identity_number }}</td>
                    </tr>
                    <tr>
                        <th>Judul Buku</th>
                        <td>: {{ $borrow->bookItem->book->title }}</td>
                    </tr>
                    <tr>
                        <th>Kode Buku</th>
                        <td>: {{ $borrow->bookItem->kode_buku }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Peminjaman</th>
                        <td>: {{ $borrow->tanggal_pinjam ? $borrow->tanggal_pinjam->format('d/m/Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Harus Kembali</th>
                        <td>: {{ $borrow->tanggal_kembali ? $borrow->tanggal_kembali->format('d/m/Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>: <span class="badge badge-warning">{{ ucfirst($borrow->status) }}</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Form Card -->
<div class="card shadow">
    <div class="card-header bg-white py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Pengembalian</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('pengembalian.store') }}" method="POST">
            @csrf
            <input type="hidden" name="borrow_id" value="{{ $borrow->id }}">

            <!-- Status -->
            <div class="form-group row">
                <label for="status" class="col-sm-3 col-form-label">Status Pengembalian <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <select class="form-control @error('status') is-invalid @enderror"
                            id="status"
                            name="status"
                            required>
                        <option value="">--Pilih Status--</option>
                        <option value="dikembalikan" {{ old('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                        <option value="terlambat" {{ old('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                        <option value="hilang" {{ old('status') == 'hilang' ? 'selected' : '' }}>Hilang</option>
                        <option value="rusak" {{ old('status') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Informasi Denda -->
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Informasi Denda</label>
                <div class="col-sm-9">
                    <div class="alert alert-info mb-0">
                        <h6 class="alert-heading"><i class="fas fa-info-circle mr-2"></i>Denda Dihitung Otomatis oleh Sistem</h6>
                        <hr>
                        <ul class="mb-0 pl-3">
                            <li><strong>Terlambat:</strong> Rp 2.000 per hari keterlambatan</li>
                            <li><strong>Hilang:</strong> Rp 100.000</li>
                            <li><strong>Dikembalikan/Rusak:</strong> Tidak ada denda</li>
                        </ul>

                        <!-- Estimasi Denda -->
                        <div id="estimasi-denda" class="mt-3" style="display: none;">
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <strong>Estimasi Denda:</strong>
                                <h5 class="mb-0 text-danger font-weight-bold" id="jumlah-denda">Rp 0</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="form-group row">
                <div class="col-sm-9 offset-sm-3">
                    <a href="{{ route('pengembalian.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Simpan Pengembalian
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status');
    const estimasiDiv = document.getElementById('estimasi-denda');
    const jumlahDenda = document.getElementById('jumlah-denda');

    @if($borrow)
    const tanggalKembali = new Date('{{ $borrow->tanggal_kembali }}');
    const tanggalSekarang = new Date();

    statusSelect.addEventListener('change', function() {
        const status = this.value;
        let denda = 0;

        if (status === 'hilang') {
            denda = 100000;
            estimasiDiv.style.display = 'block';
        } else if (status === 'terlambat') {
            // Hitung hari keterlambatan
            const diffTime = tanggalSekarang - tanggalKembali;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            if (diffDays > 0) {
                denda = diffDays * 2000;
            }
            estimasiDiv.style.display = 'block';
        } else {
            estimasiDiv.style.display = 'none';
        }

        jumlahDenda.textContent = 'Rp ' + denda.toLocaleString('id-ID');
    });
    @endif
});
</script>
@endpush
