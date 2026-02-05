{{-- @extends('layouts.app')

@section('title', 'Daftar Peminjaman')

@section('content')
<div class="container-fluid px-4">
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #5b6fe8 0%, #6b7ff0 100%); border: none; border-radius: 12px; box-shadow: 0 2px 10px rgba(91, 111, 232, 0.3);">
                <div class="card-body d-flex align-items-center p-3">
                    <div class="d-flex align-items-center justify-content-center mr-3" style="width: 50px; height: 50px; background: rgba(255,255,255,0.25); border-radius: 10px;">
                        <i class="fas fa-book fa-lg"></i>
                    </div>
                    <div>
                        <h6 class="mb-0" style="font-size: 14px; opacity: 0.9;">Buku</h6>
                        <h4 class="mb-0 font-weight-bold">320</h4>
                    </div>
                    <div class="ml-auto" style="opacity: 0.15;">
                        <i class="fas fa-book" style="font-size: 40px;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #4db8b0 0%, #5ac4bc 100%); border: none; border-radius: 12px; box-shadow: 0 2px 10px rgba(77, 184, 176, 0.3);">
                <div class="card-body d-flex align-items-center p-3">
                    <div class="d-flex align-items-center justify-content-center mr-3" style="width: 50px; height: 50px; background: rgba(255,255,255,0.25); border-radius: 10px;">
                        <i class="fas fa-book-reader fa-lg"></i>
                    </div>
                    <div>
                        <h6 class="mb-0" style="font-size: 14px; opacity: 0.9;">Dipinjam</h6>
                        <h4 class="mb-0 font-weight-bold">82</h4>
                    </div>
                    <div class="ml-auto" style="opacity: 0.15;">
                        <i class="fas fa-book-reader" style="font-size: 40px;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #f9a041 0%, #fcb05c 100%); border: none; border-radius: 12px; box-shadow: 0 2px 10px rgba(249, 160, 65, 0.3);">
                <div class="card-body d-flex align-items-center p-3">
                    <div class="d-flex align-items-center justify-content-center mr-3" style="width: 50px; height: 50px; background: rgba(255,255,255,0.25); border-radius: 10px;">
                        <i class="fas fa-users fa-lg"></i>
                    </div>
                    <div>
                        <h6 class="mb-0" style="font-size: 14px; opacity: 0.9;">Pengguna</h6>
                        <h4 class="mb-0 font-weight-bold">124</h4>
                    </div>
                    <div class="ml-auto" style="opacity: 0.15;">
                        <i class="fas fa-users" style="font-size: 40px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card shadow-sm" style="border-radius: 12px; border: none; overflow: hidden;">
        <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 font-weight-bold">Daftar Peminjaman</h5>
            <div>
                <a href="{{ route('peminjaman.create') }}" class="btn btn-sm mr-2" style="background-color: #5b6fe8; color: white; border: none; border-radius: 8px; padding: 8px 16px;">
                    <i class="fas fa-plus"></i> Tambah Peminjaman
                </a>
                <button class="btn btn-success btn-sm" style="border: none; border-radius: 8px; padding: 8px 16px;">
                    <i class="fas fa-file-excel"></i> Export Excel
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead style="background: linear-gradient(135deg, #5b6fe8 0%, #7685f5 100%); color: white;">
                        <tr>
                            <th class="border-0 py-3" style="padding-left: 1.5rem;">No.</th>
                            <th class="border-0 py-3">Peminjam</th>
                            <th class="border-0 py-3">Judul Buku</th>
                            <th class="border-0 py-3">Tanggal Pinjam</th>
                            <th class="border-0 py-3">Tanggal Kembali</th>
                            <th class="border-0 py-3" style="padding-right: 1.5rem;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border-bottom: 1px solid #f0f0f0;">
                            <td class="align-middle" style="padding-left: 1.5rem; padding-top: 1rem; padding-bottom: 1rem;">1</td>
                            <td class="align-middle" style="padding-top: 1rem; padding-bottom: 1rem;">
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name=Salsa+Billa&background=f093fb&color=fff&bold=true"
                                         class="rounded-circle mr-2" width="35" height="35" alt="Avatar">
                                    <span style="font-weight: 500;">Salsa Billa</span>
                                </div>
                            </td>
                            <td class="align-middle" style="padding-top: 1rem; padding-bottom: 1rem;">
                                <div>
                                    <div style="font-weight: 600; color: #2d3748;">Menara 5 Negara</div>
                                    <small class="text-muted">Gramedia Pustaka Utama</small>
                                </div>
                            </td>
                            <td class="align-middle" style="padding-top: 1rem; padding-bottom: 1rem;">22/01/2026</td>
                            <td class="align-middle" style="padding-top: 1rem; padding-bottom: 1rem;">22/01/2026</td>
                            <td class="align-middle" style="padding-right: 1.5rem; padding-top: 1rem; padding-bottom: 1rem;">
                                <span class="badge" style="background-color: #ff9f43; color: white; border-radius: 15px; padding: 6px 14px; font-weight: 500; font-size: 11px;">Belum Kembali</span>
                            </td>
                        </tr>
                        <tr style="border-bottom: 1px solid #f0f0f0;">
                            <td class="align-middle" style="padding-left: 1.5rem; padding-top: 1rem; padding-bottom: 1rem;">2</td>
                            <td class="align-middle" style="padding-top: 1rem; padding-bottom: 1rem;">
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name=Gilang+Andri&background=11998e&color=fff&bold=true"
                                         class="rounded-circle mr-2" width="35" height="35" alt="Avatar">
                                    <span style="font-weight: 500;">Gilang Andri</span>
                                </div>
                            </td>
                            <td class="align-middle" style="padding-top: 1rem; padding-bottom: 1rem;">
                                <div>
                                    <div style="font-weight: 600; color: #2d3748;">Menara 5 Negara</div>
                                    <small class="text-muted">Gramedia Pustaka Utama</small>
                                </div>
                            </td>
                            <td class="align-middle" style="padding-top: 1rem; padding-bottom: 1rem;">22/01/2026</td>
                            <td class="align-middle" style="padding-top: 1rem; padding-bottom: 1rem;">22/01/2026</td>
                            <td class="align-middle" style="padding-right: 1.5rem; padding-top: 1rem; padding-bottom: 1rem;">
                                <span class="badge" style="background-color: #28c76f; color: white; border-radius: 15px; padding: 6px 14px; font-weight: 500; font-size: 11px;">Sudah Kembali</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle" style="padding-left: 1.5rem; padding-top: 1rem; padding-bottom: 1rem;">3</td>
                            <td class="align-middle" style="padding-top: 1rem; padding-bottom: 1rem;">
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name=Yudha+Putra&background=667eea&color=fff&bold=true"
                                         class="rounded-circle mr-2" width="35" height="35" alt="Avatar">
                                    <span style="font-weight: 500;">Yudha Putra</span>
                                </div>
                            </td>
                            <td class="align-middle" style="padding-top: 1rem; padding-bottom: 1rem;">
                                <div>
                                    <div style="font-weight: 600; color: #2d3748;">Menara 5 Negara</div>
                                    <small class="text-muted">Gramedia Pustaka Utama</small>
                                </div>
                            </td>
                            <td class="align-middle" style="padding-top: 1rem; padding-bottom: 1rem;">22/01/2026</td>
                            <td class="align-middle" style="padding-top: 1rem; padding-bottom: 1rem;">22/01/2026</td>
                            <td class="align-middle" style="padding-right: 1.5rem; padding-top: 1rem; padding-bottom: 1rem;">
                                <span class="badge" style="background-color: #28c76f; color: white; border-radius: 15px; padding: 6px 14px; font-weight: 500; font-size: 11px;">Sudah Kembali</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">Menampilkan 1 dari 32 halaman</small>
                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" style="color: #6c757d;">Previous</a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link" href="#" style="background-color: #5b6fe8; border-color: #5b6fe8;">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#" style="color: #5b6fe8;">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#" style="color: #5b6fe8;">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#" style="color: #5b6fe8;">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Peminjaman -->
<div class="modal fade" id="addBorrowingModal" tabindex="-1" role="dialog" aria-labelledby="addBorrowingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title font-weight-bold" id="addBorrowingModalLabel">Tambah Peminjaman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" method="POST">
                @csrf
                <div class="modal-body px-4">
                    <div class="form-group">
                        <label for="user_id" style="font-weight: 500; color: #2d3748;">Peminjam</label>
                        <select class="form-control" id="user_id" name="user_id" required style="border-radius: 8px; padding: 10px; border: 1px solid #e2e8f0;">
                            <option value="">Pilih Peminjam</option>
                            <option value="1">Salsa Billa</option>
                            <option value="2">Gilang Andri</option>
                            <option value="3">Yudha Putra</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="book_id" style="font-weight: 500; color: #2d3748;">Buku</label>
                        <select class="form-control" id="book_id" name="book_id" required style="border-radius: 8px; padding: 10px; border: 1px solid #e2e8f0;">
                            <option value="">Pilih Buku</option>
                            <option value="1">Menara 5 Negara - Gramedia Pustaka Utama</option>
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="borrow_date" style="font-weight: 500; color: #2d3748;">Tanggal Pinjam</label>
                            <input type="date" class="form-control" id="borrow_date" name="borrow_date" required style="border-radius: 8px; padding: 10px; border: 1px solid #e2e8f0;">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="return_date" style="font-weight: 500; color: #2d3748;">Tanggal Kembali</label>
                            <input type="date" class="form-control" id="return_date" name="return_date" required style="border-radius: 8px; padding: 10px; border: 1px solid #e2e8f0;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 8px; padding: 8px 24px;">Batal</button>
                    <button type="submit" class="btn btn-primary" style="border-radius: 8px; padding: 8px 24px; background-color: #5b6fe8; border-color: #5b6fe8;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection --}}
