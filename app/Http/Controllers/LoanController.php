<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Book;
use App\Support\ActivityLogger;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');
        $loans = $this->buildLoanListQuery($status)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('loans.index', compact('loans'));
    }

    public function approvalWorkspace(Request $request)
    {
        return $this->petugasWorkspace(
            $request,
            'pending',
            'Menyetujui Persetujuan',
            'Review dan setujui permintaan peminjaman yang masuk.'
        );
    }

    public function returnVerificationWorkspace(Request $request)
    {
        return $this->petugasWorkspace(
            $request,
            'active',
            'Verifikasi Pengembalian',
            'Verifikasi buku yang sedang dipinjam dan selesaikan pengembalian.'
        );
    }

    public function overdueMonitoringWorkspace(Request $request)
    {
        return $this->petugasWorkspace(
            $request,
            'overdue',
            'Monitor Keterlambatan',
            'Pantau pinjaman aktif yang sudah melewati batas pengembalian.'
        );
    }

    public function myLoans()
    {
        $loans = auth()->user()
            ->loans()
            ->with('book')
            ->latest()
            ->paginate(10);

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
                            ->whereIn('status', ['pending', 'active'])
                            ->first();

        if ($existingLoan) {
            return redirect()->route('books.show', $book)->with('error', 'Anda sudah memiliki permintaan/peminjaman yang masih berjalan untuk buku ini');
        }


        $loanDate = Carbon::now();
        $loanDays = (int) $validated['loan_days'];
        $dueDate = $loanDate->copy()->addDays($loanDays);

        $loan = Loan::create([
            'user_id' => auth()->id(),
            'book_id' => $book->id,
            'loan_date' => $loanDate,
            'due_date' => $dueDate,
            'status' => 'pending',
            'notes' => 'Menunggu persetujuan petugas',
        ]);

        ActivityLogger::log(
            'loan.requested',
            'User mengajukan peminjaman buku',
            [
                'loan_id' => $loan->id,
                'book_id' => $book->id,
                'loan_days' => $loanDays,
            ]
        );

        return redirect()->route('loans.my-loans')->with('success', 'Permintaan peminjaman berhasil dikirim dan menunggu persetujuan petugas');
    }

    public function return(Loan $loan)
    {
        if ($loan->user_id !== auth()->id()) {
            return redirect()->route('loans.my-loans')->with('error', 'Anda tidak memiliki akses ke data peminjaman ini');
        }

        if ($loan->status === 'pending') {
            return redirect()->route('loans.my-loans')->with('error', 'Peminjaman masih menunggu persetujuan petugas');
        }

        if ($loan->status === 'returned') {
            return redirect()->route('loans.my-loans')->with('error', 'Buku sudah dikembalikan');
        }

        if ($loan->status === 'rejected') {
            return redirect()->route('loans.my-loans')->with('error', 'Peminjaman ini ditolak oleh petugas');
        }

        $loan->update([
            'return_date' => Carbon::now(),
            'status' => 'returned',
            'notes' => 'Dikembalikan oleh user',
        ]);

        // Increase available quantity
        $loan->book->increment('available_quantity');

        ActivityLogger::log(
            'loan.returned_by_user',
            'User mengembalikan buku',
            [
                'loan_id' => $loan->id,
                'book_id' => $loan->book_id,
            ]
        );

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
            'notes' => 'Ditutup oleh admin',
        ]);

        // Increase available quantity
        $loan->book->increment('available_quantity');

        ActivityLogger::log(
            'loan.closed_by_admin',
            'Admin menutup peminjaman (pengembalian)',
            [
                'loan_id' => $loan->id,
                'book_id' => $loan->book_id,
            ]
        );

        return redirect()->route('loans.index')->with('success', 'Peminjaman ditutup');
    }

    public function approve(Loan $loan)
    {
        if (!auth()->user()->isPetugas() && !auth()->user()->isAdmin()) {
            return redirect()->route('loans.index')->with('error', 'Anda tidak memiliki akses ke fitur ini');
        }

        if ($loan->status !== 'pending') {
            return redirect()->route('loans.index')->with('error', 'Hanya peminjaman berstatus pending yang bisa disetujui');
        }

        if (!$loan->book || !$loan->book->isAvailable()) {
            return redirect()->route('loans.index')->with('error', 'Stok buku tidak tersedia');
        }

        $requestedDays = max(1, $loan->loan_date->diffInDays($loan->due_date));
        $approvedAt = Carbon::now();

        $loan->update([
            'loan_date' => $approvedAt,
            'due_date' => $approvedAt->copy()->addDays($requestedDays),
            'status' => 'active',
            'notes' => 'Disetujui oleh petugas',
        ]);

        $loan->book->decrement('available_quantity');

        ActivityLogger::log(
            'loan.approved',
            'Petugas menyetujui peminjaman buku',
            [
                'loan_id' => $loan->id,
                'book_id' => $loan->book_id,
                'user_id' => $loan->user_id,
            ]
        );

        return redirect()->route('loans.index')->with('success', 'Peminjaman berhasil disetujui');
    }

    public function reject(Loan $loan)
    {
        if (!auth()->user()->isPetugas() && !auth()->user()->isAdmin()) {
            return redirect()->route('loans.index')->with('error', 'Anda tidak memiliki akses ke fitur ini');
        }

        if ($loan->status !== 'pending') {
            return redirect()->route('loans.index')->with('error', 'Hanya peminjaman berstatus pending yang bisa ditolak');
        }

        $loan->update([
            'status' => 'rejected',
            'notes' => 'Ditolak oleh petugas',
        ]);

        ActivityLogger::log(
            'loan.rejected',
            'Petugas menolak peminjaman buku',
            [
                'loan_id' => $loan->id,
                'book_id' => $loan->book_id,
                'user_id' => $loan->user_id,
            ]
        );

        return redirect()->route('loans.index')->with('success', 'Peminjaman berhasil ditolak');
    }

    public function verifyReturn(Loan $loan)
    {
        if (!auth()->user()->isPetugas() && !auth()->user()->isAdmin()) {
            return redirect()->route('loans.index')->with('error', 'Anda tidak memiliki akses ke fitur ini');
        }

        if ($loan->status !== 'active') {
            return redirect()->route('loans.index')->with('error', 'Hanya peminjaman aktif yang bisa diverifikasi pengembaliannya');
        }

        $loan->update([
            'return_date' => Carbon::now(),
            'status' => 'returned',
            'notes' => 'Pengembalian diverifikasi petugas',
        ]);

        $loan->book->increment('available_quantity');

        ActivityLogger::log(
            'loan.return_verified',
            'Petugas memverifikasi pengembalian buku',
            [
                'loan_id' => $loan->id,
                'book_id' => $loan->book_id,
                'user_id' => $loan->user_id,
            ]
        );

        return redirect()->route('loans.index')->with('success', 'Pengembalian berhasil diverifikasi');
    }

    private function petugasWorkspace(
        Request $request,
        string $defaultStatus,
        string $pageTitle,
        string $pageSubtitle
    ) {
        if (!auth()->user()->isPetugas() && !auth()->user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke fitur ini');
        }

        $status = $request->input('status', $defaultStatus);
        $loans = $this->buildLoanListQuery($status)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('petugas.loans.workspace', compact('loans', 'status', 'pageTitle', 'pageSubtitle'));
    }

    private function buildLoanListQuery(?string $status)
    {
        $allowedStatuses = ['pending', 'active', 'returned', 'rejected', 'overdue'];

        return Loan::with('book', 'user')
            ->when(in_array($status, $allowedStatuses, true), function ($query) use ($status) {
                if ($status === 'overdue') {
                    $query->where('status', 'active')->where('due_date', '<', now());
                    return;
                }

                $query->where('status', $status);
            });
    }
}
