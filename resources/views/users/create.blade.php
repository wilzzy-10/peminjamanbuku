@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .form-container {
        min-height: 100vh;
        padding: 40px 20px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    .form-wrapper {
        max-width: 700px;
        margin: 0 auto;
    }

    .form-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 40px;
        color: white;
        margin-bottom: 30px;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.2);
        animation: slideDown 0.6s ease-out;
    }

    .form-header h1 {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .form-header p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.95rem;
    }

    .form-card {
        background: white;
        border-radius: 15px;
        padding: 40px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        animation: fadeInUp 0.6s ease-out;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 10px;
        font-size: 0.95rem;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 14px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        font-family: inherit;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-row .form-group {
        margin-bottom: 0;
    }

    .help-text {
        font-size: 0.85rem;
        color: #718096;
        margin-top: 6px;
    }

    .form-actions {
        display: flex;
        gap: 15px;
        margin-top: 40px;
    }

    .form-btn {
        flex: 1;
        padding: 14px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-size: 1rem;
        text-decoration: none;
    }

    .btn-submit {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    }

    .btn-cancel {
        background: #e2e8f0;
        color: #4a5568;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .btn-cancel:hover {
        background: #cbd5e0;
        transform: translateY(-2px);
    }

    .error-message {
        background: linear-gradient(135deg, rgba(245, 101, 101, 0.1) 0%, rgba(229, 62, 62, 0.1) 100%);
        color: #742a2a;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 25px;
        border-left: 4px solid #f56565;
    }

    .error-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .error-list li {
        padding: 4px 0;
    }

    .error-list li::before {
        content: "• ";
        color: #f56565;
        font-weight: bold;
        margin-right: 8px;
    }

    @media (max-width: 768px) {
        .form-container {
            padding: 20px 15px;
        }

        .form-header {
            padding: 30px 20px;
        }

        .form-header h1 {
            font-size: 1.6rem;
        }

        .form-card {
            padding: 25px;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
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

<div class="form-container">
    <div class="form-wrapper">
        <!-- Header -->
        <div class="form-header">
            <h1>
                <i class="fas fa-user-plus"></i> Tambah Pengguna Baru
            </h1>
            <p>Buat akun pengguna baru untuk admin, petugas, atau member</p>
        </div>

        <!-- Form -->
        <div class="form-card">
            @if($errors->any())
                <div class="error-message">
                    <strong><i class="fas fa-exclamation-circle"></i> Ada kesalahan!</strong>
                    <ul class="error-list">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('users.store') }}">
                @csrf

                <!-- Name -->
                <div class="form-group">
                    <label for="name">Nama Lengkap <span style="color: #f56565;">*</span></label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        placeholder="Masukkan nama lengkap"
                        value="{{ old('name') }}"
                        required
                    >
                </div>

                <!-- Email & Phone -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email <span style="color: #f56565;">*</span></label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            placeholder="contoh@email.com"
                            value="{{ old('email') }}"
                            required
                        >
                    </div>
                    <div class="form-group">
                        <label for="phone">No. Telp</label>
                        <input 
                            type="text" 
                            id="phone" 
                            name="phone" 
                            placeholder="08xxxxxxxxxx"
                            value="{{ old('phone') }}"
                        >
                    </div>
                </div>

                <!-- Password & Confirm -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="password">Password <span style="color: #f56565;">*</span></label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Minimal 8 karakter"
                            required
                        >
                        <p class="help-text">Minimal 8 karakter</p>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password <span style="color: #f56565;">*</span></label>
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            placeholder="Ulangi password"
                            required
                        >
                    </div>
                </div>

                <!-- Address -->
                <div class="form-group">
                    <label for="address">Alamat</label>
                    <textarea 
                        id="address" 
                        name="address" 
                        placeholder="Masukkan alamat lengkap"
                    >{{ old('address') }}</textarea>
                </div>

                <!-- Role & Status -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="role">Role <span style="color: #f56565;">*</span></label>
                        <select id="role" name="role" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                            <option value="member" {{ old('role') == 'member' ? 'selected' : '' }}>Member</option>
                        </select>
                        <p class="help-text">
                            <strong>Admin:</strong> Akses penuh | 
                            <strong>Petugas:</strong> Verifikasi peminjaman | 
                            <strong>Member:</strong> Peminjam
                        </p>
                    </div>
                    <div class="form-group">
                        <label for="status">Status <span style="color: #f56565;">*</span></label>
                        <select id="status" name="status" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : 'selected' }}>Aktif</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                    </div>
                </div>

                <!-- Actions -->
                <div class="form-actions">
                    <button type="submit" class="form-btn btn-submit">
                        <i class="fas fa-save"></i> Simpan Pengguna
                    </button>
                    <a href="{{ route('users.index') }}" class="form-btn btn-cancel">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
