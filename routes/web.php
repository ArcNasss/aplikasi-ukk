<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
Route::get('/nama', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register');


Route::middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard
    Route::get('/dashboardadmin', [DashboardController::class, 'index'])->name('dashboard');

    // User Management - menggunakan pattern resource controller
    Route::get('/users', [UserController::class, 'index'])->name('user.list');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('user.delete');

    // Book Management - menggunakan pattern resource controller
    Route::get('/books', [BookController::class, 'index'])->name('book.list');
    Route::delete('/books/{id}', [BookController::class, 'destroy'])->name('book.delete');

    // Category Management - menggunakan pattern resource controller
    Route::get('/categories', [CategoryController::class, 'index'])->name('category.list');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('category.delete');
});
