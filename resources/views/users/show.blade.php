@extends('layouts.app')

@section('title', 'Detail Pengguna')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .detail-container {
        min-height: 100vh;
        padding: 40px 20px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    .detail-wrapper {
        max-width: 1000px;
        margin: 0 auto;
    }

    .detail-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 40px;
        color: white;
        margin-bottom: 30px;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.2);
        animation: slideDown 0.6s ease-out;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .header-left h1 {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .header-left p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.95rem;
    }

    .header-actions {
        display: flex;
        gap: 10px;
    }

    .action-btn {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .action-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.5);
    }

    /* Content Grid */
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
        margin-bottom: 30px;
    }

    .detail-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        animation: fadeInUp 0.6s ease-out;
    }

    .card-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        padding-bottom: 15px;
        border-bottom: 2px solid #e2e8f0;
    }

    .card-title i {
        color: #667eea;
    }

    .detail-item {
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #e2e8f0;
    }

    .detail-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .detail-label {
        font-weight: 600;
        color: #718096;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }

    .detail-value {
        font-size: 1.05rem;
        color: #2d3748;
        font-weight: 500;
    }

    .detail-value a {
        color: #667eea;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .detail-value a:hover {
        color: #764ba2;
        text-decoration: underline;
    }

    /* Status & Role Badges */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 16px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-active {
        background: linear-gradient(135deg, rgba(72, 187, 120, 0.1) 0%, rgba(56, 161, 105, 0.1) 100%);
        color: #22543d;
    }

    .status-inactive {
        background: linear-gradient(135deg, rgba(160, 174, 192, 0.1) 0%, rgba(113, 128, 150, 0.1) 100%);
        color: #2d3748;
    }

    .role-admin {
        background: linear-gradient(135deg, rgba(245, 101, 101, 0.1) 0%, rgba(229, 62, 62, 0.1) 100%);
        color: #742a2a;
    }

    .role-petugas {
        background: linear-gradient(135deg, rgba(237, 137, 54, 0.1) 0%, rgba(221, 107, 32, 0.1) 100%);
        color: #7c2d12;
    }

    .role-member {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        color: #2d3748;
    }

    /* Loan Statistics */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-top: 20px;
    }

    .stat-item {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        border-left: 4px solid #667eea;
    }

    .stat-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: #667eea;
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 0.85rem;
        color: #718096;
        font-weight: 600;
    }

    /* Back Button */
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 30px;
        padding: 12px 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .back-link:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }

    @media (max-width: 768px) {
        .detail-container {
            padding: 20px 15px;
        }

        .detail-header {
            padding: 30px 20px;
            flex-direction: column;
            text-align: center;
        }

        .header-left h1 {
            font-size: 1.6rem;
        }

        .header-actions {
            width: 100%;
            justify-content: center;
        }

        .action-btn {
            flex: 1;
            justify-content: center;
        }

        .detail-grid {
            grid-template-columns: 1fr;
        }

        .stats-grid {
            grid-template-columns: 1fr;
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

<div class="detail-container">
    <div class="detail-wrapper">
        <!-- Header -->
        <div class="detail-header">
            <div class="header-left">
                <h1>
                    <i class="fas fa-user-circle"></i> {{ $user->name }}
                </h1>
                <p>Detail informasi pengguna dan riwayat peminjaman</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('users.edit', $user) }}" class="action-btn">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('users.index') }}" class="action-btn">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Detail Grid -->
        <div class="detail-grid">
            <!-- User Information -->
            <div class="detail-card">
                <div class="card-title">
                    <i class="fas fa-user"></i> Informasi Dasar
                </div>

                <div class="detail-item">
                    <div class="detail-label">Nama Pengguna</div>
                    <div class="detail-value">{{ $user->name }}</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Email</div>
                    <div class="detail-value">
                        <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">No. Telp</div>
                    <div class="detail-value">
                        {{ $user->phone ?? 'Belum ditambahkan' }}
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Alamat</div>
                    <div class="detail-value">
                        {{ $user->address ?? 'Belum ditambahkan' }}
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Terdaftar Sejak</div>
                    <div class="detail-value">
                        {{ $user->created_at->format('d F Y H:i') }}
                    </div>
                </div>
            </div>

            <!-- Status & Role -->
            <div class="detail-card">
                <div class="card-title">
                    <i class="fas fa-shield-alt"></i> Status & Role
                </div>

                <div class="detail-item">
                    <div class="detail-label">Role</div>
                    <div class="detail-value">
                        @if($user->role == 'admin')
                            <span class="badge role-admin">
                                <i class="fas fa-crown"></i> Admin
                            </span>
                        @elseif($user->role == 'petugas')
                            <span class="badge role-petugas">
                                <i class="fas fa-briefcase"></i> Petugas
                            </span>
                        @else
                            <span class="badge role-member">
                                <i class="fas fa-user"></i> Member
                            </span>
                        @endif
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Status</div>
                    <div class="detail-value">
                        @if($user->status == 'active')
                            <span class="badge status-active">
                                <i class="fas fa-check-circle"></i> Aktif
                            </span>
                        @else
                            <span class="badge status-inactive">
                                <i class="fas fa-times-circle"></i> Non-Aktif
                            </span>
                        @endif
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Terakhir Diperbarui</div>
                    <div class="detail-value">
                        {{ $user->updated_at->format('d F Y H:i') }}
                    </div>
                </div>

                <div style="margin-top: 20px; padding-top: 20px; border-top: 2px solid #e2e8f0;">
                    <div class="detail-label">Aksi</div>
                    <button 
                        type="button"
                        onclick="if(confirm('Yakin ingin menghapus pengguna ini?')) { document.getElementById('deleteForm').submit(); }"
                        class="action-btn" style="width: 100%; justify-content: center; margin-top: 10px; background: linear-gradient(135deg, rgba(245, 101, 101, 0.2) 0%, rgba(229, 62, 62, 0.2) 100%); border-color: #f56565; color: #e53e3e;">
                        <i class="fas fa-trash-alt"></i> Hapus Pengguna
                    </button>
                    <form id="deleteForm" action="{{ route('users.destroy', $user) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>

        <!-- Loan Statistics -->
        @if($user->role == 'member')
            <div class="detail-card">
                <div class="card-title">
                    <i class="fas fa-chart-bar"></i> Statistik Peminjaman
                </div>

                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-value">{{ count($activeLoans ?? []) }}</div>
                        <div class="stat-label">Peminjaman Aktif</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ count($returnedLoans ?? []) }}</div>
                        <div class="stat-label">Dikembalikan</div>
                    </div>
                    <div class="stat-item" style="border-left-color: #f56565;">
                        <div class="stat-value" style="color: #f56565;">{{ count($overdueLoans ?? []) }}</div>
                        <div class="stat-label">Terlambat</div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
