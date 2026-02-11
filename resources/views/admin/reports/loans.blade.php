@extends('layouts.app')

@section('title', 'Laporan Peminjaman')

@section('content')
<style>
    .report-page { min-height: 100vh; padding: 32px 20px; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); }
    .report-wrap { max-width: 1350px; margin: 0 auto; }
    .hero { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; border-radius: 14px; padding: 30px; margin-bottom: 24px; }
    .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 14px; margin-bottom: 24px; }
    .card { background: #fff; border-radius: 12px; padding: 18px; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08); }
    .label { color: #718096; font-size: 12px; text-transform: uppercase; font-weight: 700; margin-bottom: 6px; }
    .value { font-size: 30px; font-weight: 800; color: #2d3748; }
    .section { background: #fff; border-radius: 12px; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08); margin-bottom: 20px; overflow: hidden; }
    .section-head { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; padding: 14px 18px; font-weight: 700; display: flex; justify-content: space-between; align-items: center; gap: 10px; }
    .section-body { padding: 16px 18px; }
    .toolbar { display: flex; gap: 10px; flex-wrap: wrap; }
    .toolbar a { text-decoration: none; padding: 8px 12px; border-radius: 8px; border: 1px solid #d1d9e6; color: #4a5568; font-weight: 600; }
    .toolbar a.active { background: #667eea; color: #fff; border-color: #667eea; }
    .bars { display: grid; gap: 10px; }
    .bar-row { display: grid; grid-template-columns: 120px 1fr 40px; align-items: center; gap: 10px; font-size: 13px; }
    .bar-track { background: #edf2f7; border-radius: 999px; overflow: hidden; height: 10px; }
    .bar-fill { background: linear-gradient(90deg, #667eea, #764ba2); height: 10px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { text-align: left; padding: 10px; border-bottom: 1px solid #e2e8f0; font-size: 14px; }
    th { background: #f8fafc; font-size: 12px; text-transform: uppercase; color: #718096; }
    .badge { padding: 5px 8px; border-radius: 999px; font-size: 12px; font-weight: 700; }
    .s-pending { background: #feebc8; color: #7b341e; }
    .s-active { background: #bee3f8; color: #2a4365; }
    .s-returned { background: #c6f6d5; color: #22543d; }
    .s-rejected { background: #e2e8f0; color: #2d3748; }
    @media (max-width: 760px) { .bar-row { grid-template-columns: 90px 1fr 32px; } }
</style>

<div class="report-page">
    <div class="report-wrap">
        <div class="hero">
            <h1 style="font-size: 30px; font-weight: 800;">Laporan Peminjaman</h1>
            <p style="opacity: .9;">Statistik transaksi peminjaman, status, dan buku terpopuler.</p>
        </div>

        <div class="section">
            <div class="section-head">
                <span>Filter Periode</span>
                <div class="toolbar">
                    @foreach([7, 30, 90, 365] as $period)
                        <a href="{{ route('admin.reports.loans', ['days' => $period]) }}" class="{{ $days === $period ? 'active' : '' }}">{{ $period }} hari</a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="grid">
            <div class="card"><div class="label">Total</div><div class="value">{{ $summary['total'] }}</div></div>
            <div class="card"><div class="label">Pending</div><div class="value">{{ $summary['pending'] }}</div></div>
            <div class="card"><div class="label">Aktif</div><div class="value">{{ $summary['active'] }}</div></div>
            <div class="card"><div class="label">Dikembalikan</div><div class="value">{{ $summary['returned'] }}</div></div>
            <div class="card"><div class="label">Ditolak</div><div class="value">{{ $summary['rejected'] }}</div></div>
            <div class="card"><div class="label">Overdue</div><div class="value">{{ $summary['overdue'] }}</div></div>
        </div>

        <div class="section">
            <div class="section-head">Tren Peminjaman Harian</div>
            <div class="section-body">
                @php $maxDaily = max((int)($dailyLoans->max('total') ?? 1), 1); @endphp
                <div class="bars">
                    @forelse($dailyLoans as $point)
                        <div class="bar-row">
                            <span>{{ \Carbon\Carbon::parse($point->date)->format('d M') }}</span>
                            <div class="bar-track"><div class="bar-fill" style="width: {{ ($point->total / $maxDaily) * 100 }}%"></div></div>
                            <strong>{{ $point->total }}</strong>
                        </div>
                    @empty
                        <p>Belum ada data dalam periode ini.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-head">Top 5 Buku Paling Sering Dipinjam</div>
            <div class="section-body">
                <table>
                    <thead><tr><th>Buku</th><th>Penulis</th><th>Total</th></tr></thead>
                    <tbody>
                    @forelse($topBooks as $row)
                        <tr>
                            <td>{{ $row->book->title ?? 'Buku dihapus' }}</td>
                            <td>{{ $row->book->author ?? '-' }}</td>
                            <td><strong>{{ $row->total }}</strong></td>
                        </tr>
                    @empty
                        <tr><td colspan="3">Belum ada data.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="section">
            <div class="section-head">Transaksi Terbaru</div>
            <div class="section-body">
                <table>
                    <thead><tr><th>Waktu</th><th>Peminjam</th><th>Buku</th><th>Status</th></tr></thead>
                    <tbody>
                    @forelse($recentLoans as $loan)
                        <tr>
                            <td>{{ $loan->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $loan->user->name ?? '-' }}</td>
                            <td>{{ $loan->book->title ?? '-' }}</td>
                            <td>
                                <span class="badge s-{{ $loan->status }}">{{ ucfirst($loan->status) }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4">Belum ada transaksi.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
