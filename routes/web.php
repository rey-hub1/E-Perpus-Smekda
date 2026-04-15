<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\IconController;
use App\Http\Controllers\SettingController;
use App\Models\Book;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Category;

// 1. Halaman Depan (Landing Page)
Route::get('/', function () {
    $favBook = Book::where('featured', 1)->take(5)->get();
    $popularBooks = Book::withCount('transactions')
        ->orderByDesc('transactions_count')
        ->orderByDesc('read_count')
        ->take(6)
        ->get();
    $stats = [
        'buku'      => Book::count(),
        'siswa'     => User::where('role', 'siswa')->count(),
        'transaksi' => Transaction::count(),
        'kategori'  => Category::count(),
    ];
    return view('landing', compact('favBook', 'popularBooks', 'stats'));
})->name('landing');



// 2. Route Login & Logout (Hanya bisa diakses tamu)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});


use App\Http\Controllers\CategoryController;

// 3. Route Khusus Admin (Wajib Login & Wajib Admin)
Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/student/home', [StudentController::class, 'home'])->name('student.home');
    Route::get('/student/katalog', [StudentController::class, 'katalog'])->name('student.katalog');

    Route::get('my-books', [TransactionController::class, 'history'])->name('student.history');
    Route::get('book/{book:slug}', [BookController::class, 'show'])->name('book.show');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::get('/library', [LibraryController::class, 'index'])->name('library');
    Route::post('/library/{book}', [LibraryController::class, 'store'])->name('library.store');
    Route::delete('/library/{book}', [LibraryController::class, 'destroy'])->name('library.destroy');

    Route::get('/pinjam/{bookId}', [TransactionController::class, 'showJadwal'])->name('pinjam.jadwal');
    Route::post('/pinjam/{bookId}', [TransactionController::class, 'pinjam'])->name('pinjam.buku');
    Route::post('/kembalikan/{id}', [TransactionController::class, 'kembalikan'])->name('buku.kembalikan');
    Route::post('/batalkan/{id}', [TransactionController::class, 'batalkan'])->name('buku.batalkan');

});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard Admin
    Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('transactions', [TransactionController::class, 'indexAdmin'])->name('transactions');

    Route::post('return/{id}', [TransactionController::class, 'adminReturn'])->name('return');
    Route::post('return-by-code', [TransactionController::class, 'adminReturnByCode'])->name('return.by-code');
    Route::post('pinjam/{id}', [TransactionController::class, 'adminPinjam'])->name('pinjam');
    Route::post('acc-ambil-by-code', [TransactionController::class, 'adminAccAmbilByCode'])->name('acc-ambil.by-code');
    Route::post('acc-ambil/{id}', [TransactionController::class, 'adminAccAmbil'])->name('acc-ambil');
    Route::post('batal-ambil/{id}', [TransactionController::class, 'adminBatalAmbil'])->name('batal-ambil');

    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // CRUD Buku
    Route::get('books', [BookController::class, 'index'])->name('books.index');
    Route::get('books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    Route::get('books/bulk-create', [BookController::class, 'bulkCreate'])->name('books.bulk-create');
    Route::post('books/bulk-store', [BookController::class, 'bulkStore'])->name('books.bulk-store');

    Route::get('books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::put('books/{book}', [BookController::class, 'update'])->name('books.update');
    Route::delete('books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
    Route::post('books/{book}/featured', [BookController::class, 'featured'])->name('books.featured');

    // CRUD Kategori
    Route::resource('categories', CategoryController::class);

    // Manajemen Icon
    Route::get('icons', [IconController::class, 'index'])->name('icons.index');
    Route::post('icons', [IconController::class, 'store'])->name('icons.store');
    Route::delete('icons/{icon}', [IconController::class, 'destroy'])->name('icons.destroy');

    // Pengaturan Sistem
    Route::get('settings', [SettingController::class, 'index'])->name('settings');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
});
