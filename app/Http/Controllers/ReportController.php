<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function loanReport(Request $request)
    {
        $days = (int) $request->input('days', 30);
        $days = in_array($days, [7, 30, 90, 365], true) ? $days : 30;

        $startDate = Carbon::now()->subDays($days)->startOfDay();

        $baseQuery = Loan::query()->where('created_at', '>=', $startDate);

        $summary = [
            'total' => (clone $baseQuery)->count(),
            'pending' => (clone $baseQuery)->where('status', 'pending')->count(),
            'active' => (clone $baseQuery)->where('status', 'active')->count(),
            'returned' => (clone $baseQuery)->where('status', 'returned')->count(),
            'rejected' => (clone $baseQuery)->where('status', 'rejected')->count(),
            'overdue' => (clone $baseQuery)
                ->where('status', 'active')
                ->where('due_date', '<', now())
                ->count(),
        ];

        $dailyLoans = (clone $baseQuery)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        $topBooks = Loan::query()
            ->with('book:id,title,author')
            ->selectRaw('book_id, COUNT(*) as total')
            ->where('created_at', '>=', $startDate)
            ->groupBy('book_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $recentLoans = Loan::with(['user:id,name,email,role', 'book:id,title,author'])
            ->latest()
            ->limit(15)
            ->get();

        $view = auth()->user()->isAdmin()
            ? 'admin.reports.loans'
            : 'petugas.reports.loans';

        return view($view, compact('days', 'summary', 'dailyLoans', 'topBooks', 'recentLoans'));
    }

    public function activityLogs(Request $request)
    {
        $action = $request->string('action')->toString();
        $role = $request->string('role')->toString();
        $search = $request->string('search')->toString();

        $logs = ActivityLog::query()
            ->with('user:id,name,email,role')
            ->when($action !== '', fn ($q) => $q->where('action', $action))
            ->when($role !== '', fn ($q) => $q->where('role', $role))
            ->when($search !== '', function ($q) use ($search) {
                $q->where('description', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                    });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $totalLogs = ActivityLog::count();
        $todayLogs = ActivityLog::whereDate('created_at', today())->count();
        $uniqueUsersToday = ActivityLog::whereDate('created_at', today())
            ->whereNotNull('user_id')
            ->distinct('user_id')
            ->count('user_id');

        $availableActions = ActivityLog::query()
            ->select('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action');

        return view('admin.reports.activity-logs', compact(
            'logs',
            'totalLogs',
            'todayLogs',
            'uniqueUsersToday',
            'availableActions'
        ));
    }

    public function loanExportPage(Request $request)
    {
        if (!auth()->user()->isPetugas() && !auth()->user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke fitur ini');
        }

        $days = (int) $request->input('days', 30);
        $days = in_array($days, [7, 30, 90, 365], true) ? $days : 30;

        return view('petugas.reports.export', compact('days'));
    }

    public function exportLoansCsv(Request $request): StreamedResponse
    {
        if (!auth()->user()->isPetugas() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $days = (int) $request->input('days', 30);
        $days = in_array($days, [7, 30, 90, 365], true) ? $days : 30;

        $status = $request->string('status')->toString();
        $allowedStatuses = ['pending', 'active', 'returned', 'rejected', 'overdue'];
        $status = in_array($status, $allowedStatuses, true) ? $status : '';

        $startDate = Carbon::now()->subDays($days)->startOfDay();

        $rows = Loan::query()
            ->with(['user:id,name,email', 'book:id,title,author'])
            ->where('created_at', '>=', $startDate)
            ->when($status !== '', function ($query) use ($status) {
                if ($status === 'overdue') {
                    $query->where('status', 'active')->where('due_date', '<', now());
                    return;
                }

                $query->where('status', $status);
            })
            ->orderByDesc('created_at')
            ->get();

        $filename = 'laporan-peminjaman-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($rows) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'ID',
                'Peminjam',
                'Email',
                'Buku',
                'Penulis',
                'Tanggal Pinjam',
                'Jatuh Tempo',
                'Tanggal Kembali',
                'Status',
                'Catatan',
            ]);

            foreach ($rows as $loan) {
                $isOverdue = $loan->status === 'active' && $loan->due_date->lt(now());
                fputcsv($handle, [
                    $loan->id,
                    $loan->user->name ?? '-',
                    $loan->user->email ?? '-',
                    $loan->book->title ?? '-',
                    $loan->book->author ?? '-',
                    optional($loan->loan_date)->format('Y-m-d H:i:s'),
                    optional($loan->due_date)->format('Y-m-d H:i:s'),
                    optional($loan->return_date)->format('Y-m-d H:i:s'),
                    $isOverdue ? 'overdue' : $loan->status,
                    $loan->notes,
                ]);
            }

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}
