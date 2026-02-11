@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
<style>
    .category-form-page {
        max-width: 1100px;
        margin: 0 auto;
        padding: 30px 16px;
    }

    .category-form-layout {
        display: grid;
        grid-template-columns: minmax(0, 2fr) minmax(0, 1fr);
        gap: 24px;
    }

    .category-main-card {
        background: #ffffff;
        border-radius: 14px;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .category-main-header {
        padding: 20px 24px;
        background: linear-gradient(90deg, #2563eb 0%, #4338ca 100%);
        color: #ffffff;
    }

    .category-main-header h1 {
        margin: 0;
        font-size: 1.6rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .category-main-header p {
        margin: 8px 0 0;
        color: #dbeafe;
        font-size: 0.92rem;
    }

    .category-form {
        padding: 24px;
    }

    .category-field {
        margin-bottom: 18px;
    }

    .category-field label {
        display: block;
        margin-bottom: 8px;
        font-size: 0.92rem;
        font-weight: 700;
        color: #374151;
    }

    .category-field label i {
        color: #2563eb;
        margin-right: 4px;
    }

    .category-field input,
    .category-field textarea {
        width: 100%;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        padding: 11px 14px;
        font-size: 0.95rem;
        background: #ffffff;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .category-field input:focus,
    .category-field textarea:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }

    .category-field textarea {
        min-height: 110px;
        resize: vertical;
    }

    .field-invalid {
        border-color: #f87171 !important;
    }

    .field-error-text {
        color: #dc2626;
        font-size: 0.85rem;
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

    .info-box {
        border: 1px solid #dbeafe;
        background: #eff6ff;
        color: #1e3a8a;
        border-radius: 10px;
        padding: 12px 14px;
        margin-bottom: 18px;
        font-size: 0.9rem;
    }

    .category-actions {
        display: flex;
        gap: 12px;
        border-top: 1px solid #e5e7eb;
        padding-top: 18px;
        margin-top: 6px;
    }

    .category-btn {
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

    .category-btn-primary {
        background: #2563eb;
        color: #ffffff;
    }

    .category-btn-primary:hover {
        background: #1d4ed8;
    }

    .category-btn-muted {
        background: #e5e7eb;
        color: #374151;
    }

    .category-btn-muted:hover {
        background: #d1d5db;
    }

    .category-side {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .category-side-card {
        background: #ffffff;
        border: 1px solid #f3f4f6;
        border-radius: 14px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        padding: 18px;
    }

    .category-side-card h2,
    .category-side-card h3 {
        margin: 0 0 10px;
        font-size: 1rem;
        font-weight: 700;
        color: #1f2937;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .category-side-card h2 i {
        color: #f59e0b;
    }

    .category-side-card p,
    .category-side-card li {
        margin: 0;
        color: #4b5563;
        font-size: 0.9rem;
        line-height: 1.55;
    }

    .category-side-card .summary-list p + p {
        margin-top: 6px;
    }

    .category-side-card.category-tips {
        background: #eff6ff;
        border-color: #dbeafe;
    }

    .category-side-card.category-tips h3 {
        color: #1e3a8a;
        display: block;
    }

    .category-side-card.category-tips ul {
        margin: 0;
        padding-left: 18px;
        color: #1e40af;
        font-size: 0.9rem;
    }

    .category-side-card.category-tips li + li {
        margin-top: 4px;
    }

    @media (max-width: 980px) {
        .category-form-layout {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 640px) {
        .category-main-header,
        .category-form {
            padding-left: 16px;
            padding-right: 16px;
        }

        .category-actions {
            flex-direction: column;
        }
    }
</style>

<div class="category-form-page">
    <div class="category-form-layout">
        <div class="category-main-card">
            <div class="category-main-header">
                <h1>
                    <i class="fas fa-edit"></i>
                    Edit Kategori
                </h1>
                <p>Perbarui informasi kategori: <strong>{{ $category->name }}</strong></p>
            </div>

            <form action="{{ route('categories.update', $category) }}" method="POST" class="category-form">
                @csrf
                @method('PUT')

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

                <div class="category-field">
                    <label for="name">
                        <i class="fas fa-bookmark"></i>
                        Nama Kategori <span style="color:#ef4444">*</span>
                    </label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        required
                        value="{{ old('name', $category->name) }}"
                        placeholder="Contoh: Fiksi, Non-Fiksi, Pendidikan"
                        class="@error('name') field-invalid @enderror"
                    >
                    @error('name')
                        <p class="field-error-text">{{ $message }}</p>
                    @enderror
                </div>

                <div class="category-field">
                    <label for="description">
                        <i class="fas fa-file-alt"></i>
                        Deskripsi
                    </label>
                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        placeholder="Deskripsi kategori (opsional)"
                    >{{ old('description', $category->description) }}</textarea>
                </div>

                <div class="info-box">
                    <i class="fas fa-info-circle"></i>
                    Kategori ini saat ini memiliki <strong>{{ $category->books->count() }}</strong> buku.
                </div>

                <div class="category-actions">
                    <button type="submit" class="category-btn category-btn-primary">
                        <i class="fas fa-save"></i>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('categories.index') }}" class="category-btn category-btn-muted">
                        <i class="fas fa-times"></i>
                        Batal
                    </a>
                </div>
            </form>
        </div>

        <div class="category-side">
            <div class="category-side-card">
                <h2>
                    <i class="fas fa-layer-group"></i>
                    Ringkasan Kategori
                </h2>
                <div class="summary-list">
                    <p><strong>Nama Saat Ini:</strong> {{ $category->name }}</p>
                    <p><strong>Total Buku:</strong> {{ $category->books->count() }}</p>
                </div>
            </div>

            <div class="category-side-card category-tips">
                <h3>Catatan Edit</h3>
                <ul>
                    <li>Pastikan nama kategori tetap jelas.</li>
                    <li>Hindari duplikasi dengan kategori lain.</li>
                    <li>Perubahan akan memengaruhi semua buku di kategori ini.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
