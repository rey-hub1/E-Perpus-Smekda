<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Models\Book;

// 1. Halaman Depan (Landing Page)
Route::get('/', function () {
    $favBook = Book::where('featured', 1)->take(4)->get();
    // dd($favBook);
    return view('landing', compact('favBook'));
})->name('home');



// 2. Route Login & Logout (Hanya bisa diakses tamu)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});


// 3. Route Khusus Admin (Wajib Login & Wajib Admin)
Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/student/home', [StudentController::class, 'home'])->name('student.home');
    Route::get('/student/katalog', [StudentController::class, 'katalog'])->name('student.katalog');

    Route::get('my-books', [TransactionController::class, 'history'])->name('student.history');
    Route::get('book/{book:slug}', [BookController::class, 'show'])->name('book.show');

    Route::post('/pinjam/{bookId}', [TransactionController::class, 'pinjam'])->name('pinjam.buku');
    Route::post('/kembalikan/{id}', [TransactionController::class, 'kembalikan'])->name('buku.kembalikan');
    Route::post('books/{book}/favorite', [BookController::class, 'favorite'])->name('books.favorite');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard Admin
    Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('transactions', [TransactionController::class, 'indexAdmin'])->name('transactions');

    Route::post('return/{id}', [TransactionController::class, 'adminReturn'])->name('return');
    Route::post('pinjam/{id}', [TransactionController::class, 'adminPinjam'])->name('pinjam');

    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // CRUD Buku
    Route::get('books', [BookController::class, 'index'])->name('books.index');
    Route::get('books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');

    Route::get('books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::put('books/{book}', [BookController::class, 'update'])->name('books.update');
    Route::delete('books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
    Route::post('books/{book}/featured', [BookController::class, 'featured'])->name('books.featured');
});
