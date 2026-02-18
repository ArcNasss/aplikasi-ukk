<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamBookController;
use App\Http\Controllers\DendaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\ReturnController;
use GuzzleHttp\Middleware;

Route::get('/nama', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // User Management - menggunakan pattern resource controller
    Route::get('/users', [UserController::class, 'index'])->name('user.list');
    Route::get('/users/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/users', [UserController::class, 'store'])->name('user.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('user.delete');

    // Book Management - menggunakan pattern resource controller
    Route::get('/books', [BookController::class, 'index'])->name('book.list');
    Route::get('/books/create', [BookController::class, 'create'])->name('book.create');
    Route::post('/books', [BookController::class, 'store'])->name('book.store');
    Route::get('/books/{id}/edit', [BookController::class, 'edit'])->name('book.edit');
    Route::put('/books/{id}', [BookController::class, 'update'])->name('book.update');
    Route::delete('/books/{id}', [BookController::class, 'destroy'])->name('book.delete');

    // Book Items Management - mengelola kode buku & stok
    Route::get('/books/{id}/add-item', [BookController::class, 'addItem'])->name('book.addItem');
    Route::post('/books/{id}/add-item', [BookController::class, 'storeItem'])->name('book.storeItem');

    // Category Management - menggunakan pattern resource controller
    Route::get('/categories', [CategoryController::class, 'index'])->name('category.list');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('category.delete');

    // Admin: View Borrowings and Returns (Read Only)
    Route::get('/peminjaman', [BorrowController::class, 'adminIndex'])->name('admin.peminjaman.index');
    Route::post('/peminjaman/export', [BorrowController::class, 'adminExportExcel'])->name('admin.peminjaman.export');
    Route::get('/pengembalian', [ReturnController::class, 'adminIndex'])->name('admin.pengembalian.index');

    // Admin: View Denda (Read Only)
    Route::get('/denda', [DendaController::class, 'adminIndex'])->name('admin.denda.index');
    Route::get('/denda/invoice/{userId}', [DendaController::class, 'downloadInvoice'])->name('admin.denda.downloadInvoice');
});

// Peminjam Routes
Route::middleware(['auth', 'role:peminjam'])->prefix('peminjam')->group(function () {

    Route::get('/riwayat', [PeminjamBookController::class, 'history'])->name('peminjam.history');

    Route::post('/borrow', [BorrowController::class, 'store'])->name('peminjam.borrow.store');
});

Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'petugasDashboard'])->name('petugas.dashboard');
    Route::get('/peminjaman', [BorrowController::class, 'index'])->name('peminjaman.index');
    Route::post('/peminjaman/export', [BorrowController::class, 'exportExcel'])->name('peminjaman.export');
    Route::patch('/peminjaman/{id}/approve', [BorrowController::class, 'approve'])->name('peminjaman.approve');
    Route::patch('/peminjaman/{id}/reject', [BorrowController::class, 'reject'])->name('peminjaman.reject');
    Route::get('/peminjaman/{id}/print-card', [BorrowController::class, 'printCard'])->name('peminjaman.printCard');
    Route::get('/peminjaman/{id}/download-card', [BorrowController::class, 'downloadCard'])->name('peminjaman.downloadCard');

    Route::get('/pengembalian', [ReturnController::class, 'index'])->name('pengembalian.index');
    Route::get('/pengembalian/create', [ReturnController::class, 'create'])->name('pengembalian.create');
    Route::post('/pengembalian', [ReturnController::class, 'store'])->name('pengembalian.store');

    // Denda
    Route::get('/denda', [DendaController::class, 'index'])->name('denda.index');
    Route::patch('/denda/{id}/mark-paid', [DendaController::class, 'markAsPaid'])->name('denda.markPaid');
    Route::get('/denda/invoice/{userId}', [DendaController::class, 'downloadInvoice'])->name('denda.downloadInvoice');
});


Route::get('/', [PeminjamBookController::class, 'index'])->name('peminjam.book.list');
Route::get('/katalog/{id}', [PeminjamBookController::class, 'show'])->name('peminjam.book.show');


