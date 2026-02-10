@extends('layouts.app')

@section('title', 'Kelola Pengguna')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .users-container {
        min-height: 100vh;
        padding: 40px 20px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    .users-wrapper {
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Header Section */
    .users-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 40px;
        margin-bottom: 40px;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.2);
        animation: slideDown 0.6s ease-out;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .header-content h1 {
        font-size: 2.5rem;
        font-weight: 700;
        color: white;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .header-content h1 i {
        font-size: 2.8rem;
    }

    .header-content p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.05rem;
        font-weight: 300;
    }

    .btn-group {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .action-btn {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 12px 24px;
        border-radius: 10px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        font-size: 0.95rem;
    }

    .action-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.5);
        transform: translateY(-3px);
    }

    /* Search & Filter */
    .search-section {
        background: white;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        animation: fadeInUp 0.6s ease-out;
    }

    .search-form {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        align-items: flex-end;
    }

    .form-group {
        flex: 1;
        min-width: 200px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 8px;
        font-size: 0.95rem;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .search-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .search-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }

    /* Users Table */
    .users-table-wrapper {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        animation: fadeInUp 0.7s ease-out;
    }

    .table-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 20px 25px;
        color: white;
        font-size: 1.1rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .table-header i {
        font-size: 1.3rem;
    }

    .users-table {
        width: 100%;
        border-collapse: collapse;
    }

    .users-table thead {
        background: #f7fafc;
        border-bottom: 2px solid #e2e8f0;
    }

    .users-table th {
        padding: 16px 20px;
        text-align: left;
        font-weight: 700;
        font-size: 0.9rem;
        color: #4a5568;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .users-table tbody tr {
        border-bottom: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .users-table tbody tr:hover {
        background-color: #f7fafc;
    }

    .users-table td {
        padding: 16px 20px;
        color: #4a5568;
        font-size: 0.95rem;
    }

    /* User Info */
    .user-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 14px;
        flex-shrink: 0;
    }

    .user-details h4 {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 2px;
    }

    .user-details p {
        font-size: 0.85rem;
        color: #718096;
    }

    /* Status Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
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

    .role-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        white-space: nowrap;
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

    /* Action Buttons */
    .table-actions {
        display: flex;
        gap: 8px;
    }

    .table-btn {
        padding: 8px 12px;
        border: none;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .btn-view {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-view:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-edit {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        color: white;
    }

    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(72, 187, 120, 0.3);
    }

    .btn-delete {
        background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
        color: white;
    }

    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(245, 101, 101, 0.3);
    }

    /* Empty State */
    .empty-state {
        padding: 60px 40px;
        text-align: center;
        color: #718096;
    }

    .empty-state-icon {
        font-size: 4rem;
        margin-bottom: 20px;
        opacity: 0.5;
        color: #cbd5e0;
    }

    .empty-state h3 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 10px;
        color: #4a5568;
    }

    .empty-state p {
        font-size: 1.05rem;
        margin-bottom: 25px;
        color: #718096;
    }

    /* Pagination */
    .pagination-wrapper {
        padding: 25px 20px;
        background: #f7fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: center;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .users-container {
            padding: 20px 15px;
        }

        .users-header {
            padding: 30px 20px;
            flex-direction: column;
            text-align: center;
        }

        .header-content h1 {
            font-size: 1.8rem;
        }

        .btn-group {
            width: 100%;
        }

        .action-btn {
            flex: 1;
            justify-content: center;
        }

        .search-form {
            flex-direction: column;
        }

        .form-group {
            min-width: 100%;
        }

        .search-btn {
            width: 100%;
            justify-content: center;
        }

        .users-table {
            font-size: 0.85rem;
        }

        .users-table th,
        .users-table td {
            padding: 12px;
        }

        .table-btn {
            padding: 6px 10px;
            font-size: 0.75rem;
        }

        .user-info {
            flex-direction: column;
            align-items: flex-start;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            font-size: 12px;
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

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        animation: fadeIn 0.3s ease;
    }

    .modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .modal-content {
        background: white;
        border-radius: 15px;
        width: 90%;
        max-width: 600px;
        max-height: 85vh;
        overflow-y: auto;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        animation: slideInUp 0.3s ease;
    }

    .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 25px;
        border-radius: 15px 15px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h2 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .modal-close {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .modal-close:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: rotate(90deg);
    }

    .modal-body {
        padding: 30px;
    }

    .info-section {
        margin-bottom: 25px;
    }

    .info-section h3 {
        font-size: 1.1rem;
        font-weight: 700;
        color: #667eea;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e2e8f0;
    }

    .info-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 15px;
    }

    .info-row.full {
        grid-template-columns: 1fr;
    }

    .info-field {
        display: flex;
        flex-direction: column;
    }

    .info-field label {
        font-size: 0.85rem;
        color: #718096;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }

    .info-field value {
        font-size: 1rem;
        color: #2d3748;
        font-weight: 600;
    }

    .badge-container {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 10px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-top: 15px;
    }

    .stat-card {
        background: #f7fafc;
        padding: 15px;
        border-radius: 10px;
        text-align: center;
        border: 2px solid #e2e8f0;
    }

    .stat-card .stat-number {
        font-size: 1.8rem;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stat-card .stat-label {
        font-size: 0.85rem;
        color: #718096;
        font-weight: 600;
        margin-top: 8px;
    }

    .modal-footer {
        padding: 20px 30px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }

    .modal-btn {
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .modal-btn-edit {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        color: white;
    }

    .modal-btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(72, 187, 120, 0.3);
    }

    .modal-btn-close {
        background: #e2e8f0;
        color: #4a5568;
    }

    .modal-btn-close:hover {
        background: #cbd5e0;
    }

    .social-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .header-top {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
    }

    .modal-avatar {
        width: 60px;
        height: 60px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 24px;
        color: #667eea;
    }

    .modal-title {
        flex: 1;
    }

    .modal-title h3 {
        margin: 0;
        font-size: 1.3rem;
        color: white;
    }

    .modal-title p {
        margin: 4px 0 0 0;
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .modal-content {
            width: 95%;
            max-height: 90vh;
        }

        .info-row {
            grid-template-columns: 1fr;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .modal-footer {
            flex-direction: column;
        }

        .modal-btn {
            justify-content: center;
            width: 100%;
        }
    }

</style>

<div class="users-container">
    <div class="users-wrapper">
        <!-- Header -->
        <div class="users-header">
            <div class="header-content">
                <h1>
                    <i class="fas fa-users"></i> Kelola Pengguna
                </h1>
                <p>Kelola akun admin, petugas, dan anggota perpustakaan</p>
            </div>
            <div class="btn-group">
                <a href="{{ route('users.create') }}" class="action-btn">
                    <i class="fas fa-user-plus"></i> Tambah Pengguna
                </a>
            </div>
        </div>

        <!-- Search & Filter -->
        <div class="search-section">
            <form method="GET" action="{{ route('users.index') }}" class="search-form">
                <div class="form-group">
                    <label for="search">Cari Pengguna</label>
                    <input 
                        type="text" 
                        id="search" 
                        name="search" 
                        placeholder="Nama atau Email"
                        value="{{ request('search') }}"
                    >
                </div>

                <div class="form-group">
                    <label for="role">Role</label>
                    <select id="role" name="role">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="petugas" {{ request('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                        <option value="member" {{ request('role') == 'member' ? 'selected' : '' }}>Member</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                </div>

                <button type="submit" class="search-btn">
                    <i class="fas fa-search"></i> Cari
                </button>

                @if(request('search') || request('role') || request('status'))
                    <a href="{{ route('users.index') }}" class="search-btn" style="background: linear-gradient(135deg, #a0aec0 0%, #718096 100%);">
                        <i class="fas fa-times"></i> Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Users Table -->
        <div class="users-table-wrapper">
            <div class="table-header">
                <i class="fas fa-table"></i> Daftar Pengguna ({{ $users->total() }} Total)
            </div>

            @if($users->count() > 0)
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>Pengguna</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>No. Telp</th>
                            <th>Status</th>
                            <th>Terdaftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="user-info">
                                        <div class="user-avatar">{{ substr($user->name, 0, 1) }}</div>
                                        <div class="user-details">
                                            <h4>{{ $user->name }}</h4>
                                            @if($user->phone)
                                                <p>{{ $user->phone }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->role == 'admin')
                                        <span class="role-badge role-admin">
                                            <i class="fas fa-crown"></i> Admin
                                        </span>
                                    @elseif($user->role == 'petugas')
                                        <span class="role-badge role-petugas">
                                            <i class="fas fa-briefcase"></i> Petugas
                                        </span>
                                    @else
                                        <span class="role-badge role-member">
                                            <i class="fas fa-user"></i> Member
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $user->phone ?? '-' }}</td>
                                <td>
                                    @if($user->status == 'active')
                                        <span class="status-badge status-active">
                                            <i class="fas fa-check-circle"></i> Aktif
                                        </span>
                                    @else
                                        <span class="status-badge status-inactive">
                                            <i class="fas fa-times-circle"></i> Non-Aktif
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="table-actions">
                                        <button 
                                            type="button"
                                            class="table-btn btn-view"
                                            data-user-id="{{ $user->id }}"
                                            data-user-name="{{ $user->name }}"
                                            data-user-email="{{ $user->email }}"
                                            data-user-phone="{{ $user->phone ?? '-' }}"
                                            data-user-address="{{ $user->address ?? '-' }}"
                                            data-user-role="{{ $user->role }}"
                                            data-user-status="{{ $user->status }}"
                                            data-user-created="{{ $user->created_at->format('d/m/Y') }}"
                                            data-user-updated="{{ $user->updated_at->format('d/m/Y') }}"
                                            data-active-loans="{{ $user->loans()->where('status', 'active')->count() }}"
                                            data-returned-loans="{{ $user->loans()->where('status', 'returned')->count() }}"
                                            data-overdue-loans="{{ $user->loans()->where('status', 'active')->where('due_date', '<', now())->count() }}"
                                            onclick="showUserModal(this)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <a href="{{ route('users.edit', $user) }}" class="table-btn btn-edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button 
                                            type="button"
                                            onclick="if(confirmDelete('{{ $user->name }}')) { showAlert('error', 'Menghapus Pengguna', 'Pengguna {{ $user->name }} sedang dihapus...'); document.getElementById('deleteForm{{ $user->id }}').submit(); }"
                                            class="table-btn btn-delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <form id="deleteForm{{ $user->id }}" action="{{ route('users.destroy', $user) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="pagination-wrapper">
                    {{ $users->links() }}
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Tidak Ada Pengguna</h3>
                    <p>Mulai tambahkan pengguna untuk mengelola sistem perpustakaan</p>
                    <a href="{{ route('users.create') }}" class="action-btn" style="display: inline-flex; margin-top: 20px;">
                        <i class="fas fa-user-plus"></i> Tambah Pengguna Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal untuk Menampilkan Detail User -->
<div id="userModal" class="modal">
    <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
            <div class="modal-title">
                <div class="header-top">
                    <div class="modal-avatar" id="modalAvatar">U</div>
                    <div>
                        <h3 id="modalUserName">Nama Pengguna</h3>
                        <p id="modalUserRole">Member</p>
                    </div>
                </div>
            </div>
            <button class="modal-close" onclick="closeUserModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="modal-body">
            <!-- Informasi Dasar -->
            <div class="info-section">
                <h3><i class="fas fa-user"></i> Informasi Dasar</h3>
                <div class="info-row">
                    <div class="info-field">
                        <label>Nama Lengkap</label>
                        <value id="infoName">-</value>
                    </div>
                    <div class="info-field">
                        <label>Email</label>
                        <value id="infoEmail">-</value>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-field">
                        <label>Nomor Telepon</label>
                        <value id="infoPhone">-</value>
                    </div>
                    <div class="info-field">
                        <label>Alamat</label>
                        <value id="infoAddress">-</value>
                    </div>
                </div>
            </div>

            <!-- Status & Role -->
            <div class="info-section">
                <h3><i class="fas fa-shield-alt"></i> Status & Role</h3>
                <div class="badge-container">
                    <span id="modalRoleBadge" class="role-badge role-member">
                        <i class="fas fa-user"></i> Member
                    </span>
                    <span id="modalStatusBadge" class="status-badge status-active">
                        <i class="fas fa-check-circle"></i> Aktif
                    </span>
                </div>
            </div>

            <!-- Rekam Jejak -->
            <div class="info-section">
                <h3><i class="fas fa-history"></i> Rekam Jejak</h3>
                <div class="info-row">
                    <div class="info-field">
                        <label>Dibuat Pada</label>
                        <value id="infoCreatedAt">-</value>
                    </div>
                    <div class="info-field">
                        <label>Diperbarui Pada</label>
                        <value id="infoUpdatedAt">-</value>
                    </div>
                </div>
            </div>

            <!-- Statistik Peminjaman (Untuk Member) -->
            <div class="info-section" id="statsSection" style="display: none;">
                <h3><i class="fas fa-book"></i> Statistik Peminjaman</h3>
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number" id="statActive">0</div>
                        <div class="stat-label">Peminjaman Aktif</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number" id="statReturned">0</div>
                        <div class="stat-label">Dikembalikan</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number" id="statOverdue">0</div>
                        <div class="stat-label">Terlambat</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer">
            <button class="modal-btn modal-btn-close" onclick="closeUserModal()">
                <i class="fas fa-times"></i> Tutup
            </button>
            <a href="#" id="editUserBtn" class="modal-btn modal-btn-edit">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>
</div>

<!-- Alert Notification Styles -->
<style>
    .alert-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        max-width: 400px;
        font-family: inherit;
    }

    .alert-notification {
        background: white;
        padding: 16px 20px;
        border-radius: 10px;
        margin-bottom: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        display: flex;
        align-items: flex-start;
        gap: 12px;
        animation: slideInRight 0.3s ease-out;
        border-left: 4px solid;
    }

    .alert-notification.success {
        border-left-color: #48bb78;
        background: linear-gradient(135deg, rgba(72, 187, 120, 0.1) 0%, rgba(56, 161, 105, 0.05) 100%);
    }

    .alert-notification.success .alert-icon {
        color: #48bb78;
    }

    .alert-notification.error {
        border-left-color: #f56565;
        background: linear-gradient(135deg, rgba(245, 101, 101, 0.1) 0%, rgba(229, 62, 62, 0.05) 100%);
    }

    .alert-notification.error .alert-icon {
        color: #f56565;
    }

    .alert-notification.warning {
        border-left-color: #ed8936;
        background: linear-gradient(135deg, rgba(237, 137, 54, 0.1) 0%, rgba(221, 107, 32, 0.05) 100%);
    }

    .alert-notification.warning .alert-icon {
        color: #ed8936;
    }

    .alert-notification.info {
        border-left-color: #667eea;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.05) 100%);
    }

    .alert-notification.info .alert-icon {
        color: #667eea;
    }

    .alert-icon {
        font-size: 20px;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .alert-content {
        flex: 1;
    }

    .alert-title {
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 2px;
        color: #2d3748;
    }

    .alert-message {
        font-size: 0.85rem;
        color: #4a5568;
        margin: 0;
    }

    .alert-close {
        background: none;
        border: none;
        font-size: 18px;
        color: #a0aec0;
        cursor: pointer;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.2s ease;
    }

    .alert-close:hover {
        color: #718096;
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(400px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideOutRight {
        from {
            opacity: 1;
            transform: translateX(0);
        }
        to {
            opacity: 0;
            transform: translateX(400px);
        }
    }

    .alert-notification.fade-out {
        animation: slideOutRight 0.3s ease-out;
    }

    @media (max-width: 768px) {
        .alert-container {
            top: 10px;
            right: 10px;
            left: 10px;
            max-width: none;
        }

        .alert-notification {
            margin-bottom: 10px;
        }
    }
</style>

<!-- Alert Container -->
<div class="alert-container" id="alertContainer"></div>

<!-- Script untuk Modal & Alert -->
<script>
    // Alert notification function
    function showAlert(type, title, message, duration = 4000) {
        const alertContainer = document.getElementById('alertContainer');
        
        const iconMap = {
            success: 'fas fa-check-circle',
            error: 'fas fa-exclamation-circle',
            warning: 'fas fa-exclamation-triangle',
            info: 'fas fa-info-circle'
        };

        const alertDiv = document.createElement('div');
        alertDiv.className = `alert-notification ${type}`;
        alertDiv.innerHTML = `
            <div class="alert-icon">
                <i class="${iconMap[type] || 'fas fa-info-circle'}"></i>
            </div>
            <div class="alert-content">
                <div class="alert-title">${title}</div>
                <p class="alert-message">${message}</p>
            </div>
            <button type="button" class="alert-close" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        `;

        alertContainer.appendChild(alertDiv);

        // Auto remove after duration
        if (duration > 0) {
            setTimeout(() => {
                alertDiv.classList.add('fade-out');
                setTimeout(() => alertDiv.remove(), 300);
            }, duration);
        }
    }

    // Confirm delete with alert
    function confirmDelete(userName) {
        if (confirm(`Apakah Anda yakin ingin menghapus pengguna "${userName}"? Tindakan ini tidak dapat dibatalkan.`)) {
            showAlert('warning', 'Menghapus', `Pengguna ${userName} sedang dihapus...`);
            return true;
        }
        return false;
    }

    function showUserModal(button) {
        // Get user data from button attributes
        const userId = button.getAttribute('data-user-id');
        const userName = button.getAttribute('data-user-name');
        const userEmail = button.getAttribute('data-user-email');
        const userPhone = button.getAttribute('data-user-phone');
        const userAddress = button.getAttribute('data-user-address');
        const userRole = button.getAttribute('data-user-role');
        const userStatus = button.getAttribute('data-user-status');
        const userCreated = button.getAttribute('data-user-created');
        const userUpdated = button.getAttribute('data-user-updated');
        const activeLoans = button.getAttribute('data-active-loans');
        const returnedLoans = button.getAttribute('data-returned-loans');
        const overdueLoans = button.getAttribute('data-overdue-loans');

        // Populate basic info
        document.getElementById('modalUserName').textContent = userName;
        document.getElementById('infoName').textContent = userName;
        document.getElementById('infoEmail').textContent = userEmail;
        document.getElementById('infoPhone').textContent = userPhone;
        document.getElementById('infoAddress').textContent = userAddress;

        // Avatar
        const avatar = userName.charAt(0).toUpperCase();
        document.getElementById('modalAvatar').textContent = avatar;

        // Role Badge
        const roleMapping = {
            'admin': { icon: 'fa-crown', text: 'Admin', class: 'role-admin' },
            'petugas': { icon: 'fa-briefcase', text: 'Petugas', class: 'role-petugas' },
            'member': { icon: 'fa-user', text: 'Member', class: 'role-member' }
        };
        const roleInfo = roleMapping[userRole] || roleMapping['member'];
        const roleBadge = `<i class="fas ${roleInfo.icon}"></i> ${roleInfo.text}`;
        document.getElementById('modalRoleBadge').innerHTML = roleBadge;
        document.getElementById('modalRoleBadge').className = `role-badge ${roleInfo.class}`;
        document.getElementById('modalUserRole').textContent = roleInfo.text;

        // Status Badge
        const statusBadge = userStatus === 'active' 
            ? '<i class="fas fa-check-circle"></i> Aktif'
            : '<i class="fas fa-times-circle"></i> Non-Aktif';
        document.getElementById('modalStatusBadge').innerHTML = statusBadge;
        document.getElementById('modalStatusBadge').className = 
            userStatus === 'active' 
                ? 'status-badge status-active'
                : 'status-badge status-inactive';

        // Dates
        document.getElementById('infoCreatedAt').textContent = userCreated;
        document.getElementById('infoUpdatedAt').textContent = userUpdated;

        // Show stats section for members
        const statsSection = document.getElementById('statsSection');
        if (userRole === 'member') {
            statsSection.style.display = 'block';
            document.getElementById('statActive').textContent = activeLoans;
            document.getElementById('statReturned').textContent = returnedLoans;
            document.getElementById('statOverdue').textContent = overdueLoans;
        } else {
            statsSection.style.display = 'none';
        }

        // Edit button
        document.getElementById('editUserBtn').href = `/users/${userId}/edit`;

        // Show modal dengan alert
        document.getElementById('userModal').classList.add('show');
        showAlert('info', 'Lihat Detail', `Menampilkan detail pengguna: ${userName}`);
    }

    function closeUserModal() {
        document.getElementById('userModal').classList.remove('show');
    }

    // Close modal saat klik di luar modal
    document.getElementById('userModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeUserModal();
        }
    });

    // Event listener untuk ESC key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeUserModal();
        }
    });

    // Check for success messages from session
    window.addEventListener('load', function() {
        @if(session('success'))
            setTimeout(() => {
                showAlert('success', 'Berhasil!', '{{ session('success') }}', 5000);
            }, 300);
        @endif
        
        @if(session('error'))
            setTimeout(() => {
                showAlert('error', 'Gagal!', '{{ session('error') }}', 5000);
            }, 300);
        @endif
        
        @if($errors->any())
            setTimeout(() => {
                showAlert('warning', 'Validasi Gagal!', 'Periksa kembali form Anda', 5000);
            }, 300);
        @endif
    });

    // Add button click animation alerts
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-edit')) {
            const row = e.target.closest('tr');
            const userName = row.querySelector('h4').textContent;
            showAlert('info', 'Edit Pengguna', `Membuka form edit untuk ${userName}...`);
        }
    });
</script>
@endsection
