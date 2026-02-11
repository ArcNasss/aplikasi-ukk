<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamBookController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BorrowController;
Route::get('/nama', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth', 'role:admin'])->group(function () {
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
});

// Peminjam Routes
Route::middleware(['auth', 'role:peminjam'])->group(function () {
    Route::get('/katalog', [PeminjamBookController::class, 'index'])->name('peminjam.book.list');
    Route::get('/katalog/{id}', [PeminjamBookController::class, 'show'])->name('peminjam.book.show');

    Route::post('/borrow', [BorrowController::class, 'store'])->name('peminjam.borrow.store');
});
