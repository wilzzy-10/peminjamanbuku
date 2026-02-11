@extends('layouts.app')

@section('title', 'Log Aktivitas')

@section('content')
<style>
    .log-page { min-height: 100vh; padding: 32px 20px; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); }
    .log-wrap { max-width: 1350px; margin: 0 auto; }
    .hero { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; border-radius: 14px; padding: 30px; margin-bottom: 24px; }
    .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 14px; margin-bottom: 20px; }
    .card { background: #fff; border-radius: 12px; padding: 18px; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08); }
    .card .label { color: #718096; font-size: 12px; text-transform: uppercase; font-weight: 700; margin-bottom: 6px; }
    .card .value { font-size: 30px; font-weight: 800; color: #2d3748; }
    .panel { background: #fff; border-radius: 12px; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08); overflow: hidden; }
    .head { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; padding: 14px 18px; font-weight: 700; }
    .body { padding: 16px 18px; }
    .filters { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 10px; margin-bottom: 12px; }
    .filters input, .filters select { width: 100%; border: 1px solid #d1d9e6; border-radius: 8px; padding: 10px 12px; font-size: 14px; }
    .btn { border: none; border-radius: 8px; padding: 10px 14px; font-weight: 700; cursor: pointer; }
    .btn.primary { background: #667eea; color: #fff; }
    .btn.light { background: #edf2f7; color: #2d3748; text-decoration: none; display: inline-block; }
    table { width: 100%; border-collapse: collapse; }
    th, td { text-align: left; padding: 10px; border-bottom: 1px solid #e2e8f0; font-size: 14px; vertical-align: top; }
    th { background: #f8fafc; font-size: 12px; text-transform: uppercase; color: #718096; }
    .badge { padding: 4px 8px; border-radius: 999px; font-size: 11px; font-weight: 700; background: #edf2f7; color: #2d3748; }
    .meta { font-size: 12px; color: #718096; margin-top: 4px; }
    @media (max-width: 900px) { .filters { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 600px) { .filters { grid-template-columns: 1fr; } }
</style>

<div class="log-page">
    <div class="log-wrap">
        <div class="hero">
            <h1 style="font-size: 30px; font-weight: 800;">Log Aktivitas Sistem</h1>
            <p style="opacity: .9;">Riwayat login/logout, pengajuan, persetujuan, penolakan, dan verifikasi pengembalian.</p>
        </div>

        <div class="stats">
            <div class="card"><div class="label">Total Log</div><div class="value">{{ $totalLogs }}</div></div>
            <div class="card"><div class="label">Aktivitas Hari Ini</div><div class="value">{{ $todayLogs }}</div></div>
            <div class="card"><div class="label">Pengguna Aktif Hari Ini</div><div class="value">{{ $uniqueUsersToday }}</div></div>
        </div>

        <div class="panel">
            <div class="head">Filter & Daftar Aktivitas</div>
            <div class="body">
                <form method="GET" action="{{ route('admin.reports.activity-logs') }}">
                    <div class="filters">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/email/deskripsi">
                        <select name="action">
                            <option value="">Semua Aksi</option>
                            @foreach($availableActions as $item)
                                <option value="{{ $item }}" {{ request('action') === $item ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select>
                        <select name="role">
                            <option value="">Semua Role</option>
                            @foreach(['admin', 'petugas', 'user', 'guest'] as $role)
                                <option value="{{ $role }}" {{ request('role') === $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                            @endforeach
                        </select>
                        <div style="display:flex; gap:8px;">
                            <button class="btn primary" type="submit">Terapkan</button>
                            <a class="btn light" href="{{ route('admin.reports.activity-logs') }}">Reset</a>
                        </div>
                    </div>
                </form>

                <div style="overflow-x:auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Pengguna</th>
                                <th>Role</th>
                                <th>Aksi</th>
                                <th>Deskripsi</th>
                                <th>IP</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                                <tr>
                                    <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                                    <td>
                                        <div>{{ $log->user->name ?? 'Guest/System' }}</div>
                                        <div class="meta">{{ $log->user->email ?? '-' }}</div>
                                    </td>
                                    <td><span class="badge">{{ $log->role }}</span></td>
                                    <td><code>{{ $log->action }}</code></td>
                                    <td>
                                        <div>{{ $log->description }}</div>
                                        @if(!empty($log->metadata))
                                            <div class="meta">{{ json_encode($log->metadata, JSON_UNESCAPED_UNICODE) }}</div>
                                        @endif
                                    </td>
                                    <td>{{ $log->ip_address ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">Belum ada data log aktivitas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: 12px;">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
