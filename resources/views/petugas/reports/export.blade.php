@extends('layouts.app')

@section('title', 'Ekspor Laporan')

@section('content')
<style>
    .export-page { min-height: 100vh; padding: 32px 20px; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); }
    .export-wrap { max-width: 960px; margin: 0 auto; }
    .hero { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; border-radius: 14px; padding: 28px; margin-bottom: 20px; }
    .card { background: #fff; border-radius: 12px; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08); padding: 22px; }
    .grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px; margin-bottom: 16px; }
    label { font-size: 13px; color: #4a5568; font-weight: 700; display: block; margin-bottom: 7px; }
    select { width: 100%; border: 1px solid #cbd5e0; border-radius: 8px; padding: 10px; }
    .btn { display: inline-flex; align-items: center; gap: 8px; border: none; border-radius: 8px; padding: 11px 14px; font-weight: 700; cursor: pointer; }
    .btn-primary { background: #667eea; color: #fff; }
    .btn-muted { background: #edf2f7; color: #2d3748; text-decoration: none; }
    @media (max-width: 760px) { .grid { grid-template-columns: 1fr; } }
</style>

<div class="export-page">
    <div class="export-wrap">
        <div class="hero">
            <h1 style="font-size:30px; font-weight:800;">Ekspor Laporan</h1>
            <p style="opacity:.9;">Unduh data peminjaman dalam format CSV untuk kebutuhan audit dan pelaporan.</p>
        </div>

        <div class="card">
            <form method="GET" action="{{ route('petugas.reports.export.csv') }}">
                <div class="grid">
                    <div>
                        <label for="days">Periode</label>
                        <select id="days" name="days">
                            @foreach([7, 30, 90, 365] as $period)
                                <option value="{{ $period }}" @selected($days === $period)>{{ $period }} hari terakhir</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            <option value="">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="active">Aktif</option>
                            <option value="overdue">Overdue</option>
                            <option value="returned">Dikembalikan</option>
                            <option value="rejected">Ditolak</option>
                        </select>
                    </div>
                </div>

                <div style="display:flex; gap:10px; flex-wrap:wrap;">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-file-csv"></i> Download CSV
                    </button>
                    <a class="btn btn-muted" href="{{ route('petugas.reports.loans') }}">
                        <i class="fas fa-chart-line"></i> Kembali ke Laporan
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
