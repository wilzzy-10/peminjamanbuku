@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-8">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-lg p-8 shadow-lg">
        <h1 class="text-4xl font-bold mb-2">Dashboard Admin</h1>
        <p class="text-purple-100">Kelola koleksi buku, pengguna, dan peminjaman buku</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-600">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-semibold">Total Buku</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $totalBooks }}</p>
                </div>
                <i class="fas fa-book text-4xl text-blue-200"></i>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-600">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-semibold">Total Pengguna</p>
                    <p class="text-3xl font-bold text-green-600">{{ $totalUsers }}</p>
                </div>
                <i class="fas fa-users text-4xl text-green-200"></i>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-600">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-semibold">Peminjaman Aktif</p>
                    <p class="text-3xl font-bold text-yellow-600">{{ $activeLoans }}</p>
                </div>
                <i class="fas fa-hand-holding-book text-4xl text-yellow-200"></i>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-600">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-semibold">Overdue</p>
                    <p class="text-3xl font-bold text-red-600">{{ $overdueLoans }}</p>
                </div>
                <i class="fas fa-exclamation-triangle text-4xl text-red-200"></i>
            </div>
        </div>
    </div>

    <!-- Management Links -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center mb-4">
                <i class="fas fa-book text-3xl text-blue-600 mr-4"></i>
                <h3 class="text-xl font-bold text-gray-800">Koleksi Buku</h3>
            </div>
            <p class="text-gray-600 mb-4">Tambah dan kelola koleksi buku</p>
            <div class="space-y-2">
                <a href="{{ route('books.index') }}" class="block text-blue-600 hover:underline">
                    <i class="fas fa-list"></i> Lihat Semua Buku
                </a>
                <a href="{{ route('books.create') }}" class="block text-blue-600 hover:underline">
                    <i class="fas fa-plus"></i> Tambah Buku Baru
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center mb-4">
                <i class="fas fa-tags text-3xl text-green-600 mr-4"></i>
                <h3 class="text-xl font-bold text-gray-800">Kategori</h3>
            </div>
            <p class="text-gray-600 mb-4">Kelola kategori buku</p>
            <div class="space-y-2">
                <a href="{{ route('categories.index') }}" class="block text-green-600 hover:underline">
                    <i class="fas fa-list"></i> Daftar Kategori
                </a>
                <a href="{{ route('categories.create') }}" class="block text-green-600 hover:underline">
                    <i class="fas fa-plus"></i> Tambah Kategori
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center mb-4">
                <i class="fas fa-handshake text-3xl text-purple-600 mr-4"></i>
                <h3 class="text-xl font-bold text-gray-800">Peminjaman</h3>
            </div>
            <p class="text-gray-600 mb-4">Kelola peminjaman buku</p>
            <div class="space-y-2">
                <a href="{{ route('loans.index') }}" class="block text-purple-600 hover:underline">
                    <i class="fas fa-list"></i> Lihat Semua Peminjaman
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center mb-4">
                <i class="fas fa-users text-3xl text-red-600 mr-4"></i>
                <h3 class="text-xl font-bold text-gray-800">Pengguna</h3>
            </div>
            <p class="text-gray-600 mb-4">Kelola pengguna sistem</p>
            <div class="space-y-2">
                <a href="{{ route('users.index') }}" class="block text-red-600 hover:underline">
                    <i class="fas fa-list"></i> Daftar Pengguna
                </a>
                <a href="{{ route('users.create') }}" class="block text-red-600 hover:underline">
                    <i class="fas fa-plus"></i> Tambah Pengguna
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Loans -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-800">
                <i class="fas fa-history"></i> Peminjaman Terbaru
            </h2>
            <a href="{{ route('loans.index') }}" class="text-blue-600 hover:underline text-sm font-semibold">
                Lihat Semua →
            </a>
        </div>

        @if($recentLoans->isEmpty())
            <div class="px-6 py-12 text-center text-gray-500">
                <i class="fas fa-inbox text-4xl mb-4"></i>
                <p>Belum ada peminjaman</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Peminjam</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Buku</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Tanggal Peminjaman</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Batas Kembali</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($recentLoans as $loan)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <a href="{{ route('profile.show', $loan->user) }}" class="text-blue-600 hover:underline font-semibold">
                                        {{ $loan->user->name }}
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('books.show', $loan->book) }}" class="text-blue-600 hover:underline">
                                        {{ $loan->book->title }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $loan->loan_date->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $loan->due_date->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($loan->status === 'returned')
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                            <i class="fas fa-check"></i> Dikembalikan
                                        </span>
                                    @elseif($loan->isOverdue())
                                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">
                                            <i class="fas fa-exclamation-circle"></i> Overdue
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                                            <i class="fas fa-clock"></i> Aktif
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
