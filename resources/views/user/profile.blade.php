@extends('layouts.app')

@section('content')
<style>
    .profile-wrapper {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 40px 20px;
    }

    .profile-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 25px;
        padding: 50px 40px;
        color: white;
        margin-bottom: 40px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        position: relative;
        overflow: hidden;
    }

    .profile-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 450px;
        height: 450px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .profile-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 40px;
    }

    .profile-avatar {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        border: 4px solid rgba(255, 255, 255, 0.4);
        flex-shrink: 0;
    }

    .profile-info h1 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 10px;
    }

    .profile-info p {
        font-size: 1.1rem;
        opacity: 0.95;
        font-weight: 500;
    }

    .profile-card {
        background: white;
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
    }

    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 25px 30px;
        color: white;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .card-icon {
        font-size: 1.8rem;
    }

    .card-header h2 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
    }

    .card-body {
        padding: 30px;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        font-weight: 700;
        color: #333;
        margin-bottom: 10px;
        font-size: 0.95rem;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e8e8e8;
        border-radius: 10px;
        font-size: 1rem;
        font-family: inherit;
        transition: all 0.3s ease;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .form-group input:disabled {
        background-color: #f8f9fa;
        color: #999;
        cursor: not-allowed;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .button-group {
        display: flex;
        gap: 15px;
        margin-top: 30px;
    }

    .btn {
        padding: 12px 28px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 1rem;
        transition: all 0.3s ease;
        cursor: pointer;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
    }

    .btn-secondary {
        background: #f0f0f0;
        color: #333;
        border: 2px solid #e8e8e8;
    }

    .btn-secondary:hover {
        background: #e8e8e8;
        border-color: #d0d0d0;
    }

    .btn-danger {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        box-shadow: 0 10px 30px rgba(245, 87, 108, 0.3);
    }

    .btn-danger:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(245, 87, 108, 0.4);
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 20px;
        background: #f8f9fa;
        border-radius: 12px;
        margin-bottom: 12px;
        border-left: 4px solid transparent;
        transition: all 0.3s ease;
    }

    .info-item:hover {
        background: #f0f2ff;
        border-left-color: #667eea;
        transform: translateX(5px);
    }

    .info-label {
        font-weight: 700;
        color: #555;
        font-size: 0.95rem;
    }

    .info-value {
        color: #333;
        font-weight: 600;
        font-size: 1rem;
    }

    .alert {
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border-left: 4px solid #28a745;
    }

    .alert-error {
        background: #f8d7da;
        color: #721c24;
        border-left: 4px solid #f5576c;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-item {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 25px;
        border-radius: 15px;
        color: white;
        text-align: center;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        line-height: 1;
        margin-bottom: 8px;
    }

    .stat-label {
        font-size: 0.95rem;
        opacity: 0.9;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .profile-header {
            padding: 35px 25px;
        }

        .profile-content {
            flex-direction: column;
            text-align: center;
            gap: 20px;
        }

        .profile-info h1 {
            font-size: 2rem;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .button-group {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="profile-wrapper">
    <div class="profile-container">
        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Error Message -->
        @if($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-content">
                <div class="profile-avatar">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="profile-info">
                    <h1>{{ auth()->user()->name }}</h1>
                    <p><i class="fas fa-envelope mr-2"></i> {{ auth()->user()->email }}</p>
                    <p style="margin-top: 8px;">
                        <i class="fas fa-shield-alt mr-2"></i>
                        <span class="uppercase px-3 py-1 bg-rgba(255,255,255,0.2) rounded-lg">{{ auth()->user()->role }}</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number">{{ $activeLoans->count() ?? 0 }}</div>
                <div class="stat-label">Peminjaman Aktif</div>
            </div>
            <div class="stat-item" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="stat-number">{{ $returnedLoans->count() ?? 0 }}</div>
                <div class="stat-label">Dikembalikan</div>
            </div>
            <div class="stat-item" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="stat-number">{{ $overdueLoans->count() ?? 0 }}</div>
                <div class="stat-label">Terlambat</div>
            </div>
        </div>

        <!-- Profile Information -->
        <div class="profile-card">
            <div class="card-header">
                <span class="card-icon"><i class="fas fa-user"></i></span>
                <h2>Informasi Profil</h2>
            </div>
            <div class="card-body">
                <div class="info-item">
                    <span class="info-label">Nama Lengkap</span>
                    <span class="info-value">{{ auth()->user()->name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ auth()->user()->email }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Role</span>
                    <span class="info-value">{{ ucfirst(auth()->user()->role) }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Bergabung Sejak</span>
                    <span class="info-value">{{ auth()->user()->created_at->format('d F Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Edit Profile -->
        <div class="profile-card">
            <div class="card-header">
                <span class="card-icon"><i class="fas fa-edit"></i></span>
                <h2>Edit Profil</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" id="name" name="name" value="{{ auth()->user()->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="{{ auth()->user()->email }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Password Baru (Kosongkan jika tidak ingin mengubah)</label>
                        <input type="password" name="password" placeholder="Masukkan password baru">
                    </div>

                    <div class="form-group">
                        <label>Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" placeholder="Konfirmasi password baru">
                    </div>

                    <div class="button-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Logout Section -->
        <div class="profile-card" style="border-top: 4px solid #f5576c; background: linear-gradient(135deg, rgba(245, 87, 108, 0.05) 0%, rgba(245, 87, 108, 0.02) 100%);">
            <div class="card-body">
                <div style="text-align: center;">
                    <i class="fas fa-sign-out-alt" style="font-size: 3rem; color: #f5576c; margin-bottom: 15px;"></i>
                    <h3 style="color: #333; font-weight: 700; margin-bottom: 10px;">Logout dari Akun</h3>
                    <p style="color: #666; margin-bottom: 20px;">Klik tombol di bawah untuk keluar dari akun Anda</p>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-power-off"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
