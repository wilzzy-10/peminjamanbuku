<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

// Redirect root to welcome or dashboard based on auth
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
})->name('home');

// Public routes
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/search', [BookController::class, 'search'])->name('books.search');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
    
    Route::post('/login', [\App\Http\Controllers\Auth\AuthController::class, 'login'])->name('login.post');
    
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');
    
    Route::post('/register', [\App\Http\Controllers\Auth\AuthController::class, 'register'])->name('register.post');
});

// Logout route (authenticated only)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('logout');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // User loans
    Route::get('/my-loans', [LoanController::class, 'myLoans'])->name('loans.my-loans');
    Route::get('/books/{book}/borrow', [LoanController::class, 'create'])->name('loans.create');
    Route::post('/books/{book}/borrow', [LoanController::class, 'store'])->name('loans.store');
    Route::put('/loans/{loan}/return', [LoanController::class, 'return'])->name('loans.return');

    // Petugas routes - Approval & Verification
    Route::middleware('petugas')->group(function () {
        // Loan approval & verification
        Route::get('/loans', [LoanController::class, 'index'])->name('loans.index');
        Route::put('/loans/{loan}/approve', [LoanController::class, 'approve'])->name('loans.approve');
        Route::put('/loans/{loan}/reject', [LoanController::class, 'reject'])->name('loans.reject');
        Route::put('/loans/{loan}/verify-return', [LoanController::class, 'verifyReturn'])->name('loans.verify-return');

        // Reports
        Route::get('/reports/loans', function () {
            return view('petugas.reports.loans');
        })->name('reports.loans');
    });

    // Admin routes
    Route::middleware('admin')->group(function () {
        // Dashboard admin sudah diakomodasi di DashboardController

        // Book management
        Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
        Route::post('/books', [BookController::class, 'store'])->name('books.store');
        Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
        Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
        Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');

        // Category management
        Route::resource('categories', CategoryController::class);

        // Loan management (full access)
        Route::get('/loans', [LoanController::class, 'index'])->name('loans.index');
        Route::put('/loans/{loan}/approve', [LoanController::class, 'approve'])->name('loans.approve');
        Route::put('/loans/{loan}/reject', [LoanController::class, 'reject'])->name('loans.reject');
        Route::put('/loans/{loan}/admin-return', [LoanController::class, 'adminReturn'])->name('loans.admin-return');

        // User management
        Route::resource('users', UserController::class);

        // Reports
        Route::get('/reports/loans', function () {
            return view('admin.reports.loans');
        })->name('reports.loans');
        Route::get('/reports/activity-logs', function () {
            return view('admin.reports.activity-logs');
        })->name('reports.activity-logs');
    });
});
