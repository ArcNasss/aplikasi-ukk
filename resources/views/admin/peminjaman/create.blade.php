{{-- @extends('layouts.app')

@section('title', 'Tambah Peminjaman')

@section('content')

<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-gray-800">Tambah Peminjaman Baru</h1>
    <a href="{{ route('peminjaman.daftar') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left mr-1"></i> Kembali
    </a>
</div>

<!-- Form Card -->
<div class="card shadow" style="border-radius: 12px; border: none;">
    <div class="card-header py-3 border-0" style="background: linear-gradient(135deg, #5b6fe8 0%, #7685f5 100%); border-radius: 12px 12px 0 0;">
        <h6 class="m-0 font-weight-bold text-white">Form Tambah Peminjaman</h6>
    </div>
    <div class="card-body px-4 py-4">
        <form action="{{ route('peminjaman.store') }}" method="POST">
            @csrf

            <!-- Peminjam -->
            <div class="form-group row">
                <label for="user_id" class="col-sm-3 col-form-label" style="font-weight: 500; color: #2d3748;">
                    Peminjam <span class="text-danger">*</span>
                </label>
                <div class="col-sm-9">
                    <select class="form-control @error('user_id') is-invalid @enderror"
                            id="user_id"
                            name="user_id"
                            required
                            style="border-radius: 8px; padding: 10px; border: 1px solid #e2e8f0;">
                        <option value="">-- Pilih Peminjam --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} - {{ $user->nomor_identitas }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">
                        <i class="fas fa-info-circle"></i> Pilih peminjam yang akan meminjam buku
                    </small>
                </div>
            </div>

            <!-- Buku -->
            <div class="form-group row">
                <label for="book_item_id" class="col-sm-3 col-form-label" style="font-weight: 500; color: #2d3748;">
                    Buku <span class="text-danger">*</span>
                </label>
                <div class="col-sm-9">
                    <select class="form-control @error('book_item_id') is-invalid @enderror"
                            id="book_item_id"
                            name="book_item_id"
                            required
                            style="border-radius: 8px; padding: 10px; border: 1px solid #e2e8f0;">
                        <option value="">-- Pilih Buku --</option>
                        @foreach($bookItems as $item)
                            <option value="{{ $item->id }}" {{ old('book_item_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->book->title }} - {{ $item->book->publisher }} ({{ $item->code }})
                            </option>
                        @endforeach
                    </select>
                    @error('book_item_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">
                        <i class="fas fa-info-circle"></i> Pilih buku yang akan dipinjam (hanya buku yang tersedia)
                    </small>
                </div>
            </div>

            <!-- Tanggal Pinjam -->
            <div class="form-group row">
                <label for="borrow_date" class="col-sm-3 col-form-label" style="font-weight: 500; color: #2d3748;">
                    Tanggal Pinjam <span class="text-danger">*</span>
                </label>
                <div class="col-sm-9">
                    <input type="date"
                           class="form-control @error('borrow_date') is-invalid @enderror"
                           id="borrow_date"
                           name="borrow_date"
                           value="{{ old('borrow_date', date('Y-m-d')) }}"
                           required
                           style="border-radius: 8px; padding: 10px; border: 1px solid #e2e8f0;">
                    @error('borrow_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Tanggal Kembali (Rencana) -->
            <div class="form-group row">
                <label for="due_date" class="col-sm-3 col-form-label" style="font-weight: 500; color: #2d3748;">
                    Tanggal Kembali (Rencana) <span class="text-danger">*</span>
                </label>
                <div class="col-sm-9">
                    <input type="date"
                           class="form-control @error('due_date') is-invalid @enderror"
                           id="due_date"
                           name="due_date"
                           value="{{ old('due_date') }}"
                           required
                           style="border-radius: 8px; padding: 10px; border: 1px solid #e2e8f0;">
                    @error('due_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">
                        <i class="fas fa-info-circle"></i> Tanggal rencana pengembalian buku (maksimal 14 hari dari tanggal pinjam)
                    </small>
                </div>
            </div>

            <!-- Catatan -->
            <div class="form-group row">
                <label for="notes" class="col-sm-3 col-form-label" style="font-weight: 500; color: #2d3748;">
                    Catatan
                </label>
                <div class="col-sm-9">
                    <textarea class="form-control @error('notes') is-invalid @enderror"
                              id="notes"
                              name="notes"
                              rows="3"
                              placeholder="Masukkan catatan (opsional)"
                              style="border-radius: 8px; padding: 10px; border: 1px solid #e2e8f0;">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <hr class="my-4">

            <!-- Info Box -->
            <div class="alert" style="background-color: #f0f4ff; border: 1px solid #d0dcf7; border-radius: 8px; color: #2d3748;">
                <div class="d-flex align-items-start">
                    <i class="fas fa-info-circle mt-1 mr-2" style="color: #5b6fe8; font-size: 1.2rem;"></i>
                    <div>
                        <strong>Informasi Peminjaman:</strong>
                        <ul class="mb-0 mt-2 pl-3">
                            <li>Maksimal peminjaman adalah 14 hari</li>
                            <li>Peminjam hanya dapat meminjam maksimal 3 buku sekaligus</li>
                            <li>Keterlambatan pengembalian akan dikenakan denda</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="form-group row mt-4">
                <div class="col-sm-9 offset-sm-3">
                    <button type="submit" class="btn text-white" style="background: linear-gradient(135deg, #5b6fe8 0%, #7685f5 100%); border: none; border-radius: 8px; padding: 10px 30px;">
                        <i class="fas fa-save mr-1"></i> Simpan Peminjaman
                    </button>
                    <a href="{{ route('peminjaman.daftar') }}" class="btn btn-secondary ml-2" style="border-radius: 8px; padding: 10px 30px;">
                        <i class="fas fa-times mr-1"></i> Batal
                    </a>
                </div>
            </div>

        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {

    // Set minimum date to today
    var today = new Date().toISOString().split('T')[0];
    $('#borrow_date').attr('min', today);

    // Auto-calculate due date (7 days from borrow date by default)
    $('#borrow_date').on('change', function() {
        var borrowDate = new Date($(this).val());
        var dueDate = new Date(borrowDate);
        dueDate.setDate(dueDate.getDate() + 7); // Default 7 days

        var dueDateString = dueDate.toISOString().split('T')[0];
        $('#due_date').val(dueDateString);

        // Set min and max for due date
        $('#due_date').attr('min', $(this).val());

        var maxDate = new Date(borrowDate);
        maxDate.setDate(maxDate.getDate() + 14); // Max 14 days
        $('#due_date').attr('max', maxDate.toISOString().split('T')[0]);
    });

    // Validate due date on change
    $('#due_date').on('change', function() {
        var borrowDate = new Date($('#borrow_date').val());
        var dueDate = new Date($(this).val());
        var diffDays = Math.ceil((dueDate - borrowDate) / (1000 * 60 * 60 * 24));

        if (diffDays > 14) {
            alert('Maksimal peminjaman adalah 14 hari!');
            var maxDate = new Date(borrowDate);
            maxDate.setDate(maxDate.getDate() + 14);
            $(this).val(maxDate.toISOString().split('T')[0]);
        }

        if (dueDate < borrowDate) {
            alert('Tanggal kembali tidak boleh lebih awal dari tanggal pinjam!');
            $(this).val('');
        }
    });

    // Form validation
    $('form').on('submit', function(e) {
        var userId = $('#user_id').val();
        var bookItemId = $('#book_item_id').val();
        var borrowDate = $('#borrow_date').val();
        var dueDate = $('#due_date').val();

        if (!userId || !bookItemId || !borrowDate || !dueDate) {
            e.preventDefault();
            alert('Harap lengkapi semua field yang wajib diisi!');
            return false;
        }
    });

});
</script>
@endpush --}}
