@extends('layouts.app')

@section('title', 'Pinjam Buku')

@section('content')
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    .loan-container { min-height: 100vh; padding: 40px 20px; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); }
    .loan-wrapper { max-width: 700px; margin: 0 auto; }
    .loan-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px; padding: 40px; color: white; margin-bottom: 30px; box-shadow: 0 10px 40px rgba(102, 126, 234, 0.2); animation: slideDown 0.6s ease-out; }
    .loan-header h1 { font-size: 2.2rem; font-weight: 700; margin-bottom: 8px; display: flex; align-items: center; gap: 12px; }
    .loan-header p { color: rgba(255, 255, 255, 0.9); font-size: 0.95rem; }
    .loan-card { background: white; border-radius: 15px; padding: 40px; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08); animation: fadeInUp 0.6s ease-out; }
    .book-info-section { background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%); border-left: 4px solid #667eea; border-radius: 10px; padding: 25px; margin-bottom: 30px; }
    .book-info-section h2 { font-weight: 700; color: #667eea; margin-bottom: 18px; font-size: 1.1rem; }
    .book-info-row { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid rgba(102, 126, 234, 0.2); }
    .book-info-row:last-child { border-bottom: none; }
    .book-info-label { color: #718096; font-weight: 600; font-size: 0.9rem; }
    .book-info-value { font-weight: 700; color: #2d3748; }
    .form-group { margin-bottom: 25px; }
    .form-group label { display: block; font-weight: 700; color: #2d3748; margin-bottom: 12px; font-size: 0.95rem; }
    .duration-options { display: grid; grid-template-columns: repeat(auto-fit, minmax(100px, 1fr)); gap: 12px; margin-bottom: 15px; }
    .duration-option { position: relative; }
    .duration-option input[type="radio"] { display: none; }
    .duration-option label { display: flex; align-items: center; justify-content: center; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; cursor: pointer; transition: all 0.3s ease; font-weight: 600; margin-bottom: 0; }
    .duration-option input[type="radio"]:checked + label { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-color: #667eea; }
    .duration-option:hover label { border-color: #667eea; }
    .form-group input[type="number"] { width: 100%; padding: 12px 15px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 0.95rem; transition: all 0.3s ease; font-family: inherit; }
    .form-group input[type="number"]:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
    .due-date-section { background: linear-gradient(135deg, rgba(246, 173, 85, 0.1) 0%, rgba(237, 137, 54, 0.1) 100%); border-left: 4px solid #f6ad55; border-radius: 10px; padding: 20px; margin-bottom: 25px; }
    .due-date-label { font-size: 0.9rem; color: #718096; margin-bottom: 8px; display: flex; align-items: center; gap: 8px; }
    #dueDate { font-size: 1.3rem; color: #ed8936; font-weight: 700; }
    .terms-section { background: #f7fafc; border-radius: 10px; padding: 20px; margin-bottom: 25px; }
    .terms-section h3 { font-weight: 700; color: #2d3748; margin-bottom: 15px; font-size: 1rem; }
    .terms-list { list-style: none; }
    .terms-list li { padding: 10px 0; color: #4a5568; font-size: 0.9rem; display: flex; align-items: flex-start; gap: 10px; }
    .terms-list i { color: #48bb78; margin-top: 3px; flex-shrink: 0; }
    .checkbox-group { display: flex; align-items: flex-start; gap: 12px; padding: 15px; background: #f7fafc; border-radius: 8px; margin-bottom: 25px; }
    .checkbox-group input[type="checkbox"] { width: 20px; height: 20px; cursor: pointer; margin-top: 2px; flex-shrink: 0; }
    .checkbox-group label { color: #4a5568; font-size: 0.95rem; margin-bottom: 0; cursor: pointer; }
    .form-actions { display: flex; gap: 15px; margin-top: 35px; }
    .form-btn { flex: 1; padding: 14px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; font-size: 1rem; }
    .btn-submit { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3); }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4); }
    .btn-cancel { background: #e2e8f0; color: #4a5568; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); }
    .btn-cancel:hover { background: #cbd5e0; transform: translateY(-2px); }
    .error-message { color: #f56565; font-size: 0.85rem; margin-top: 6px; display: flex; align-items: center; gap: 6px; }
    @keyframes slideDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    @media (max-width: 768px) { 
        .loan-container { padding: 20px 15px; }
        .loan-header { padding: 30px 20px; margin-bottom: 20px; }
        .loan-header h1 { font-size: 1.8rem; }
        .loan-card { padding: 25px; }
        .duration-options { grid-template-columns: repeat(3, 1fr); }
        .form-actions { flex-direction: column; }
    }
</style>

<div class="loan-container">
    <div class="loan-wrapper">
        <div class="loan-header">
            <h1><i class="fas fa-book-open"></i> Pinjam Buku</h1>
            <p>Isi formulir untuk meminjam buku ini. Data akan dikirim ke petugas untuk diverifikasi.</p>
        </div>

        <div class="loan-card">
            <form action="{{ route('loans.store', ['book' => $book->id]) }}" method="POST">
                @csrf

                <div class="book-info-section">
                    <h2><i class="fas fa-info-circle"></i> Informasi Buku</h2>
                    <div class="book-info-row">
                        <span class="book-info-label">Judul:</span>
                        <span class="book-info-value">{{ $book->title }}</span>
                    </div>
                    <div class="book-info-row">
                        <span class="book-info-label">Pengarang:</span>
                        <span class="book-info-value">{{ $book->author }}</span>
                    </div>
                    <div class="book-info-row">
                        <span class="book-info-label">Kategori:</span>
                        <span class="book-info-value">{{ $book->category->name ?? '-' }}</span>
                    </div>
                    <div class="book-info-row">
                        <span class="book-info-label">Tersedia:</span>
                        <span class="book-info-value" style="color: #48bb78;">{{ $book->available_quantity }} eksemplar</span>
                    </div>
                </div>

                <input type="hidden" name="book_id" value="{{ $book->id }}">

                <div class="form-group">
                    <label><i class="fas fa-calendar"></i> Durasi Peminjaman (hari) <span style="color: #f56565;">*</span></label>
                    
                    <div class="duration-options">
                        @foreach([3, 7, 14, 21, 30] as $days)
                            <div class="duration-option">
                                <input type="radio" id="days_{{ $days }}" name="loan_days_preset" value="{{ $days }}" onchange="document.getElementById('loan_days').value = this.value; updateDueDate()">
                                <label for="days_{{ $days }}">{{ $days }} hari</label>
                            </div>
                        @endforeach
                    </div>

                    <input type="number" id="loan_days" name="loan_days" value="{{ old('loan_days', 7) }}" min="1" max="30" placeholder="Atau masukkan jumlah hari" required onchange="updateDueDate()" oninput="updateDueDate()">
                    
                    @error('loan_days')
                        <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="due-date-section">
                    <div class="due-date-label"><i class="fas fa-calendar-check"></i> <strong>Perkiraan Tanggal Kembali:</strong></div>
                    <div id="dueDate">{{ now()->addDays(old('loan_days', 7))->format('d M Y') }}</div>
                </div>

                <div class="terms-section">
                    <h3><i class="fas fa-list-check"></i> Syarat dan Ketentuan Peminjaman</h3>
                    <ul class="terms-list">
                        <li><i class="fas fa-check"></i><span>Buku harus dikembalikan sesuai tanggal kembali yang ditentukan</span></li>
                        <li><i class="fas fa-check"></i><span>Buku harus dalam kondisi baik saat dikembalikan</span></li>
                        <li><i class="fas fa-check"></i><span>Keterlambatan akan dikenakan denda sesuai ketentuan</span></li>
                        <li><i class="fas fa-check"></i><span>Anda dapat memperpanjang peminjaman jika tersedia</span></li>
                        <li><i class="fas fa-check"></i><span>Peminjaman akan diverifikasi petugas perpustakaan</span></li>
                    </ul>
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" id="agree" name="agree" required>
                    <label for="agree">Saya setuju dengan semua syarat dan ketentuan peminjaman buku</label>
                </div>

                <div class="form-actions">
                    <button type="submit" class="form-btn btn-submit">
                        <i class="fas fa-check"></i> Lanjutkan Peminjaman
                    </button>
                    <a href="{{ route('books.show', $book) }}" class="form-btn btn-cancel">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function updateDueDate() {
        const loanDays = parseInt(document.getElementById('loan_days').value) || 7;
        const today = new Date();
        const dueDate = new Date(today.getTime() + loanDays * 24 * 60 * 60 * 1000);
        const options = { year: 'numeric', month: 'short', day: 'numeric' };
        document.getElementById('dueDate').textContent = dueDate.toLocaleDateString('id-ID', options);
    }
    document.addEventListener('DOMContentLoaded', function() { updateDueDate(); });
</script>
@endsection
