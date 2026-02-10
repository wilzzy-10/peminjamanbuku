@extends('layouts.app')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .dashboard-container {
        min-height: 100vh;
        padding: 40px 20px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    .dashboard-wrapper {
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Header Section */
    .dashboard-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 45px 40px;
        margin-bottom: 40px;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.2);
        animation: slideDown 0.6s ease-out;
        color: white;
    }

    .dashboard-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .dashboard-header h1 i {
        font-size: 2.8rem;
    }

    .dashboard-header p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1rem;
        font-weight: 300;
    }

    /* Statistics Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        animation: fadeInUp 0.6s ease-out;
        border-left: 5px solid;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .stat-card.blue {
        border-left-color: #667eea;
    }

    .stat-card.yellow {
        border-left-color: #f6ad55;
    }

    .stat-card.purple {
        border-left-color: #9f7aea;
    }

    .stat-card.red {
        border-left-color: #f56565;
    }

    .stat-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    .stat-label {
        font-size: 0.9rem;
        color: #718096;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .stat-card.blue .stat-icon {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        color: #667eea;
    }

    .stat-card.yellow .stat-icon {
        background: linear-gradient(135deg, rgba(246, 173, 85, 0.1) 0%, rgba(237, 137, 54, 0.1) 100%);
        color: #f6ad55;
    }

    .stat-card.purple .stat-icon {
        background: linear-gradient(135deg, rgba(159, 122, 234, 0.1) 0%, rgba(144, 65, 153, 0.1) 100%);
        color: #9f7aea;
    }

    .stat-card.red .stat-icon {
        background: linear-gradient(135deg, rgba(245, 101, 101, 0.1) 0%, rgba(229, 62, 62, 0.1) 100%);
        color: #f56565;
    }

    .stat-value {
        font-size: 2.2rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 8px;
    }

    /* Section Title */
    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 12px;
        padding-bottom: 15px;
        border-bottom: 3px solid #e2e8f0;
    }

    .section-title i {
        width: 35px;
        height: 35px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1rem;
    }

    /* Action Cards Grid */
    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .action-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        text-decoration: none;
        color: inherit;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        animation: fadeInUp 0.6s ease-out;
        border-top: 4px solid;
        cursor: pointer;
        display: flex;
        flex-direction: column;
    }

    .action-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .action-card.green {
        border-top-color: #48bb78;
    }

    .action-card.green:hover {
        background: linear-gradient(135deg, rgba(72, 187, 120, 0.05) 0%, rgba(56, 161, 105, 0.05) 100%);
    }

    .action-card.blue {
        border-top-color: #667eea;
    }

    .action-card.blue:hover {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
    }

    .action-card.orange {
        border-top-color: #ed8936;
    }

    .action-card.orange:hover {
        background: linear-gradient(135deg, rgba(237, 137, 54, 0.05) 0%, rgba(221, 107, 32, 0.05) 100%);
    }

    .action-icon {
        font-size: 2rem;
        margin-bottom: 12px;
    }

    .action-card.green .action-icon {
        color: #48bb78;
    }

    .action-card.blue .action-icon {
        color: #667eea;
    }

    .action-card.orange .action-icon {
        color: #ed8936;
    }

    .action-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 8px;
    }

    .action-description {
        font-size: 0.9rem;
        color: #718096;
        flex: 1;
    }

    .action-footer {
        margin-top: 15px;
        text-align: right;
        color: #a0aec0;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 6px;
    }

    .action-card:hover .action-footer {
        color: #667eea;
    }

    /* Grid Container */
    .grid-2 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-container {
            padding: 20px 15px;
        }

        .dashboard-header {
            padding: 30px 20px;
            margin-bottom: 30px;
        }

        .dashboard-header h1 {
            font-size: 1.8rem;
        }

        .stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .stat-card {
            padding: 15px;
        }

        .stat-value {
            font-size: 1.8rem;
        }

        .stats-grid {
            margin-bottom: 30px;
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

<div class="dashboard-container">
    <div class="dashboard-wrapper">
        <!-- Header -->
        <div class="dashboard-header">
            <h1>
                <i class="fas fa-check-double"></i> Dashboard Petugas
            </h1>
            <p>Kelola peminjaman, verifikasi pengembalian, dan pantau keterlambatan</p>
        </div>

        <!-- Statistics -->
        <div class="stats-grid">
            <!-- Total Books -->
            <div class="stat-card blue">
                <div class="stat-header">
                    <div>
                        <div class="stat-label">Total Buku</div>
                        <div class="stat-value">{{ $totalBooks ?? 0 }}</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-book"></i>
                    </div>
                </div>
            </div>

            <!-- Pending Approvals -->
            <div class="stat-card yellow">
                <div class="stat-header">
                    <div>
                        <div class="stat-label">Menunggu Persetujuan</div>
                        <div class="stat-value">{{ $pendingLoans ?? 0 }}</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                </div>
            </div>

            <!-- In Return Process -->
            <div class="stat-card purple">
                <div class="stat-header">
                    <div>
                        <div class="stat-label">Proses Pengembalian</div>
                        <div class="stat-value">{{ $returningLoans ?? 0 }}</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                </div>
            </div>

            <!-- Overdue -->
            <div class="stat-card red">
                <div class="stat-header">
                    <div>
                        <div class="stat-label">Peminjaman Overdue</div>
                        <div class="stat-value">{{ $overdueLoans ?? 0 }}</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Sections -->
        <div class="grid-2">
            <!-- Approval & Verification -->
            <div>
                <h2 class="section-title">
                    <i class="fas fa-check-square"></i> Persetujuan & Verifikasi
                </h2>
                <div class="actions-grid">
                    <a href="{{ route('loans.index', ['status' => 'pending']) }}" class="action-card green">
                        <div class="action-icon">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <div class="action-title">Menyetujui Peminjaman</div>
                        <div class="action-description">Review dan approve permohonan peminjaman baru</div>
                        <div class="action-footer">
                            Lihat <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>

                    <a href="{{ route('loans.index', ['status' => 'active']) }}" class="action-card green">
                        <div class="action-icon">
                            <i class="fas fa-search-plus"></i>
                        </div>
                        <div class="action-title">Verifikasi Pengembalian</div>
                        <div class="action-description">Pantau dan verifikasi pengembalian buku</div>
                        <div class="action-footer">
                            Lihat <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>

                    <a href="{{ route('loans.index', ['status' => 'overdue']) }}" class="action-card red">
                        <div class="action-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="action-title">Monitor Keterlambatan</div>
                        <div class="action-description">Pantau peminjaman yang overdue</div>
                        <div class="action-footer">
                            Lihat <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>
                </div>
            </div>

        <!-- Reports Section -->
        <div>
            <h2 class="section-title">
                <i class="fas fa-file-alt"></i> Laporan & Statistik
            </h2>
            <div class="actions-grid">
                <a href="#" class="action-card orange">
                    <div class="action-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="action-title">Laporan Peminjaman</div>
                    <div class="action-description">Lihat statistik dan analisis peminjaman</div>
                    <div class="action-footer">
                        Lihat <i class="fas fa-arrow-right"></i>
                    </div>
                </a>

                <a href="#" class="action-card orange">
                    <div class="action-icon">
                        <i class="fas fa-file-pdf"></i>
                    </div>
                    <div class="action-title">Ekspor Laporan</div>
                    <div class="action-description">Download laporan dalam format PDF/Excel</div>
                    <div class="action-footer">
                        Lihat <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
