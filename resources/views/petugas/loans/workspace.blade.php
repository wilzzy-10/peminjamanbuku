@extends('layouts.app')

@section('title', $pageTitle)

@section('content')
<style>
    .workspace-page { min-height: 100vh; padding: 32px 20px; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); }
    .workspace-wrap { max-width: 1350px; margin: 0 auto; }
    .hero { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; border-radius: 14px; padding: 28px; margin-bottom: 20px; }
    .toolbar { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 18px; }
    .toolbar a { text-decoration: none; padding: 9px 12px; border-radius: 8px; background: #fff; color: #4a5568; font-weight: 600; border: 1px solid #d1d9e6; }
    .toolbar a.active { background: #667eea; color: #fff; border-color: #667eea; }
    .table-card { background: #fff; border-radius: 12px; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08); overflow: hidden; }
    .table-head { background: #f8fafc; padding: 14px 16px; border-bottom: 1px solid #e2e8f0; font-weight: 700; color: #2d3748; }
    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; min-width: 980px; }
    th, td { padding: 11px 12px; border-bottom: 1px solid #e2e8f0; text-align: left; font-size: 14px; color: #4a5568; vertical-align: top; }
    th { text-transform: uppercase; font-size: 12px; color: #718096; background: #f8fafc; }
    .name-link { color: #2d3748; text-decoration: none; font-weight: 600; }
    .muted { font-size: 12px; color: #718096; margin-top: 2px; }
    .badge { display: inline-flex; align-items: center; gap: 6px; border-radius: 999px; padding: 6px 10px; font-size: 12px; font-weight: 700; }
    .s-pending { background: #feebc8; color: #7b341e; }
    .s-active { background: #bee3f8; color: #2a4365; }
    .s-returned { background: #c6f6d5; color: #22543d; }
    .s-rejected { background: #e2e8f0; color: #2d3748; }
    .s-overdue { background: #fed7d7; color: #822727; }
    .action-btn { border: none; border-radius: 7px; padding: 8px 10px; color: #fff; font-weight: 600; cursor: pointer; font-size: 12px; }
    .ok { background: #38a169; }
    .warn { background: #dd6b20; }
    .danger { background: #e53e3e; }
    .pagination { padding: 14px 16px; display: flex; justify-content: center; }
</style>

<div class="workspace-page">
    <div class="workspace-wrap">
        <div class="hero">
            <h1 style="font-size: 30px; font-weight: 800;">{{ $pageTitle }}</h1>
            <p style="opacity: .9;">{{ $pageSubtitle }}</p>
        </div>

        <div class="toolbar">
            <a href="{{ route('petugas.approvals.index') }}" class="{{ request()->routeIs('petugas.approvals.index') ? 'active' : '' }}">Persetujuan</a>
            <a href="{{ route('petugas.returns.verification') }}" class="{{ request()->routeIs('petugas.returns.verification') ? 'active' : '' }}">Verifikasi Pengembalian</a>
            <a href="{{ route('petugas.overdue.monitor') }}" class="{{ request()->routeIs('petugas.overdue.monitor') ? 'active' : '' }}">Monitor Keterlambatan</a>
            <a href="{{ route('petugas.reports.loans') }}">Laporan Peminjaman</a>
            <a href="{{ route('petugas.reports.export') }}">Ekspor Laporan</a>
        </div>

        <div class="table-card">
            <div class="table-head">Daftar Peminjaman ({{ $loans->total() }} data)</div>
            @if($loans->count() > 0)
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Peminjam</th>
                                <th>Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Jatuh Tempo</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($loans as $loan)
                                @php
                                    $statusKey = $loan->status === 'active' && $loan->isOverdue() ? 'overdue' : $loan->status;
                                @endphp
                                <tr>
                                    <td>
                                        <a class="name-link" href="{{ route('profile.show') }}">{{ $loan->user->name }}</a>
                                        <p class="muted">{{ $loan->user->email }}</p>
                                    </td>
                                    <td>
                                        <a class="name-link" href="{{ route('books.show', $loan->book) }}">{{ $loan->book->title }}</a>
                                        <p class="muted">{{ $loan->book->author }}</p>
                                    </td>
                                    <td>{{ $loan->loan_date->format('d/m/Y H:i') }}</td>
                                    <td>
                                        {{ $loan->due_date->format('d/m/Y') }}
                                        @if($loan->status === 'active' && $loan->isOverdue())
                                            <p class="muted" style="color:#c53030">{{ $loan->getDaysOverdue() }} hari terlambat</p>
                                        @endif
                                    </td>
                                    <td><span class="badge s-{{ $statusKey }}">{{ ucfirst($statusKey) }}</span></td>
                                    <td>
                                        @if($loan->status === 'pending')
                                            <div style="display:flex; gap:8px; flex-wrap:wrap;">
                                                <form method="POST" action="{{ route('loans.approve', $loan) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <button class="action-btn warn" type="submit">Setujui</button>
                                                </form>
                                                <form method="POST" action="{{ route('loans.reject', $loan) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <button class="action-btn danger" type="submit">Tolak</button>
                                                </form>
                                            </div>
                                        @elseif($loan->status === 'active')
                                            <form method="POST" action="{{ route('loans.verify-return', $loan) }}">
                                                @csrf
                                                @method('PUT')
                                                <button class="action-btn ok" type="submit">Verifikasi</button>
                                            </form>
                                        @else
                                            <span class="muted">Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="pagination">
                    {{ $loans->links() }}
                </div>
            @else
                <div style="padding:30px 20px; color:#718096;">Belum ada data pada kategori ini.</div>
            @endif
        </div>
    </div>
</div>
@endsection
