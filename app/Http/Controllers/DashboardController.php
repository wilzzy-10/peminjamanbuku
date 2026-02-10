<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            return $this->adminDashboard();
        } elseif (auth()->user()->isPetugas()) {
            return $this->petukasDashboard();
        }

        return $this->userDashboard();
    }

    private function adminDashboard()
    {
        $totalBooks = Book::count();
        $totalUsers = User::count();
        $activeLoans = Loan::where('status', 'active')->count();
        $overdueLoans = Loan::where('status', '!=', 'returned')
                            ->where('due_date', '<', now())
                            ->count();

        $recentLoans = Loan::with('user', 'book')
                          ->latest()
                          ->limit(10)
                          ->get();

        return view('admin.dashboard', compact(
            'totalBooks',
            'totalUsers',
            'activeLoans',
            'overdueLoans',
            'recentLoans'
        ));
    }

    private function petukasDashboard()
    {
        $totalBooks = Book::count();
        $pendingLoans = Loan::where('status', 'pending')->count();
        $returningLoans = Loan::where('status', 'active')->count();
        $overdueLoans = Loan::where('status', '!=', 'returned')
                            ->where('due_date', '<', now())
                            ->count();

        return view('petugas.dashboard', compact(
            'totalBooks',
            'pendingLoans',
            'returningLoans',
            'overdueLoans'
        ));
    }

    private function userDashboard()
    {
        $user = auth()->user();
        $activeLoans = $user->loans()->where('status', 'active')->with('book')->get();
        $returnedLoans = $user->loans()->where('status', 'returned')->with('book')->count();
        $overdueLoans = $user->loans()->where('status', 'active')
                                    ->where('due_date', '<', now())
                                    ->count();

        return view('user.dashboard', compact(
            'activeLoans',
            'returnedLoans',
            'overdueLoans'
        ));
    }

    private function memberDashboard()
    {
        // Backward compatibility
        return $this->userDashboard();
}

}