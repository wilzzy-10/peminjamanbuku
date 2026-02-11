@extends('layouts.app')

@section('title', 'Manajemen Peminjaman')

@section('content')
<style>
    .loans-container {
        min-height: 100vh;
        padding: 40px 20px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    .loans-wrapper {
        max-width: 1400px;
        margin: 0 auto;
    }

    .loans-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 40px;
        margin-bottom: 30px;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.2);
        animation: slideDown 0.6s ease-out;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .header-content h1 {
        font-size: 2.3rem;
        font-weight: 700;
        color: white;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .header-content p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1rem;
        font-weight: 300;
    }

    .header-stats {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .stat-pill {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 10px 14px;
        border-radius: 10px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .search-section {
        background: white;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        animation: fadeInUp 0.6s ease-out;
    }

    .search-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 15px;
    }

    .search-card {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 14px;
        background: #f8fafc;
    }

    .search-card .label {
        font-size: 0.8rem;
        color: #718096;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        margin-bottom: 6px;
        font-weight: 700;
    }

    .search-card .value {
        font-size: 1.4rem;
        font-weight: 700;
        color: #2d3748;
        line-height: 1.2;
    }

    .loans-table-wrapper {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        animation: fadeInUp 0.7s ease-out;
    }

    .table-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 20px 25px;
        color: white;
        font-size: 1.1rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .table-header span {
        font-size: 0.85rem;
        font-weight: 500;
        opacity: 0.95;
    }

    .loans-table {
        width: 100%;
        border-collapse: collapse;
    }

    .loans-table thead {
        background: #f7fafc;
        border-bottom: 2px solid #e2e8f0;
    }

    .loans-table th {
        padding: 15px 18px;
        text-align: left;
        font-weight: 700;
        font-size: 0.82rem;
        color: #4a5568;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .loans-table tbody tr {
        border-bottom: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .loans-table tbody tr:hover {
        background-color: #f7fafc;
    }

    .loans-table td {
        padding: 15px 18px;
        color: #4a5568;
        font-size: 0.92rem;
        vertical-align: top;
    }

    .name-link {
        color: #2d3748;
        font-weight: 600;
        text-decoration: none;
    }

    .name-link:hover {
        color: #667eea;
    }

    .muted {
        font-size: 0.82rem;
        color: #718096;
        margin-top: 2px;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        border-radius: 20px;
        font-size: 0.82rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .status-returned {
        background: linear-gradient(135deg, rgba(72, 187, 120, 0.1) 0%, rgba(56, 161, 105, 0.1) 100%);
        color: #22543d;
    }

    .status-overdue {
        background: linear-gradient(135deg, rgba(245, 101, 101, 0.1) 0%, rgba(229, 62, 62, 0.1) 100%);
        color: #742a2a;
    }

    .status-active {
        background: linear-gradient(135deg, rgba(237, 137, 54, 0.1) 0%, rgba(221, 107, 32, 0.1) 100%);
        color: #7c2d12;
    }

    .status-pending {
        background: linear-gradient(135deg, rgba(246, 173, 85, 0.15) 0%, rgba(237, 137, 54, 0.15) 100%);
        color: #7b341e;
    }

    .status-rejected {
        background: linear-gradient(135deg, rgba(160, 174, 192, 0.2) 0%, rgba(113, 128, 150, 0.2) 100%);
        color: #2d3748;
    }

    .table-btn {
        padding: 8px 12px;
        border: none;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        color: white;
    }

    .table-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(72, 187, 120, 0.3);
    }

    .table-btn.warning {
        background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);
    }

    .table-btn.danger {
        background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
    }

    .empty-state {
        padding: 60px 40px;
        text-align: center;
        color: #718096;
    }

    .empty-state-icon {
        font-size: 4rem;
        margin-bottom: 20px;
        opacity: 0.5;
        color: #cbd5e0;
    }

    .empty-state h3 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 10px;
        color: #4a5568;
    }

    .pagination-wrapper {
        padding: 25px 20px;
        background: #f7fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: center;
    }

    @media (max-width: 1024px) {
        .search-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .loans-container {
            padding: 20px 15px;
        }

        .loans-header {
            padding: 30px 20px;
            flex-direction: column;
            align-items: flex-start;
        }

        .header-content h1 {
            font-size: 1.8rem;
        }

        .search-grid {
            grid-template-columns: 1fr;
        }

        .loans-table {
            min-width: 1000px;
        }
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="loans-container">
    <div class="loans-wrapper">
        @php
            $pendingCount = $loans->where('status', 'pending')->count();
            $activeCount = $loans->where('status', 'active')->count();
            $returnedCount = $loans->where('status', 'returned')->count();
            $overdueCount = $loans->filter(fn($loan) => $loan->status === 'active' && $loan->isOverdue())->count();
            $totalCount = method_exists($loans, 'total') ? $loans->total() : $loans->count();
        @endphp

        <div class="loans-header">
            <div class="header-content">
                <h1>
                    <i class="fas fa-book-open-reader"></i> Manajemen Peminjaman
                </h1>
                <p>Kelola status peminjaman dan proses pengembalian buku dengan cepat</p>
            </div>
            <div class="header-stats">
                <span class="stat-pill"><i class="fas fa-list"></i> Total: {{ $totalCount }}</span>
                <span class="stat-pill"><i class="fas fa-hourglass-half"></i> Pending: {{ $pendingCount }}</span>
                <span class="stat-pill"><i class="fas fa-clock"></i> Aktif: {{ $activeCount }}</span>
                <span class="stat-pill"><i class="fas fa-check-circle"></i> Kembali: {{ $returnedCount }}</span>
                <span class="stat-pill"><i class="fas fa-triangle-exclamation"></i> Overdue: {{ $overdueCount }}</span>
            </div>
        </div>

        <div class="search-section">
            <div class="search-grid">
                <div class="search-card">
                    <p class="label">Data Halaman Ini</p>
                    <p class="value">{{ $loans->count() }}</p>
                </div>
                <div class="search-card">
                    <p class="label">Pinjaman Aktif</p>
                    <p class="value">{{ $activeCount }}</p>
                </div>
                <div class="search-card">
                    <p class="label">Terlambat</p>
                    <p class="value">{{ $overdueCount }}</p>
                </div>
                <div class="search-card">
                    <p class="label">Terakhir Diperbarui</p>
                    <p class="value" style="font-size: 1rem;">{{ now()->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        <div class="loans-table-wrapper">
            <div class="table-header">
                <div><i class="fas fa-table"></i> Daftar Peminjaman</div>
                <span>{{ $totalCount }} Total Data</span>
            </div>

            @if($loans->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="loans-table">
                        <thead>
                            <tr>
                                <th>Peminjam</th>
                                <th>Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Batas Kembali</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                                <th>Catatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($loans as $loan)
                                <tr>
                                    <td>
                                        <a href="{{ route('profile.show', $loan->user) }}" class="name-link">
                                            {{ $loan->user->name }}
                                        </a>
                                        <p class="muted">{{ $loan->user->email }}</p>
                                    </td>
                                    <td>
                                        <a href="{{ route('books.show', $loan->book) }}" class="name-link">
                                            {{ $loan->book->title }}
                                        </a>
                                        <p class="muted">{{ $loan->book->author }}</p>
                                    </td>
                                    <td>{{ $loan->loan_date->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if($loan->status === 'active' && $loan->isOverdue())
                                            <span style="color: #e53e3e; font-weight: 600;">
                                                {{ $loan->due_date->format('d/m/Y') }}
                                            </span>
                                            <p class="muted" style="color: #e53e3e;">{{ $loan->getDaysOverdue() }} hari terlambat</p>
                                        @else
                                            {{ $loan->due_date->format('d/m/Y') }}
                                        @endif
                                    </td>
                                    <td>{{ $loan->return_date ? $loan->return_date->format('d/m/Y H:i') : '-' }}</td>
                                    <td>
                                        @if($loan->status === 'pending')
                                            <span class="status-badge status-pending">
                                                <i class="fas fa-hourglass-half"></i> Pending
                                            </span>
                                        @elseif($loan->status === 'returned')
                                            <span class="status-badge status-returned">
                                                <i class="fas fa-check-circle"></i> Dikembalikan
                                            </span>
                                        @elseif($loan->status === 'rejected')
                                            <span class="status-badge status-rejected">
                                                <i class="fas fa-ban"></i> Ditolak
                                            </span>
                                        @elseif($loan->isOverdue())
                                            <span class="status-badge status-overdue">
                                                <i class="fas fa-exclamation-circle"></i> Overdue
                                            </span>
                                        @else
                                            <span class="status-badge status-active">
                                                <i class="fas fa-clock"></i> Aktif
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $loan->notes ?: '-' }}</td>
                                    <td>
                                        @if($loan->status === 'pending')
                                            <div style="display:flex; gap:8px; flex-wrap:wrap;">
                                                <form method="POST" action="{{ route('loans.approve', $loan) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="table-btn warning">
                                                        <i class="fas fa-check"></i> Setujui
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('loans.reject', $loan) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="table-btn danger">
                                                        <i class="fas fa-times"></i> Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif($loan->status === 'active')
                                            <form method="POST" action="{{ route('loans.verify-return', $loan) }}">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="table-btn">
                                                    <i class="fas fa-check"></i> Verifikasi Kembali
                                                </button>
                                            </form>
                                        @else
                                            <span class="muted">Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="pagination-wrapper">
                    {{ $loans->links() }}
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-inbox"></i>
                    </div>
                    <h3>Belum Ada Data Peminjaman</h3>
                    <p>Data peminjaman akan tampil di sini setelah transaksi dibuat.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
