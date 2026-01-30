<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TransactionController;
use App\Models\Book;

// 1. Halaman Depan (Landing Page)
Route::get('/', function () {
    return view('landing');
})->name('home');

Route::get('/welkom', function () {
    return view('welcome');
});

// 2. Route Login & Logout (Hanya bisa diakses tamu)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 3. Route Khusus Admin (Wajib Login & Wajib Admin)
Route::middleware(['auth'])->group(function () {

    // Dashboard Admin
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/transactions', [TransactionController::class, 'indexAdmin'])->name('admin.transactions');

    Route::post('/admin/return/{id}', [TransactionController::class, 'adminReturn'])->name('admin.return');


    Route::get('/my-books', [TransactionController::class, 'history'])->name('student.history');
    Route::post('/kembalikan/{id}', [TransactionController::class, 'kembalikan'])->name('buku.kembalikan');

    // CRUD Buku
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');

    Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');

    // Dashboard Siswa
    Route::get('/student/dashboard', [StudentController::class, 'index'])->name('student.dashboard');

    Route::post('/pinjam/{bookId}', [TransactionController::class, 'pinjam'])->name('pinjam.buku');
});
