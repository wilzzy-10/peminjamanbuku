@extends('layouts.app')

@section('content')
<style>    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .dashboard-wrapper {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 30px 20px;
    }

    .dashboard-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Welcome Banner */
    .welcome-banner {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 25px;
        padding: 50px 40px;
        margin-bottom: 40px;
        color: white;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        position: relative;
        overflow: hidden;
    }

    .welcome-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 450px;
        height: 450px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .welcome-banner::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -5%;
        width: 350px;
        height: 350px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .welcome-content {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 40px;
        flex-wrap: wrap;
    }

    .welcome-text h1 {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 15px;
        letter-spacing: -1px;
    }

    .welcome-text p {
        font-size: 1.15rem;
        opacity: 0.95;
        font-weight: 500;
    }

    .welcome-datetime {
        text-align: right;
        background: rgba(255, 255, 255, 0.15);
        padding: 25px 35px;
        border-radius: 18px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .datetime-day {
        font-size: 3.5rem;
        font-weight: 800;
        line-height: 1;
        margin-bottom: 8px;
    }

    .datetime-month,
    .datetime-year {
        font-size: 1.05rem;
        opacity: 0.9;
        font-weight: 600;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 30px;
        margin-bottom: 45px;
    }

    .stat-card {
        background: white;
        border-radius: 22px;
        padding: 32px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    }

    .stat-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 25px 70px rgba(0, 0, 0, 0.15);
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 25px;
    }

    .stat-label {
        font-size: 0.95rem;
        font-weight: 700;
        color: #667eea;
        text-transform: uppercase;
        letter-spacing: 1.2px;
    }

    .stat-icon-box {
        width: 70px;
        height: 70px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        transition: all 0.3s ease;
    }

    .stat-card:nth-child(1) .stat-icon-box {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .stat-card:nth-child(2) .stat-icon-box {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }

    .stat-card:nth-child(3) .stat-icon-box {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }

    .stat-card:hover .stat-icon-box {
        transform: scale(1.15) rotate(5deg);
    }

    .stat-value {
        font-size: 3rem;
        font-weight: 800;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 16px;
        line-height: 1;
    }

    .stat-description {
        font-size: 0.95rem;
        color: #666;
        font-weight: 500;
        margin-bottom: 18px;
    }

    .stat-progress {
        width: 100%;
        height: 8px;
        background: #f0f0f0;
        border-radius: 4px;
        overflow: hidden;
    }

    .stat-progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #667eea, #764ba2);
        border-radius: 4px;
        transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Content Sections */
    .content-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
        gap: 32px;
        margin-bottom: 45px;
    }

    .section-card {
        background: white;
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        transition: all 0.35s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .section-card:hover {
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
    }

    .section-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 30px;
        color: white;
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .section-icon {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.25);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        flex-shrink: 0;
    }

    .section-header-text h2 {
        font-size: 1.6rem;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .section-header-text p {
        font-size: 0.95rem;
        opacity: 0.9;
        font-weight: 500;
    }

    .section-body {
        padding: 28px;
    }

    .menu-item {
        display: block;
        padding: 20px 22px;
        border: 2.5px solid #e8e8e8;
        border-radius: 14px;
        margin-bottom: 14px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        color: inherit;
        position: relative;
        overflow: hidden;
    }

    .menu-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.08), rgba(118, 75, 162, 0.08));
        transition: left 0.3s ease;
        z-index: -1;
    }

    .menu-item:hover {
        border-color: #667eea;
        transform: translateX(8px);
    }

    .menu-item:hover::before {
        left: 0;
    }

    .menu-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
    }

    .menu-text h3 {
        font-size: 1.1rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 6px;
        transition: color 0.3s ease;
    }

    .menu-item:hover h3 {
        color: #667eea;
    }

    .menu-text p {
        font-size: 0.87rem;
        color: #999;
        font-weight: 500;
    }

    .menu-arrow {
        font-size: 1.4rem;
        color: #ddd;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .menu-item:hover .menu-arrow {
        color: #667eea;
        transform: translateX(6px);
    }

    /* Features Section */
    .features-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 25px;
        padding: 60px 40px;
        color: white;
        position: relative;
        overflow: hidden;
        margin-bottom: 45px;
    }

    .features-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 450px;
        height: 450px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .features-content {
        position: relative;
        z-index: 1;
    }

    .features-title {
        font-size: 2.4rem;
        font-weight: 800;
        margin-bottom: 15px;
        letter-spacing: -0.5px;
    }

    .features-subtitle {
        font-size: 1.1rem;
        opacity: 0.92;
        margin-bottom: 35px;
        font-weight: 500;
        max-width: 500px;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 25px;
    }

    .feature-item {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(12px);
        border: 1.5px solid rgba(255, 255, 255, 0.25);
        border-radius: 18px;
        padding: 32px;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .feature-item:hover {
        background: rgba(255, 255, 255, 0.28);
        transform: translateY(-10px);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25);
        border-color: rgba(255, 255, 255, 0.4);
    }

    .feature-emoji {
        font-size: 3rem;
        margin-bottom: 16px;
        display: inline-block;
        transition: transform 0.3s ease;
    }

    .feature-item:hover .feature-emoji {
        transform: scale(1.2) rotate(10deg);
    }

    .feature-item h3 {
        font-size: 1.35rem;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .feature-item p {
        font-size: 0.98rem;
        opacity: 0.92;
        line-height: 1.7;
    }

    /* Info Cards */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 32px;
        margin-bottom: 20px;
    }

    .info-card {
        background: white;
        border-radius: 22px;
        padding: 35px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.35s ease;
    }

    .info-card:hover {
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
    }

    .info-card h3 {
        font-size: 1.4rem;
        font-weight: 800;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 12px;
        color: #333;
    }

    .info-card h3 i {
        color: #667eea;
        font-size: 1.5rem;
    }

    .stat-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 18px 20px;
        margin-bottom: 12px;
        background: #f8f9fa;
        border-radius: 12px;
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }

    .stat-row:hover {
        background: #f0f2ff;
        border-left-color: #667eea;
        transform: translateX(5px);
    }

    .stat-row-label {
        font-weight: 700;
        color: #555;
        font-size: 1rem;
    }

    .stat-row-value {
        font-size: 1.6rem;
        font-weight: 800;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .tips-list {
        list-style: none;
    }

    .tips-list li {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 16px 18px;
        margin-bottom: 12px;
        background: #fffbf0;
        border-radius: 12px;
        transition: all 0.3s ease;
        border-left: 4px solid #ffc107;
    }

    .tips-list li:hover {
        background: #fff8e0;
        transform: translateX(5px);
    }

    .tips-list i {
        color: #ffc107;
        margin-top: 4px;
        font-weight: 700;
    }

    .tips-list p {
        font-size: 0.95rem;
        color: #666;
        line-height: 1.6;
        font-weight: 500;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .welcome-banner {
            padding: 35px 25px;
        }

        .welcome-text h1 {
            font-size: 2.2rem;
        }

        .welcome-text p {
            font-size: 1rem;
        }

        .welcome-content {
            flex-direction: column;
            text-align: center;
            gap: 20px;
        }

        .welcome-datetime {
            text-align: center;
            align-self: center;
        }

        .stat-value {
            font-size: 2.2rem;
        }

        .features-section {
            padding: 40px 25px;
        }

        .features-title {
            font-size: 1.8rem;
        }
    }
</style>

<!-- Navbar -->
<div class="dashboard-wrapper">
    <div class="dashboard-container">
        @php
            // Handle different data types for loan variables
            $activeCount = is_object($activeLoans) ? $activeLoans->count() : (is_array($activeLoans) ? count($activeLoans) : ($activeLoans ?? 0));
            $returnedCount = is_object($returnedLoans) ? $returnedLoans->count() : (is_array($returnedLoans) ? count($returnedLoans) : ($returnedLoans ?? 0));
            $overdueCount = is_object($overdueLoans) ? $overdueLoans->count() : (is_array($overdueLoans) ? count($overdueLoans) : ($overdueLoans ?? 0));
        @endphp

        <!-- Welcome Banner -->
        <div class="welcome-banner">
            <div class="welcome-content">
                <div class="welcome-text">
                    <h1>Selamat Datang Kembali! 👋</h1>
                    <p>Hai <strong>{{ auth()->user()->name }}</strong>, kelola peminjaman buku Anda dengan mudah</p>
                </div>
                <div class="welcome-datetime">
                    <div class="datetime-day">{{ now()->format('d') }}</div>
                    <div class="datetime-month">{{ now()->format('F') }}</div>
                    <div class="datetime-year">{{ now()->format('Y') }}</div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <!-- Active Loans -->
            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-label">Peminjaman Aktif</span>
                    <div class="stat-icon-box">
                        <i class="fas fa-book"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $activeCount }}</div>
                <div class="stat-description">Buku yang sedang dipinjam</div>
                <div class="stat-progress">
                    <div class="stat-progress-bar" style="width: {{ min($activeCount * 25, 100) }}%"></div>
                </div>
            </div>

            <!-- Returned Books -->
            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-label">Buku Dikembalikan</span>
                    <div class="stat-icon-box">
                        <i class="fas fa-check-double"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $returnedCount }}</div>
                <div class="stat-description">Peminjaman yang selesai</div>
                <div class="stat-progress">
                    <div class="stat-progress-bar" style="width: {{ min($returnedCount * 25, 100) }}%"></div>
                </div>
            </div>

            <!-- Overdue Books -->
            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-label">Peminjaman Terlambat</span>
                    <div class="stat-icon-box">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $overdueCount }}</div>
                <div class="stat-description">Segera kembalikan</div>
                <div class="stat-progress">
                    <div class="stat-progress-bar" style="width: {{ min($overdueCount * 25, 100) }}%"></div>
                </div>
            </div>
        </div>

        <!-- Content Sections -->
        <div class="content-grid">
            <!-- Browse & Borrow -->
            <div class="section-card">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="section-header-text">
                        <h2>Jelajahi & Pinjam</h2>
                        <p>Temukan koleksi buku terbaik</p>
                    </div>
                </div>
                <div class="section-body">
                    <a href="{{ route('books.index') }}" class="menu-item">
                        <div class="menu-content">
                            <div class="menu-text">
                                <h3>📚 Lihat Daftar Buku</h3>
                                <p>Jelajahi semua koleksi buku tersedia</p>
                            </div>
                            <div class="menu-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('books.search') }}" class="menu-item">
                        <div class="menu-content">
                            <div class="menu-text">
                                <h3>🔍 Cari Buku</h3>
                                <p>Cari judul, penulis, ISBN, kategori</p>
                            </div>
                            <div class="menu-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('loans.create', 1) }}" class="menu-item">
                        <div class="menu-content">
                            <div class="menu-text">
                                <h3>✍️ Ajukan Peminjaman</h3>
                                <p>Minta peminjaman buku favorit</p>
                            </div>
                            <div class="menu-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- My Loans -->
            <div class="section-card">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-list"></i>
                    </div>
                    <div class="section-header-text">
                        <h2>Peminjaman Saya</h2>
                        <p>Kelola peminjaman Anda</p>
                    </div>
                </div>
                <div class="section-body">
                    <a href="{{ route('loans.my-loans') }}" class="menu-item">
                        <div class="menu-content">
                            <div class="menu-text">
                                <h3>📖 Peminjaman Aktif</h3>
                                <p>Buku yang sedang saya pinjam</p>
                            </div>
                            <div class="menu-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('loans.my-loans') }}" class="menu-item">
                        <div class="menu-content">
                            <div class="menu-text">
                                <h3>🔄 Kembalikan Buku</h3>
                                <p>Proses pengembalian buku</p>
                            </div>
                            <div class="menu-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('loans.my-loans') }}" class="menu-item">
                        <div class="menu-content">
                            <div class="menu-text">
                                <h3>📋 Riwayat Peminjaman</h3>
                                <p>Lihat semua peminjaman terdahulu</p>
                            </div>
                            <div class="menu-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="features-section">
            <div class="features-content">
                <h2 class="features-title">✨ Fitur Unggulan</h2>
                <p class="features-subtitle">Nikmati pengalaman peminjaman buku yang seamless dengan fitur-fitur canggih kami</p>
                
                <div class="features-grid">
                    <div class="feature-item">
                        <div class="feature-emoji">👀</div>
                        <h3>Lihat Koleksi</h3>
                        <p>Jelajahi ribuan buku dengan detail lengkap, ulasan pengguna, dan informasi ketersediaan real-time</p>
                    </div>

                    <div class="feature-item">
                        <div class="feature-emoji">✍️</div>
                        <h3>Ajukan Pinjam</h3>
                        <p>Buat permohonan peminjaman dengan mudah, pilih durasi, dan dapatkan notifikasi status instan</p>
                    </div>

                    <div class="feature-item">
                        <div class="feature-emoji">🔄</div>
                        <h3>Kembalikan Buku</h3>
                        <p>Kembalikan buku dengan mudah, pantau riwayat, dan lihat status pengembalian setiap saat</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Cards -->
        <div class="info-grid">
            <!-- Statistics Summary -->
            <div class="info-card">
                <h3>
                    <i class="fas fa-chart-pie"></i> Ringkasan Statistik
                </h3>
                <div class="stat-row">
                    <span class="stat-row-label">Total Peminjaman</span>
                    <span class="stat-row-value">{{ $activeCount + $returnedCount }}</span>
                </div>
                <div class="stat-row">
                    <span class="stat-row-label">Tingkat Pengembalian</span>
                    <span class="stat-row-value">
                        @php
                            $total = $activeCount + $returnedCount;
                            $percentage = $total > 0 ? round(($returnedCount / $total) * 100) : 0;
                        @endphp
                        {{ $percentage }}%
                    </span>
                </div>
            </div>

            <!-- Tips -->
            <div class="info-card">
                <h3>
                    <i class="fas fa-lightbulb"></i> Tips Berguna
                </h3>
                <ul class="tips-list">
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <p>Periksa tanggal kadaluarsa untuk menghindari denda keterlambatan</p>
                    </li>
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <p>Anda dapat memperpanjang peminjaman sebelum buku dikembalikan</p>
                    </li>
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <p>Ikuti notifikasi untuk informasi penting tentang peminjaman</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
