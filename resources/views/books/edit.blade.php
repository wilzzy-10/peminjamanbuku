@extends('layouts.app')

@section('title', 'Edit Buku')

@section('content')
<style>
    .form-container {
        min-height: 100vh;
        padding: 40px 20px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    .form-wrapper {
        max-width: 900px;
        margin: 0 auto;
    }

    .form-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 34px 36px;
        color: white;
        margin-bottom: 24px;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.2);
        animation: slideDown 0.6s ease-out;
    }

    .form-header h1 {
        font-size: 2rem;
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
        padding: 32px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        animation: fadeInUp 0.6s ease-out;
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
        margin: 6px 0 0;
        padding: 0;
    }

    .error-list li {
        padding: 3px 0;
    }

    .error-list li::before {
        content: "* ";
        color: #f56565;
        font-weight: bold;
        margin-right: 4px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .field-full {
        grid-column: 1 / -1;
    }

    .form-group label {
        display: block;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 8px;
        font-size: 0.95rem;
    }

    .required {
        color: #f56565;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 13px 14px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: all 0.25s ease;
        font-family: inherit;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .help-text {
        font-size: 0.84rem;
        color: #718096;
        margin-top: 6px;
    }

    .field-error {
        color: #e53e3e;
        font-size: 0.84rem;
        margin-top: 6px;
    }

    .info-box {
        margin-top: 22px;
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(37, 99, 235, 0.06) 100%);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-left: 4px solid #3b82f6;
        border-radius: 10px;
        padding: 14px;
        color: #1e3a8a;
        font-size: 0.9rem;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e2e8f0;
    }

    .form-btn {
        flex: 1;
        padding: 13px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-size: 0.96rem;
        text-decoration: none;
    }

    .btn-submit {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(72, 187, 120, 0.3);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(72, 187, 120, 0.4);
    }

    .btn-cancel {
        background: #e2e8f0;
        color: #4a5568;
    }

    .btn-cancel:hover {
        background: #cbd5e0;
        transform: translateY(-2px);
    }

    .btn-delete {
        background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(245, 101, 101, 0.3);
    }

    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(245, 101, 101, 0.4);
    }

    @media (max-width: 768px) {
        .form-container {
            padding: 20px 15px;
        }

        .form-header {
            padding: 28px 22px;
        }

        .form-header h1 {
            font-size: 1.6rem;
        }

        .form-card {
            padding: 22px;
        }

        .form-grid {
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
        <div class="form-header">
            <h1>
                <i class="fas fa-edit"></i> Edit Buku
            </h1>
            <p>Perbarui data buku: {{ $book->title }}</p>
        </div>

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

            <form action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="form-group field-full">
                        <label for="title">Judul Buku <span class="required">*</span></label>
                        <input id="title" type="text" name="title" value="{{ old('title', $book->title) }}" required>
                        @error('title')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="author">Pengarang <span class="required">*</span></label>
                        <input id="author" type="text" name="author" value="{{ old('author', $book->author) }}" required>
                        @error('author')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="isbn">ISBN <span class="required">*</span></label>
                        <input id="isbn" type="text" name="isbn" value="{{ old('isbn', $book->isbn) }}" required>
                        @error('isbn')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="category_id">Kategori <span class="required">*</span></label>
                        <select id="category_id" name="category_id" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id', $book->category_id) == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="publisher">Penerbit</label>
                        <input id="publisher" type="text" name="publisher" value="{{ old('publisher', $book->publisher) }}">
                    </div>

                    <div class="form-group">
                        <label for="year">Tahun Terbit</label>
                        <input id="year" type="number" name="year" value="{{ old('year', $book->year) }}" min="1000" max="{{ date('Y') }}">
                    </div>

                    <div class="form-group">
                        <label for="quantity">Jumlah Stok <span class="required">*</span></label>
                        <input id="quantity" type="number" name="quantity" value="{{ old('quantity', $book->quantity) }}" min="1" required>
                        @error('quantity')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group field-full">
                        <label for="description">Deskripsi</label>
                        <textarea id="description" name="description" rows="4" placeholder="Deskripsi singkat tentang buku...">{{ old('description', $book->description) }}</textarea>
                    </div>
                </div>

                <div class="info-box">
                    <i class="fas fa-info-circle"></i>
                    <strong> Informasi:</strong> Stok tersedia saat ini <strong>{{ $book->available_quantity }}</strong> dari total <strong>{{ $book->quantity }}</strong>.
                </div>

                <div class="form-actions">
                    <button type="submit" class="form-btn btn-submit">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>

                    <a href="{{ route('books.show', $book) }}" class="form-btn btn-cancel">
                        <i class="fas fa-times"></i> Batal
                    </a>

                    <button type="button" class="form-btn btn-delete" onclick="if(confirm('Yakin ingin menghapus buku ini?')) { document.getElementById('deleteForm').submit(); }">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </div>
            </form>

            <form id="deleteForm" action="{{ route('books.destroy', $book) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>
@endsection
