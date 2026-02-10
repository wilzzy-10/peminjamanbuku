<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Book;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with('book', 'user')->paginate(10);
        return view('loans.index', compact('loans'));
    }

    public function myLoans()
    {
        $loans = auth()->user()->loans()->with('book')->paginate(10);
        return view('loans.my-loans', compact('loans'));
    }

    public function create(Book $book)
    {
        if (!$book->isAvailable()) {
            return redirect()->route('books.show', $book)->with('error', 'Buku tidak tersedia untuk dipinjam');
        }

        return view('loans.create', compact('book'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'loan_days' => 'required|integer|min:1|max:30',
        ]);

        $book = Book::findOrFail($validated['book_id']);

        if (!$book->isAvailable()) {
            return redirect()->route('books.show', $book)->with('error', 'Buku tidak tersedia untuk dipinjam');
        }

        // Check if user already has an active loan for this book
        $existingLoan = Loan::where('user_id', auth()->id())
                            ->where('book_id', $book->id)
                            ->where('status', 'active')
                            ->first();

        if ($existingLoan) {
            return redirect()->route('books.show', $book)->with('error', 'Anda sudah memiliki peminjaman aktif untuk buku ini');
        }


        $loanDate = Carbon::now(); // WAJIB ADA DULU
        $loanDays = (int) $validated['loan_days'];
        $dueDate = $loanDate->copy()->addDays($loanDays);



        $loan = Loan::create([
            'user_id' => auth()->id(),
            'book_id' => $book->id,
            'loan_date' => $loanDate,
            'due_date' => $dueDate,
            'status' => 'active',
        ]);

        // Reduce available quantity
        $book->decrement('available_quantity');

        return redirect()->route('loans.my-loans')->with('success', 'Buku berhasil dipinjam');
    }

    public function return(Loan $loan)
    {
        if ($loan->status === 'returned') {
            return redirect()->route('loans.my-loans')->with('error', 'Buku sudah dikembalikan');
        }

        $loan->update([
            'return_date' => Carbon::now(),
            'status' => 'returned',
        ]);

        // Increase available quantity
        $loan->book->increment('available_quantity');

        return redirect()->route('loans.my-loans')->with('success', 'Buku berhasil dikembalikan');
    }

    public function adminReturn(Loan $loan)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('loans.index')->with('error', 'Anda tidak memiliki akses ke fitur ini');
        }

        if ($loan->status === 'returned') {
            return redirect()->route('loans.index')->with('error', 'Buku sudah dikembalikan');
        }

        $loan->update([
            'return_date' => Carbon::now(),
            'status' => 'returned',
        ]);

        // Increase available quantity
        $loan->book->increment('available_quantity');

        return redirect()->route('loans.index')->with('success', 'Peminjaman ditutup');
    }
}
