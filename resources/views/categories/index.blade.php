@extends('layouts.app')

@section('title', 'Kategori Buku')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .categories-container {
        min-height: 100vh;
        padding: 40px 20px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    .categories-wrapper {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Header Section */
    .categories-header {
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

    .add-category-btn {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 14px 28px;
        border-radius: 10px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        font-size: 1rem;
    }

    .add-category-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.5);
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    /* Categories Grid */
    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }

    .category-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        animation: fadeInUp 0.6s ease-out;
        border-top: 4px solid #667eea;
        position: relative;
        overflow: hidden;
    }

    .category-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .category-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(102, 126, 234, 0.15);
    }

    .category-card:hover::before {
        top: -30%;
        right: -30%;
    }

    .category-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 20px;
        position: relative;
        z-index: 1;
    }

    .category-info h3 {
        font-size: 1.4rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 8px;
    }

    .category-info p {
        font-size: 0.95rem;
        color: #718096;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .category-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 10px 16px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 700;
        min-width: 60px;
        text-align: center;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .category-description {
        color: #4a5568;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 20px;
        position: relative;
        z-index: 1;
        min-height: 60px;
    }

    .category-description.empty {
        color: #a0aec0;
        font-style: italic;
    }

    /* Action Buttons */
    .category-actions {
        display: flex;
        gap: 12px;
        padding-top: 20px;
        border-top: 1px solid #e2e8f0;
        position: relative;
        z-index: 1;
    }

    .action-btn {
        flex: 1;
        padding: 12px;
        border-radius: 10px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-size: 0.9rem;
    }

    .action-btn:hover {
        transform: translateY(-2px);
    }

    .btn-edit {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(72, 187, 120, 0.3);
    }

    .btn-edit:hover {
        box-shadow: 0 8px 25px rgba(72, 187, 120, 0.4);
    }

    .btn-delete {
        background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(245, 101, 101, 0.3);
    }

    .btn-delete:hover {
        box-shadow: 0 8px 25px rgba(245, 101, 101, 0.4);
    }

    /* Empty State */
    .empty-state {
        background: white;
        border-radius: 15px;
        padding: 60px 40px;
        text-align: center;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        animation: fadeInUp 0.6s ease-out;
    }

    .empty-state-icon {
        font-size: 4rem;
        color: #cbd5e0;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 10px;
    }

    .empty-state p {
        font-size: 1.05rem;
        color: #718096;
        margin-bottom: 30px;
        line-height: 1.6;
    }

    .empty-state-action {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 14px 32px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .empty-state-action:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .categories-container {
            padding: 20px 15px;
        }

        .categories-header {
            padding: 30px 20px;
            flex-direction: column;
            text-align: center;
        }

        .header-content h1 {
            font-size: 1.8rem;
        }

        .header-content p {
            font-size: 0.95rem;
        }

        .add-category-btn {
            width: 100%;
            justify-content: center;
        }

        .categories-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .empty-state {
            padding: 40px 20px;
        }

        .empty-state-icon {
            font-size: 3rem;
        }

        .empty-state h3 {
            font-size: 1.3rem;
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
</style>

<div class="categories-container">
    <div class="categories-wrapper">
        <!-- Header -->
        <div class="categories-header">
            <div class="header-content">
                <h1>
                    <i class="fas fa-list"></i> Kategori Buku
                </h1>
                <p>Kelola dan organisir kategori koleksi buku perpustakaan Anda</p>
            </div>
            <a href="{{ route('categories.create') }}" class="add-category-btn">
                <i class="fas fa-plus-circle"></i> Tambah Kategori
            </a>
        </div>

        <!-- Categories Grid -->
        @if($categories->count() > 0)
            <div class="categories-grid">
                @foreach($categories as $category)
                    <div class="category-card">
                        <div class="category-header">
                            <div class="category-info">
                                <h3>{{ $category->name }}</h3>
                                <p>
                                    <i class="fas fa-book"></i>
                                    {{ $category->books->count() }} {{ $category->books->count() == 1 ? 'buku' : 'buku' }}
                                </p>
                            </div>
                            <span class="category-badge">{{ $category->books->count() }}</span>
                        </div>

                        <div class="category-description {{ !$category->description ? 'empty' : '' }}">
                            @if($category->description)
                                {{ Str::limit($category->description, 120) }}
                            @else
                                <i class="fas fa-info-circle"></i> Tidak ada deskripsi
                            @endif
                        </div>

                        <div class="category-actions">
                            <a href="{{ route('categories.edit', $category) }}" class="action-btn btn-edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>

                            <button 
                                type="button"
                                onclick="if(confirm('Yakin ingin menghapus kategori ini? Pastikan tidak ada buku yang tertaut.')) { document.getElementById('deleteForm{{ $category->id }}').submit(); }" 
                                class="action-btn btn-delete">
                                <i class="fas fa-trash-alt"></i> Hapus
                            </button>

                            <form id="deleteForm{{ $category->id }}" action="{{ route('categories.destroy', $category) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-tags"></i>
                </div>
                <h3>Belum Ada Kategori</h3>
                <p>Mulai buat kategori untuk mengorganisir koleksi buku Anda dengan lebih baik</p>
                <a href="{{ route('categories.create') }}" class="empty-state-action">
                    <i class="fas fa-plus-circle"></i> Buat Kategori Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
