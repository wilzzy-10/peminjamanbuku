@extends('layouts.app')

@section('title', 'Koleksi Buku')

@section('content')
<style>
    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 60px 20px;
        color: white;
        margin-bottom: 40px;
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .hero-content {
        position: relative;
        z-index: 1;
        max-width: 1200px;
        margin: 0 auto;
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 15px;
        letter-spacing: -1px;
    }

    .hero-subtitle {
        font-size: 1.2rem;
        opacity: 0.95;
        font-weight: 500;
        max-width: 500px;
    }

    /* Container */
    .books-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Search & Filter */
    .search-section {
        background: white;
        border-radius: 18px;
        padding: 30px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        margin-bottom: 40px;
    }

    .search-form {
        display: flex;
        gap: 15px;
        align-items: flex-end;
        flex-wrap: wrap;
    }

    .search-group {
        flex: 1;
        min-width: 250px;
    }

    .search-group label {
        display: block;
        font-weight: 700;
        color: #333;
        margin-bottom: 8px;
        font-size: 0.95rem;
    }

    .search-group input,
    .search-group select {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e8e8e8;
        border-radius: 10px;
        font-size: 1rem;
        transition: all 0.3s ease;
        font-family: inherit;
    }

    .search-group input:focus,
    .search-group select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .btn-search {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 12px 36px;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }

    .btn-search:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
    }

    /* Books Grid */
    .books-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 28px;
        margin-bottom: 40px;
    }

    .book-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
    }

    .book-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
    }

    .book-cover {
        width: 100%;
        height: 240px;
        background: linear-gradient(135deg, #f0f0f0 0%, #e8e8e8 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .book-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.35s ease;
    }

    .book-card:hover .book-cover img {
        transform: scale(1.08);
    }

    .book-cover-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        color: #999;
    }

    .book-cover-empty i {
        font-size: 3rem;
    }

    .book-info {
        padding: 24px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .book-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 700;
        margin-bottom: 12px;
        width: fit-content;
    }

    .badge-available {
        background: #d4f4dd;
        color: #2d8a4a;
    }

    .badge-unavailable {
        background: #fdd4d4;
        color: #a82a2a;
    }

    .badge-category {
        background: #e8f0ff;
        color: #667eea;
        margin-left: auto;
    }

    .book-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 8px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .book-author {
        font-size: 0.95rem;
        color: #666;
        margin-bottom: 12px;
        font-weight: 500;
    }

    .book-meta {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-top: 1px solid #f0f0f0;
        border-bottom: 1px solid #f0f0f0;
        margin-bottom: 16px;
        font-size: 0.9rem;
        color: #666;
    }

    .book-stock {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .stock-bar {
        width: 60px;
        height: 6px;
        background: #e8e8e8;
        border-radius: 3px;
        overflow: hidden;
    }

    .stock-fill {
        height: 100%;
        background: linear-gradient(90deg, #667eea, #764ba2);
        transition: width 0.3s ease;
    }

    .book-actions {
        display: flex;
        gap: 10px;
        margin-top: auto;
    }

    .btn {
        flex: 1;
        padding: 11px 16px;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        text-decoration: none;
    }

    .btn-detail {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-detail:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }

    .btn-borrow {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }

    .btn-borrow:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(79, 172, 254, 0.3);
    }

    .btn-borrow:disabled {
        background: #ccc;
        cursor: not-allowed;
        opacity: 0.6;
    }

    .btn-edit {
        background: #ffc107;
        color: white;
    }

    .btn-edit:hover {
        background: #ffb300;
        transform: translateY(-2px);
    }

    .btn-add {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 12px 28px;
        display: inline-flex;
        box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
    }

    .btn-add:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
    }

    /* Empty State */
    .empty-state {
        background: white;
        border-radius: 18px;
        padding: 60px 30px;
        text-align: center;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    }

    .empty-state i {
        font-size: 4rem;
        color: #ddd;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 10px;
    }

    .empty-state p {
        color: #666;
        margin-bottom: 24px;
        font-size: 1.05rem;
    }

    .empty-state a {
        display: inline-block;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 12px 28px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .empty-state a:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
    }

    /* Header Bar */
    .header-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 20px;
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }

        .hero-subtitle {
            font-size: 1rem;
        }

        .search-form {
            flex-direction: column;
        }

        .books-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .btn-search {
            width: 100%;
        }

        .header-bar {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<!-- Hero Section -->
<div class="hero-section">
    <div class="hero-content">
        <h1 class="hero-title">📚 Koleksi Buku</h1>
        <p class="hero-subtitle">Jelajahi koleksi lengkap kami dan temukan buku favorit Anda</p>
    </div>
</div>

<div class="books-container">
    <!-- Header with Add Button -->
    <div class="header-bar">
        <div></div>
        @auth
            @if(auth()->user()->isAdmin())
                <a href="{{ route('books.create') }}" class="btn-add">
                    <i class="fas fa-plus"></i> Tambah Buku
                </a>
            @endif
        @endauth
    </div>

    <!-- Search Section -->
    <div class="search-section">
        <form action="{{ route('books.search') }}" method="GET" class="search-form">
            <div class="search-group" style="flex: 2; min-width: 300px;">
                <label for="q">Cari Buku</label>
                <input type="text" id="q" name="q" placeholder="Judul, pengarang, atau ISBN..." 
                       value="{{ request('q', '') }}">
            </div>
            <button type="submit" class="btn-search">
                <i class="fas fa-search"></i> Cari
            </button>
        </form>
    </div>

    <!-- Books Grid -->
    @if($books->count() > 0)
        <div class="books-grid">
            @foreach($books as $book)
                <div class="book-card">
                    <!-- Book Cover -->
                    <div class="book-cover">
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}">
                        @else
                            <div class="book-cover-empty">
                                <i class="fas fa-book"></i>
                                <span>No Cover</span>
                            </div>
                        @endif
                    </div>

                    <!-- Book Info -->
                    <div class="book-info">
                        <div style="display: flex; gap: 8px; margin-bottom: 8px;">
                            @if($book->isAvailable())
                                <span class="book-badge badge-available">
                                    <i class="fas fa-check-circle"></i> Tersedia
                                </span>
                            @else
                                <span class="book-badge badge-unavailable">
                                    <i class="fas fa-times-circle"></i> Kosong
                                </span>
                            @endif
                            <span class="book-badge badge-category">{{ $book->category->name }}</span>
                        </div>

                        <h3 class="book-title">{{ $book->title }}</h3>
                        <p class="book-author">
                            <i class="fas fa-pen-fancy"></i> {{ $book->author }}
                        </p>

                        <div class="book-meta">
                            <div class="book-stock">
                                <div class="stock-bar">
                                    <div class="stock-fill" style="width: {{ ($book->available_quantity / $book->quantity) * 100 }}%"></div>
                                </div>
                                <span>{{ $book->available_quantity }}/{{ $book->quantity }}</span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="book-actions">
                            <a href="{{ route('books.show', $book) }}" class="btn btn-detail">
                                <i class="fas fa-eye"></i> Detail
                            </a>

                            @auth
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('books.edit', $book) }}" class="btn btn-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                @else
                                    <a href="{{ $book->isAvailable() ? route('loans.create', ['book' => $book->id]) : '#' }}" 
                                       class="btn btn-borrow" {{ !$book->isAvailable() ? 'onclick=event.preventDefault()' : '' }}>
                                        <i class="fas fa-plus-circle"></i> Pinjam
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-borrow">
                                    <i class="fas fa-plus-circle"></i> Pinjam
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div style="display: flex; justify-content: center; margin: 40px 0;">
            {{ $books->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-search"></i>
            <h3>Buku Tidak Ditemukan</h3>
            <p>Tidak ada buku yang cocok dengan pencarian Anda</p>
            <a href="{{ route('books.index') }}">
                <i class="fas fa-home"></i> Kembali ke Koleksi
            </a>
        </div>
    @endif
</div>

@endsection
