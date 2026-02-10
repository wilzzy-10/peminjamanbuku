@extends('layouts.app')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .admin-container {
        min-height: 100vh;
        padding: 40px 20px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    .admin-wrapper {
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Header Section */
    .admin-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 45px;
        color: white;
        margin-bottom: 45px;
        box-shadow: 0 15px 40px rgba(102, 126, 234, 0.2);
        animation: slideDown 0.6s ease-out;
    }

    .admin-header h1 {
        font-size: 2.8rem;
        font-weight: 700;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .admin-header h1 i {
        font-size: 3rem;
    }

    .admin-header p {
        font-size: 1.1rem;
        opacity: 0.9;
        font-weight: 300;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
        margin-bottom: 45px;
    }

    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        animation: fadeInUp 0.6s ease-out;
        border-top: 4px solid transparent;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
    }

    .stat-card:hover::before {
        opacity: 1;
    }

    .stat-card.books {
        border-top-color: #667eea;
    }

    .stat-card.users {
        border-top-color: #48bb78;
    }

    .stat-card.loans {
        border-top-color: #ed8936;
    }

    .stat-card.overdue {
        border-top-color: #f56565;
    }

    .stat-content {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        position: relative;
        z-index: 1;
    }

    .stat-info h3 {
        color: #718096;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-number {
        font-size: 2.8rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 5px;
    }

    .stat-card.books .stat-number {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stat-card.users .stat-number {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stat-card.loans .stat-number {
        background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stat-card.overdue .stat-number {
        background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stat-icon {
        width: 70px;
        height: 70px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        flex-shrink: 0;
    }

    .stat-card.books .stat-icon {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        color: #667eea;
    }

    .stat-card.users .stat-icon {
        background: linear-gradient(135deg, rgba(72, 187, 120, 0.1) 0%, rgba(56, 161, 105, 0.1) 100%);
        color: #48bb78;
    }

    .stat-card.loans .stat-icon {
        background: linear-gradient(135deg, rgba(237, 137, 54, 0.1) 0%, rgba(221, 107, 32, 0.1) 100%);
        color: #ed8936;
    }

    .stat-card.overdue .stat-icon {
        background: linear-gradient(135deg, rgba(245, 101, 101, 0.1) 0%, rgba(229, 62, 62, 0.1) 100%);
        color: #f56565;
    }

    /* Section Cards */
    .section-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        animation: fadeInUp 0.7s ease-out;
        margin-bottom: 30px;
    }

    .section-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 25px 30px;
        color: white;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 1.4rem;
        font-weight: 700;
    }

    .section-header i {
        font-size: 1.6rem;
    }

    .section-content {
        padding: 25px 30px;
    }

    .action-list {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .action-item {
        padding: 20px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .action-item:hover {
        border-color: #667eea;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.15);
    }

    .action-item-icon {
        font-size: 2rem;
        margin-bottom: 12px;
        color: #667eea;
        transition: all 0.3s ease;
    }

    .action-item:hover .action-item-icon {
        transform: scale(1.1) translateY(-5px);
    }

    .action-item-title {
        font-weight: 700;
        font-size: 1.05rem;
        color: #2d3748;
        margin-bottom: 6px;
    }

    .action-item-desc {
        font-size: 0.9rem;
        color: #718096;
        margin-bottom: 12px;
        flex-grow: 1;
    }

    .action-item-arrow {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 50%;
        transition: all 0.3s ease;
        font-size: 0.85rem;
    }

    .action-item:hover .action-item-arrow {
        transform: translateX(5px);
    }

    /* Report Grid */
    .reports-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .report-card {
        padding: 25px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        text-align: center;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        color: inherit;
        background: white;
    }

    .report-card:hover {
        border-color: #ed8936;
        background: linear-gradient(135deg, rgba(237, 137, 54, 0.05) 0%, rgba(221, 107, 32, 0.05) 100%);
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(237, 137, 54, 0.15);
    }

    .report-card-icon {
        font-size: 2.5rem;
        color: #ed8936;
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }

    .report-card:hover .report-card-icon {
        transform: scale(1.15) rotate(5deg);
    }

    .report-card-title {
        font-weight: 700;
        font-size: 1.05rem;
        color: #2d3748;
        margin-bottom: 6px;
    }

    .report-card-desc {
        font-size: 0.9rem;
        color: #718096;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .admin-container {
            padding: 20px 15px;
        }

        .admin-header {
            padding: 30px 20px;
            margin-bottom: 30px;
        }

        .admin-header h1 {
            font-size: 1.8rem;
        }

        .admin-header p {
            font-size: 0.95rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            padding: 20px;
        }

        .stat-number {
            font-size: 2rem;
        }

        .section-header {
            padding: 20px;
            font-size: 1.1rem;
        }

        .action-list {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .reports-grid {
            grid-template-columns: 1fr;
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

<div class="admin-container">
    <div class="admin-wrapper">
        <!-- Header -->
        <div class="admin-header">
            <h1>
                <i class="fas fa-tachometer-alt"></i> Dashboard Admin
            </h1>
            <p>Kelola seluruh sistem perpustakaan digital Anda</p>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <!-- Total Books -->
            <div class="stat-card books">
                <div class="stat-content">
                    <div class="stat-info">
                        <h3>Total Buku</h3>
                        <div class="stat-number">{{ $totalBooks ?? 0 }}</div>
                        <p style="color: #a0aec0; font-size: 0.85rem;">Dalam koleksi</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-book"></i>
                    </div>
                </div>
            </div>

            <!-- Total Users -->
            <div class="stat-card users">
                <div class="stat-content">
                    <div class="stat-info">
                        <h3>Total Pengguna</h3>
                        <div class="stat-number">{{ $totalUsers ?? 0 }}</div>
                        <p style="color: #a0aec0; font-size: 0.85rem;">Pengguna terdaftar</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>

            <!-- Active Loans -->
            <div class="stat-card loans">
                <div class="stat-content">
                    <div class="stat-info">
                        <h3>Peminjaman Aktif</h3>
                        <div class="stat-number">{{ $activeLoans ?? 0 }}</div>
                        <p style="color: #a0aec0; font-size: 0.85rem;">Sedang berjalan</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-hand-holding-book"></i>
                    </div>
                </div>
            </div>

            <!-- Overdue Loans -->
            <div class="stat-card overdue">
                <div class="stat-content">
                    <div class="stat-info">
                        <h3>Peminjaman Overdue</h3>
                        <div class="stat-number">{{ $overdueLoans ?? 0 }}</div>
                        <p style="color: #a0aec0; font-size: 0.85rem;">Terlambat dikembalikan</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Management Sections -->
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-cogs"></i> Manajemen Data
            </div>
            <div class="section-content">
                <div class="action-list">
                    <a href="{{ route('books.index') }}" class="action-item">
                        <div>
                            <div class="action-item-icon">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <div class="action-item-title">Kelola Buku</div>
                            <div class="action-item-desc">CRUD buku, kategori, dan stok</div>
                        </div>
                        <div class="action-item-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>

                    <a href="{{ route('categories.index') }}" class="action-item">
                        <div>
                            <div class="action-item-icon">
                                <i class="fas fa-list"></i>
                            </div>
                            <div class="action-item-title">Kategori Buku</div>
                            <div class="action-item-desc">Tambah dan kelola kategori</div>
                        </div>
                        <div class="action-item-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>

                    <a href="{{ route('users.index') }}" class="action-item">
                        <div>
                            <div class="action-item-icon">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="action-item-title">Kelola Pengguna</div>
                            <div class="action-item-desc">Admin, Petugas, dan User</div>
                        </div>
                        <div class="action-item-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Loan Management -->
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-tasks"></i> Persetujuan Peminjaman
            </div>
            <div class="section-content">
                <div class="action-list">
                    <a href="{{ route('loans.index') }}" class="action-item">
                        <div>
                            <div class="action-item-icon">
                                <i class="fas fa-list-check"></i>
                            </div>
                            <div class="action-item-title">Semua Peminjaman</div>
                            <div class="action-item-desc">Lihat dan kelola semua peminjaman</div>
                        </div>
                        <div class="action-item-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>

                    <a href="{{ route('loans.index', ['status' => 'pending']) }}" class="action-item">
                        <div>
                            <div class="action-item-icon" style="color: #f6ad55;">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="action-item-title">Menunggu Persetujuan</div>
                            <div class="action-item-desc">Approve atau tolak peminjaman</div>
                        </div>
                        <div class="action-item-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>

                    <a href="{{ route('loans.index', ['status' => 'overdue']) }}" class="action-item">
                        <div>
                            <div class="action-item-icon" style="color: #f56565;">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="action-item-title">Peminjaman Terlambat</div>
                            <div class="action-item-desc">Monitor pengembalian overdue</div>
                        </div>
                        <div class="action-item-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Reports -->
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-file-alt"></i> Laporan & Aktivitas
            </div>
            <div class="section-content">
                <div class="reports-grid">
                    <a href="#" class="report-card">
                        <div class="report-card-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div class="report-card-title">Laporan Peminjaman</div>
                        <div class="report-card-desc">Statistik peminjaman mendalam</div>
                    </a>

                    <a href="#" class="report-card">
                        <div class="report-card-icon">
                            <i class="fas fa-history"></i>
                        </div>
                        <div class="report-card-title">Log Aktivitas</div>
                        <div class="report-card-desc">Riwayat aktivitas pengguna</div>
                    </a>

                    <a href="#" class="report-card">
                        <div class="report-card-icon">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div class="report-card-title">Ekspor Laporan</div>
                        <div class="report-card-desc">Download PDF & Excel</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
