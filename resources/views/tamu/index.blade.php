@extends('layouts.admin')

@section('title', 'Buku Tamu')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Buku Tamu</h5>
                </div>
                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- Search & Tambah --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <form method="GET" action="{{ route('guestbook.index') }}" class="d-flex gap-2">
                            <input
                                type="text"
                                name="search"
                                class="form-control"
                                placeholder="Masukkan Nama"
                                value="{{ request('search') }}"
                                style="width: 250px;"
                            >
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </form>
                    </div>

                    {{-- Table --}}
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead style="background-color: #3d6fd4; color: white;">
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Keperluan</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($guestBooks as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->needs }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('H.i') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">Belum ada data.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>



                </div>
            </div>
        </div>
    </div>
</div>
@endsection
