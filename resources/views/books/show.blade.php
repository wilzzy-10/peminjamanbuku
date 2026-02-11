@extends('layouts.app')

@section('title', $book->title)

@section('content')
<style>
    /* Container */
    .show-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Breadcrumb */
    .breadcrumb {
        padding: 20px 0;
        margin-bottom: 30px;
    }

    .breadcrumb a {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .breadcrumb a:hover {
        color: #764ba2;
    }

    .breadcrumb-separator {
        color: #ddd;
        margin: 0 12px;
    }

    .breadcrumb-current {
        color: #666;
        font-weight: 600;
    }

    /* Main Content Grid */
    .book-detail-grid {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 40px;
        margin-bottom: 50px;
    }

    /* Book Cover Section */
    .book-cover-section {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .book-cover {
        background: linear-gradient(135deg, #f0f0f0 0%, #e8e8e8 100%);
        border-radius: 16px;
        overflow: hidden;
        aspect-ratio: 2/3;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease;
    }

    .book-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .book-cover:hover {
        transform: scale(1.02);
    }

    .book-cover-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
        color: #999;
    }

    .book-cover-empty i {
        font-size: 5rem;
    }

    /* Status & Actions */
    .status-card {
        padding: 24px;
        border-radius: 14px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 12px;
        text-align: center;
        justify-content: center;
    }

    .status-available {
        background: linear-gradient(135deg, #d4f4dd 0%, #c8f0d1 100%);
        color: #2d8a4a;
        border: 2px solid #a3d9b1;
    }

    .status-unavailable {
        background: linear-gradient(135deg, #fdd4d4 0%, #fcc8c8 100%);
        color: #a82a2a;
        border: 2px solid #f5b9b9;
    }

    .status-card i {
        font-size: 1.3rem;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .btn-action {
        padding: 14px 20px;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
    }

    .btn-borrow {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }

    .btn-borrow:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
    }

    .btn-edit {
        background: #ffc107;
        color: white;
        box-shadow: 0 8px 20px rgba(255, 193, 7, 0.3);
    }

    .btn-edit:hover {
        background: #ffb300;
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(255, 193, 7, 0.4);
    }

    /* Book Details Section */
    .book-details-section {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    .book-title {
        font-size: 3rem;
        font-weight: 800;
        color: #333;
        line-height: 1.2;
        margin-bottom: 10px;
    }

    .book-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .info-item {
        background: white;
        padding: 18px;
        border-radius: 12px;
        border-left: 4px solid #667eea;
    }

    .info-label {
        font-weight: 700;
        color: #667eea;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }

    .info-value {
        color: #333;
        font-size: 1.05rem;
        font-weight: 600;
    }

    .info-value.isbn {
        font-family: 'Courier New', monospace;
        font-size: 0.95rem;
    }

    /* Description Section */
    .description-section {
        background: linear-gradient(135deg, #f8f9fa 0%, #f0f0f0 100%);
        padding: 30px;
        border-radius: 14px;
    }

    .description-title {
        font-size: 1.4rem;
        font-weight: 800;
        color: #333;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .description-title i {
        color: #667eea;
    }

    .description-text {
        color: #666;
        font-size: 1.05rem;
        line-height: 1.8;
        text-align: justify;
    }

    /* History Section */
    .history-section {
        background: white;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    }

    .history-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 24px 30px;
        font-size: 1.3rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .history-empty {
        padding: 60px 30px;
        text-align: center;
        color: #999;
        font-size: 1.1rem;
    }

    .history-table {
        width: 100%;
        border-collapse: collapse;
    }

    .history-table thead {
        background: #f8f9fa;
        border-bottom: 2px solid #e8e8e8;
    }

    .history-table th {
        padding: 16px 20px;
        text-align: left;
        font-weight: 700;
        color: #333;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .history-table tbody tr {
        border-bottom: 1px solid #f0f0f0;
        transition: background 0.3s ease;
    }

    .history-table tbody tr:hover {
        background: #f8f9fa;
    }

    .history-table td {
        padding: 16px 20px;
        color: #666;
        font-size: 0.95rem;
    }

    .history-user {
        color: #667eea;
        font-weight: 700;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .history-user:hover {
        color: #764ba2;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: capitalize;
    }

    .status-returned {
        background: #d4f4dd;
        color: #2d8a4a;
    }

    .status-overdue {
        background: #fdd4d4;
        color: #a82a2a;
    }

    .status-active {
        background: #d9ebf7;
        color: #1456b8;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .book-detail-grid {
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .book-title {
            font-size: 2rem;
        }

        .book-info-grid {
            grid-template-columns: 1fr;
        }

        .history-table {
            font-size: 0.85rem;
        }

        .history-table th,
        .history-table td {
            padding: 12px;
        }
    }
</style>

<div class="show-container">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="{{ route('books.index') }}">
            <i class="fas fa-book-open"></i> Koleksi Buku
        </a>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-current">{{ $book->title }}</span>
    </div>

    <!-- Main Book Detail -->
    <div class="book-detail-grid">
        <!-- Left: Book Cover & Actions -->
        <div class="book-cover-section">
            <!-- Cover -->
            <div class="book-cover">
                @if($book->display_cover_url)
                    <img src="{{ $book->display_cover_url }}" alt="{{ $book->title }}">
                @else
                    <div class="book-cover-empty">
                        <i class="fas fa-book"></i>
                        <span>No Cover</span>
                    </div>
                @endif
            </div>

            <!-- Status -->
            @if($book->isAvailable())
                <div class="status-card status-available">
                    <i class="fas fa-check-circle"></i>
                    <div>Tersedia<br><strong>{{ $book->available_quantity }} Eksemplar</strong></div>
                </div>
            @else
                <div class="status-card status-unavailable">
                    <i class="fas fa-times-circle"></i>
                    <div>Tidak Tersedia</div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="action-buttons">
                @auth
                    @if(!auth()->user()->isAdmin())
                        @if($book->isAvailable())
                            <a href="{{ route('loans.create', ['book' => $book->id]) }}" class="btn-action btn-borrow">
                                <i class="fas fa-plus-circle"></i> Pinjam Buku
                            </a>
                        @endif
                    @else
                        <a href="{{ route('books.edit', $book) }}" class="btn-action btn-edit">
                            <i class="fas fa-edit"></i> Edit Buku
                        </a>
                    @endif
                @else
                    @if($book->isAvailable())
                        <a href="{{ route('login') }}" class="btn-action btn-borrow">
                            <i class="fas fa-sign-in-alt"></i> Login untuk Pinjam
                        </a>
                    @endif
                @endauth
            </div>
        </div>

        <!-- Right: Book Details -->
        <div class="book-details-section">
            <h1 class="book-title">{{ $book->title }}</h1>

            <!-- Info Grid -->
            <div class="book-info-grid">
                <div class="info-item">
                    <div class="info-label"><i class="fas fa-pen-fancy"></i> Pengarang</div>
                    <div class="info-value">{{ $book->author }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label"><i class="fas fa-barcode"></i> ISBN</div>
                    <div class="info-value isbn">{{ $book->isbn }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label"><i class="fas fa-tag"></i> Kategori</div>
                    <div class="info-value">{{ $book->category->name }}</div>
                </div>

                @if($book->publisher)
                    <div class="info-item">
                        <div class="info-label"><i class="fas fa-building"></i> Penerbit</div>
                        <div class="info-value">{{ $book->publisher }}</div>
                    </div>
                @endif

                @if($book->year)
                    <div class="info-item">
                        <div class="info-label"><i class="fas fa-calendar"></i> Tahun Terbit</div>
                        <div class="info-value">{{ $book->year }}</div>
                    </div>
                @endif

                <div class="info-item">
                    <div class="info-label"><i class="fas fa-boxes"></i> Stok Total</div>
                    <div class="info-value">{{ $book->quantity }} Eksemplar</div>
                </div>
            </div>

            <!-- Description -->
            @if($book->description)
                <div class="description-section">
                    <div class="description-title">
                        <i class="fas fa-align-left"></i> Deskripsi Buku
                    </div>
                    <p class="description-text">{{ $book->description }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Loan History -->
    @auth
        @if(auth()->user()->isAdmin())
            <div class="history-section">
                <div class="history-header">
                    <i class="fas fa-history"></i> Riwayat Peminjaman
                </div>

                @if($book->loans->isEmpty())
                    <div class="history-empty">
                        <i class="fas fa-inbox" style="font-size: 3rem; color: #ddd; display: block; margin-bottom: 12px;"></i>
                        Belum ada riwayat peminjaman untuk buku ini
                    </div>
                @else
                    <div style="overflow-x: auto;">
                        <table class="history-table">
                            <thead>
                                <tr>
                                    <th>Peminjam</th>
                                    <th>Tgl. Peminjaman</th>
                                    <th>Batas Kembali</th>
                                    <th>Tgl. Kembali</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($book->loans->sortByDesc('loan_date') as $loan)
                                    <tr>
                                        <td>
                                            <a href="{{ route('profile.show', $loan->user) }}" class="history-user">
                                                {{ $loan->user->name }}
                                            </a>
                                        </td>
                                        <td>{{ $loan->loan_date->format('d/m/Y H:i') }}</td>
                                        <td>{{ $loan->due_date->format('d/m/Y') }}</td>
                                        <td>{{ $loan->return_date ? $loan->return_date->format('d/m/Y') : '-' }}</td>
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
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        @endif
    @endauth
</div>

@endsection
