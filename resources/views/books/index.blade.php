@extends('layouts.app')

@section('title', 'Koleksi Buku')

@section('content')
<style>
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 48px 20px;
        color: white;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: -45%;
        right: -8%;
        width: 380px;
        height: 380px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .hero-content {
        position: relative;
        z-index: 1;
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1.1fr 0.9fr;
        gap: 28px;
        align-items: center;
    }

    .hero-title {
        font-size: 3.1rem;
        font-weight: 800;
        margin-bottom: 12px;
        letter-spacing: -1px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .hero-subtitle {
        font-size: 1.15rem;
        opacity: 0.95;
        font-weight: 500;
        max-width: 560px;
        line-height: 1.5;
    }

    .hero-right {
        position: relative;
        min-height: 260px;
        animation: floatTogether 8s ease-in-out infinite;
        will-change: transform;
    }

    .hero-visual-main {
        overflow: hidden;
        min-height: 250px;
    }

    .hero-visual-main svg {
        width: 100%;
        height: 100%;
        display: block;
    }

    .hero-visual-search {
        position: absolute;
        left: 205px;
        top: 115px;
        width: 38%;
        overflow: hidden;
        min-height: 165px;
        filter: drop-shadow(0 12px 18px rgba(40, 54, 145, 0.22));
    }

    .hero-visual-search svg {
        width: 100%;
        height: 100%;
        display: block;
    }

    .books-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

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
        border-radius: 10px;
        text-decoration: none;
        font-weight: 700;
        align-items: center;
        gap: 8px;
    }

    .btn-add:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
    }

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

    .header-bar {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 20px;
    }

    @media (max-width: 768px) {
        .hero-content {
            grid-template-columns: 1fr;
            gap: 18px;
        }

        .hero-title {
            font-size: 2.35rem;
        }

        .hero-subtitle {
            font-size: 1rem;
        }

        .books-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .hero-visual-main {
            min-height: 170px;
        }

        .hero-visual-search {
            min-height: 102px;
            width: 44%;
            left: 44%;
            top: 36%;
        }

        .header-bar {
            flex-direction: column;
            align-items: stretch;
        }
    }

    @keyframes floatTogether {
        0% {
            transform: translate(-8px, -6px);
        }
        25% {
            transform: translate(6px, -4px);
        }
        50% {
            transform: translate(10px, 7px);
        }
        75% {
            transform: translate(-6px, 9px);
        }
        100% {
            transform: translate(-8px, -6px);
        }
    }
</style>

<div class="hero-section">
    <div class="hero-content">
        <div>
            <h1 class="hero-title"><i class="fas fa-books"></i> Koleksi Buku</h1>
            <p class="hero-subtitle">Jelajahi koleksi lengkap kami dan temukan buku favorit Anda</p>
        </div>

        <div class="hero-right">
            <div class="hero-visual-main">
                <svg viewBox="0 0 520 340" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Ilustrasi buku">
                    <circle cx="260" cy="176" r="124" fill="#d7ecff" opacity="0.7"/>
                    <rect x="125" y="90" width="200" height="180" rx="14" fill="#ffffff" stroke="#2b3f99" stroke-width="6"/>
                    <line x1="150" y1="125" x2="280" y2="125" stroke="#2b3f99" stroke-width="6" stroke-linecap="round"/>
                    <line x1="150" y1="155" x2="280" y2="155" stroke="#2b3f99" stroke-width="6" stroke-linecap="round"/>
                    <line x1="150" y1="185" x2="255" y2="185" stroke="#2b3f99" stroke-width="6" stroke-linecap="round"/>
                    <line x1="150" y1="215" x2="270" y2="215" stroke="#2b3f99" stroke-width="6" stroke-linecap="round"/>
                    <rect x="95" y="120" width="45" height="130" rx="10" fill="#ffd166"/>
                    <circle cx="118" cy="145" r="9" fill="#2b3f99"/>
                    <circle cx="118" cy="175" r="9" fill="#2b3f99"/>
                    <circle cx="118" cy="205" r="9" fill="#2b3f99"/>
                    <rect x="235" y="105" width="16" height="32" rx="4" fill="#ef476f"/>
                    <rect x="258" y="112" width="16" height="25" rx="4" fill="#fcbf49"/>
                    <rect x="281" y="102" width="16" height="35" rx="4" fill="#06d6a0"/>
                </svg>
            </div>

            <div class="hero-visual-search">
                <svg viewBox="0 0 280 240" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Ilustrasi pencarian">
                    <circle cx="118" cy="96" r="70" fill="rgba(255,255,255,0.28)" stroke="#3f63d6" stroke-width="14"/>
                    <line x1="165" y1="142" x2="232" y2="210" stroke="#3f63d6" stroke-width="18" stroke-linecap="round"/>
                    <line x1="82" y1="76" x2="155" y2="76" stroke="rgba(63,99,214,0.72)" stroke-width="8" stroke-linecap="round"/>
                    <line x1="82" y1="100" x2="146" y2="100" stroke="rgba(63,99,214,0.72)" stroke-width="8" stroke-linecap="round"/>
                    <line x1="82" y1="124" x2="138" y2="124" stroke="rgba(63,99,214,0.72)" stroke-width="8" stroke-linecap="round"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<div class="books-container">
    @auth
        @if(auth()->user()->isAdmin())
            <div class="header-bar">
                <a href="{{ route('books.create') }}" class="btn-add">
                    <i class="fas fa-plus"></i> Tambah Buku
                </a>
            </div>
        @endif
    @endauth

    @if($books->count() > 0)
        <div class="books-grid">
            @foreach($books as $book)
                <div class="book-card">
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

        <div style="display: flex; justify-content: center; margin: 40px 0;">
            {{ $books->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-search"></i>
            <h3>Buku Tidak Ditemukan</h3>
            <p>Tidak ada buku yang cocok dengan pencarian Anda</p>
            <a href="{{ route('books.index') }}">
                <i class="fas fa-home"></i> Lihat Koleksi
            </a>
        </div>
    @endif
</div>

@endsection
