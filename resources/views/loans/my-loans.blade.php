@extends('layouts.app')

@section('title', 'Peminjaman Saya')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .loans-container {
        min-height: 100vh;
        padding: 40px 20px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    .loans-wrapper {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Header Section */
    .loans-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 40px;
        color: white;
        margin-bottom: 40px;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.2);
        animation: slideDown 0.6s ease-out;
    }

    .loans-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .loans-header h1 i {
        font-size: 2.8rem;
    }

    .loans-header p {
        font-size: 1.1rem;
        opacity: 0.9;
        font-weight: 300;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        animation: fadeInUp 0.6s ease-out;
        border-left: 5px solid transparent;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
    }

    .stat-card.active {
        border-left-color: #667eea;
    }

    .stat-card.returned {
        border-left-color: #48bb78;
    }

    .stat-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .stat-info h3 {
        color: #718096;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stat-card.returned .stat-number {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stat-icon {
        font-size: 3rem;
        opacity: 0.2;
        color: #667eea;
        margin-left: 20px;
    }

    .stat-card.returned .stat-icon {
        color: #48bb78;
    }

    /* Loans Table Section */
    .loans-section {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        animation: fadeInUp 0.7s ease-out;
    }

    .loans-section-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 25px 30px;
        color: white;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 1.3rem;
        font-weight: 700;
    }

    .loans-section-header i {
        font-size: 1.5rem;
    }

    /* Table Styling */
    .loans-table {
        width: 100%;
        border-collapse: collapse;
    }

    .loans-table thead {
        background: #f7fafc;
        border-bottom: 2px solid #e2e8f0;
    }

    .loans-table th {
        padding: 18px;
        text-align: left;
        font-weight: 700;
        font-size: 0.85rem;
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
        transform: scale(1.01);
    }

    .loans-table td {
        padding: 18px;
        color: #4a5568;
        font-size: 0.95rem;
    }

    .book-title {
        font-weight: 600;
        color: #667eea;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .book-title:hover {
        color: #764ba2;
        text-decoration: underline;
    }

    /* Status Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .status-returned {
        background: linear-gradient(135deg, rgba(72, 187, 120, 0.1) 0%, rgba(56, 161, 105, 0.1) 100%);
        color: #22543d;
        border-left: 3px solid #48bb78;
    }

    .status-overdue {
        background: linear-gradient(135deg, rgba(245, 101, 101, 0.1) 0%, rgba(229, 62, 62, 0.1) 100%);
        color: #742a2a;
        border-left: 3px solid #f56565;
        font-weight: 700;
    }

    .status-active {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        color: #2d3748;
        border-left: 3px solid #667eea;
    }

    /* Action Buttons */
    .action-button {
        padding: 8px 16px;
        border: none;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .return-button {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        color: white;
        border: none;
    }

    .return-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(72, 187, 120, 0.3);
    }

    .return-button:active {
        transform: translateY(0);
    }

    /* Empty State */
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

    .empty-state p {
        font-size: 1.05rem;
        margin-bottom: 25px;
        color: #718096;
    }

    .empty-state-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 12px 24px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .empty-state-link:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }

    /* Pagination */
    .pagination-wrapper {
        padding: 25px 30px;
        background: #f7fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: center;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .loans-container {
            padding: 20px 15px;
        }

        .loans-header {
            padding: 30px 20px;
        }

        .loans-header h1 {
            font-size: 1.8rem;
        }

        .loans-header p {
            font-size: 0.95rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .loans-table {
            font-size: 0.85rem;
        }

        .loans-table th,
        .loans-table td {
            padding: 12px;
        }

        .loans-section-header {
            padding: 20px;
            font-size: 1.1rem;
        }

        .empty-state {
            padding: 40px 20px;
        }

        .empty-state-icon {
            font-size: 3rem;
        }

        .empty-state h3 {
            font-size: 1.3rem;
        }
    }

    /* Animations */
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
        <!-- Header -->
        <div class="loans-header">
            <h1>
                <i class="fas fa-list"></i> Peminjaman Saya
            </h1>
            <p>Kelola dan lihat riwayat peminjaman buku Anda</p>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card active">
                <div class="stat-content">
                    <div class="stat-info">
                        <h3>Peminjaman Aktif</h3>
                        <div class="stat-number">
                            {{ $loans->where('status', 'active')->count() }}
                        </div>
                    </div>
                    <i class="fas fa-book-reader stat-icon"></i>
                </div>
            </div>

            <div class="stat-card returned">
                <div class="stat-content">
                    <div class="stat-info">
                        <h3>Sudah Dikembalikan</h3>
                        <div class="stat-number">
                            {{ $loans->where('status', 'returned')->count() }}
                        </div>
                    </div>
                    <i class="fas fa-check-circle stat-icon"></i>
                </div>
            </div>
        </div>

        <!-- Loans Table -->
        <div class="loans-section">
            <div class="loans-section-header">
                <i class="fas fa-history"></i> Riwayat Peminjaman
            </div>

            @if($loans->count() > 0)
                <table class="loans-table">
                    <thead>
                        <tr>
                            <th>Judul Buku</th>
                            <th>Pengarang</th>
                            <th>Tanggal Peminjaman</th>
                            <th>Batas Kembali</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($loans as $loan)
                            <tr>
                                <td>
                                    <a href="{{ route('books.show', ['book' => $loan->book->id]) }}" class="book-title">
                                        {{ $loan->book->title }}
                                    </a>
                                </td>
                                <td>{{ $loan->book->author }}</td>
                                <td>{{ $loan->loan_date->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if($loan->status === 'active' && $loan->isOverdue())
                                        <span style="color: #f56565; font-weight: 700;">
                                            {{ $loan->due_date->format('d/m/Y') }}
                                            <div style="font-size: 0.85rem; color: #c53030;">
                                                ({{ $loan->getDaysOverdue() }} hari terlambat)
                                            </div>
                                        </span>
                                    @else
                                        {{ $loan->due_date->format('d/m/Y') }}
                                    @endif
                                </td>
                                <td>{{ $loan->return_date ? $loan->return_date->format('d/m/Y H:i') : '-' }}</td>
                                <td>
                                    @if($loan->status === 'returned')
                                        <span class="status-badge status-returned">
                                            <i class="fas fa-check"></i> Dikembalikan
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
                                <td>
                                    @if($loan->status === 'active')
                                        <form method="POST" action="{{ route('loans.return', ['loan' => $loan->id]) }}" style="display: inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="action-button return-button">
                                                <i class="fas fa-undo"></i> Kembalikan
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="pagination-wrapper">
                    {{ $loans->links() }}
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-inbox"></i>
                    </div>
                    <h3>Anda belum memiliki riwayat peminjaman</h3>
                    <p>Mulai jelajahi koleksi buku perpustakaan sekarang</p>
                    <a href="{{ route('books.index') }}" class="empty-state-link">
                        <i class="fas fa-book"></i> Jelajahi Koleksi Buku
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
