@extends('layouts.app')

@section('title', 'Edit Buku')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-yellow-600 to-yellow-800 text-white">
            <h1 class="text-3xl font-bold">Edit Buku</h1>
            <p class="text-yellow-100">{{ $book->title }}</p>
        </div>

        <form action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-heading"></i> Judul Buku *
                    </label>
                    <input type="text" name="title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 @error('title') border-red-500 @enderror"
                           value="{{ old('title', $book->title) }}" required>
                    @error('title')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Author -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-user"></i> Pengarang *
                    </label>
                    <input type="text" name="author" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 @error('author') border-red-500 @enderror"
                           value="{{ old('author', $book->author) }}" required>
                    @error('author')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- ISBN -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-barcode"></i> ISBN *
                    </label>
                    <input type="text" name="isbn" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 @error('isbn') border-red-500 @enderror"
                           value="{{ old('isbn', $book->isbn) }}" required>
                    @error('isbn')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-tag"></i> Kategori *
                    </label>
                    <select name="category_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 @error('category_id') border-red-500 @enderror" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $book->category_id) == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Publisher -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-building"></i> Penerbit
                    </label>
                    <input type="text" name="publisher" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"
                           value="{{ old('publisher', $book->publisher) }}">
                </div>

                <!-- Year -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-calendar"></i> Tahun Terbit
                    </label>
                    <input type="number" name="year" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"
                           value="{{ old('year', $book->year) }}" min="1000" max="{{ date('Y') }}">
                </div>

                <!-- Quantity -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-copy"></i> Jumlah Stok *
                    </label>
                    <input type="number" name="quantity" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 @error('quantity') border-red-500 @enderror"
                           value="{{ old('quantity', $book->quantity) }}" min="1" required>
                    @error('quantity')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-file-alt"></i> Deskripsi
                    </label>
                    <textarea name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"
                              placeholder="Deskripsi singkat tentang buku...">{{ old('description', $book->description) }}</textarea>
                </div>
            </div>

            <!-- Info Section -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-blue-700 text-sm">
                    <i class="fas fa-info-circle"></i>
                    <strong>Informasi:</strong> Stok tersedia saat ini: <strong>{{ $book->available_quantity }}</strong> / <strong>{{ $book->quantity }}</strong>
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4 pt-6 border-t">
                <button type="submit" class="flex-1 bg-yellow-600 text-white py-2 rounded-lg hover:bg-yellow-700 font-semibold flex items-center justify-center gap-2">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>

                <a href="{{ route('books.show', $book) }}" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-400 font-semibold flex items-center justify-center gap-2">
                    <i class="fas fa-times"></i> Batal
                </a>

                <button type="button" onclick="if(confirm('Yakin ingin menghapus buku ini?')) { document.getElementById('deleteForm').submit(); }" class="flex-1 bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 font-semibold flex items-center justify-center gap-2">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </div>
        </form>

        <!-- Delete Form (Hidden) -->
        <form id="deleteForm" action="{{ route('books.destroy', $book) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>
@endsection
