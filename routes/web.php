<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
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
    Route::get('/dashboardadmin', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [UserController::class, 'listUsers'])->name('user.list');
    Route::delete('/users/{id}', [UserController::class, 'deleteUser'])->name('user.delete');

    Route::get('/books', [BookController::class, 'listBooks'])->name('book.list');
    Route::delete('/books/{id}', [BookController::class, 'deleteBook'])->name('book.delete');
});
