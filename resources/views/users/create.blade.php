@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
<style>
    .user-form-page {
        max-width: 1100px;
        margin: 0 auto;
        padding: 30px 16px;
    }

    .user-form-layout {
        display: grid;
        grid-template-columns: minmax(0, 2fr) minmax(0, 1fr);
        gap: 24px;
    }

    .user-main-card {
        background: #ffffff;
        border-radius: 14px;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .user-main-header {
        padding: 20px 24px;
        background: linear-gradient(90deg, #2563eb 0%, #4338ca 100%);
        color: #ffffff;
    }

    .user-main-header h1 {
        margin: 0;
        font-size: 1.6rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-main-header p {
        margin: 8px 0 0;
        color: #dbeafe;
        font-size: 0.92rem;
    }

    .user-form {
        padding: 24px;
    }

    .user-field {
        margin-bottom: 18px;
    }

    .user-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 18px;
    }

    .user-field:last-child,
    .user-row:last-of-type {
        margin-bottom: 0;
    }

    .user-field label {
        display: block;
        margin-bottom: 8px;
        font-size: 0.92rem;
        font-weight: 700;
        color: #374151;
    }

    .user-field input,
    .user-field textarea,
    .user-field select {
        width: 100%;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        padding: 11px 14px;
        font-size: 0.95rem;
        background: #ffffff;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .user-field input:focus,
    .user-field textarea:focus,
    .user-field select:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }

    .user-field textarea {
        min-height: 95px;
        resize: vertical;
    }

    .field-invalid {
        border-color: #f87171 !important;
    }

    .field-help {
        color: #6b7280;
        font-size: 0.8rem;
        margin-top: 6px;
    }

    .error-box {
        border: 1px solid #fecaca;
        background: #fef2f2;
        color: #b91c1c;
        border-radius: 10px;
        padding: 12px 14px;
        margin-bottom: 18px;
        font-size: 0.9rem;
    }

    .error-box p {
        margin: 0 0 8px;
        font-weight: 700;
    }

    .error-box ul {
        margin: 0;
        padding-left: 18px;
    }

    .user-actions {
        display: flex;
        gap: 12px;
        border-top: 1px solid #e5e7eb;
        padding-top: 18px;
        margin-top: 18px;
    }

    .user-btn {
        flex: 1;
        border: 0;
        border-radius: 10px;
        padding: 11px 14px;
        font-weight: 700;
        font-size: 0.94rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .user-btn-primary {
        background: #2563eb;
        color: #ffffff;
    }

    .user-btn-primary:hover {
        background: #1d4ed8;
    }

    .user-btn-muted {
        background: #e5e7eb;
        color: #374151;
    }

    .user-btn-muted:hover {
        background: #d1d5db;
    }

    .user-side {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .user-side-card {
        background: #ffffff;
        border: 1px solid #f3f4f6;
        border-radius: 14px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        padding: 18px;
    }

    .user-side-card h2,
    .user-side-card h3 {
        margin: 0 0 10px;
        font-size: 1rem;
        font-weight: 700;
        color: #1f2937;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .user-side-card h2 i {
        color: #f59e0b;
    }

    .user-side-card p,
    .user-side-card li {
        margin: 0;
        color: #4b5563;
        font-size: 0.9rem;
        line-height: 1.55;
    }

    .user-side-card .example-list p + p {
        margin-top: 6px;
    }

    .user-side-card.user-role-info {
        background: #eff6ff;
        border-color: #dbeafe;
    }

    .user-side-card.user-role-info h3 {
        color: #1e3a8a;
        display: block;
    }

    .user-side-card.user-role-info ul {
        margin: 0;
        padding-left: 18px;
        color: #1e40af;
        font-size: 0.9rem;
    }

    .user-side-card.user-role-info li + li {
        margin-top: 4px;
    }

    @media (max-width: 980px) {
        .user-form-layout {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 720px) {
        .user-row {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 640px) {
        .user-main-header,
        .user-form {
            padding-left: 16px;
            padding-right: 16px;
        }

        .user-actions {
            flex-direction: column;
        }
    }
</style>

<div class="user-form-page">
    <div class="user-form-layout">
        <div class="user-main-card">
            <div class="user-main-header">
                <h1>
                    <i class="fas fa-user-plus"></i>
                    Tambah Pengguna Baru
                </h1>
                <p>Isi data berikut untuk membuat akun admin, petugas, atau member.</p>
            </div>

            <form method="POST" action="{{ route('users.store') }}" class="user-form">
                @csrf

                @if($errors->any())
                    <div class="error-box">
                        <p><i class="fas fa-exclamation-circle"></i> Ada data yang belum valid:</p>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="user-field">
                    <label for="name">Nama Lengkap <span style="color:#ef4444">*</span></label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Masukkan nama lengkap"
                        required
                        class="@error('name') field-invalid @enderror"
                    >
                </div>

                <div class="user-row">
                    <div class="user-field">
                        <label for="email">Email <span style="color:#ef4444">*</span></label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="contoh@email.com"
                            required
                            class="@error('email') field-invalid @enderror"
                        >
                    </div>

                    <div class="user-field">
                        <label for="phone">No. Telp</label>
                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="08xxxxxxxxxx"
                            class="@error('phone') field-invalid @enderror"
                        >
                    </div>
                </div>

                <div class="user-row">
                    <div class="user-field">
                        <label for="password">Password <span style="color:#ef4444">*</span></label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Minimal 8 karakter"
                            required
                            class="@error('password') field-invalid @enderror"
                        >
                        <p class="field-help">Minimal 8 karakter.</p>
                    </div>

                    <div class="user-field">
                        <label for="password_confirmation">Konfirmasi Password <span style="color:#ef4444">*</span></label>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Ulangi password"
                            required
                        >
                    </div>
                </div>

                <div class="user-field">
                    <label for="address">Alamat</label>
                    <textarea
                        id="address"
                        name="address"
                        rows="3"
                        placeholder="Masukkan alamat lengkap"
                        class="@error('address') field-invalid @enderror"
                    >{{ old('address') }}</textarea>
                </div>

                <div class="user-row">
                    <div class="user-field">
                        <label for="role">Role <span style="color:#ef4444">*</span></label>
                        <select
                            id="role"
                            name="role"
                            required
                            class="@error('role') field-invalid @enderror"
                        >
                            <option value="">-- Pilih Role --</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                            <option value="member" {{ old('role') == 'member' ? 'selected' : '' }}>Member</option>
                        </select>
                    </div>

                    <div class="user-field">
                        <label for="status">Status <span style="color:#ef4444">*</span></label>
                        <select
                            id="status"
                            name="status"
                            required
                            class="@error('status') field-invalid @enderror"
                        >
                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                    </div>
                </div>

                <div class="user-actions">
                    <button type="submit" class="user-btn user-btn-primary">
                        <i class="fas fa-save"></i>
                        Simpan Pengguna
                    </button>
                    <a href="{{ route('users.index') }}" class="user-btn user-btn-muted">
                        <i class="fas fa-times"></i>
                        Batal
                    </a>
                </div>
            </form>
        </div>

        <div class="user-side">
            <div class="user-side-card">
                <h2>
                    <i class="fas fa-lightbulb"></i>
                    Contoh Isian
                </h2>
                <div class="example-list">
                    <p><strong>Nama:</strong> Budi Santoso</p>
                    <p><strong>Email:</strong> budi@perpustakaan.id</p>
                    <p><strong>Role:</strong> Petugas</p>
                    <p><strong>Status:</strong> Aktif</p>
                </div>
            </div>

            <div class="user-side-card user-role-info">
                <h3>Hak Akses Role</h3>
                <ul>
                    <li><strong>Admin</strong>: kelola seluruh data.</li>
                    <li><strong>Petugas</strong>: proses peminjaman/pengembalian.</li>
                    <li><strong>Member</strong>: pinjam buku dan lihat riwayat.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
