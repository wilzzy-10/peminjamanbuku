@extends('layouts.app')

@section('title', 'Manajemen Peminjaman')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-tasks"></i> Manajemen Peminjaman
        </h1>
        <p class="text-gray-600 mt-1">Kelola semua peminjaman buku di sistem</p>
    </div>

    <!-- Loans Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b">
            <h2 class="text-xl font-bold text-gray-800">
                <i class="fas fa-list"></i> Daftar Peminjaman
            </h2>
        </div>

        @if($loans->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Peminjam</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Buku</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Tanggal Peminjaman</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Batas Kembali</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Tanggal Kembali</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Catatan</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($loans as $loan)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <a href="{{ route('profile.show', $loan->user) }}" class="text-blue-600 hover:underline font-semibold">
                                        {{ $loan->user->name }}
                                    </a>
                                    <p class="text-xs text-gray-500">{{ $loan->user->email }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('books.show', $loan->book) }}" class="text-blue-600 hover:underline font-semibold">
                                        {{ $loan->book->title }}
                                    </a>
                                    <p class="text-xs text-gray-500">{{ $loan->book->author }}</p>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $loan->loan_date->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @if($loan->status === 'active' && $loan->isOverdue())
                                        <span class="text-red-600 font-semibold">
                                            {{ $loan->due_date->format('d/m/Y') }}
                                            <span class="text-xs block text-red-500">
                                                ({{ $loan->getDaysOverdue() }} hari)
                                            </span>
                                        </span>
                                    @else
                                        <span class="text-gray-600">{{ $loan->due_date->format('d/m/Y') }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $loan->return_date ? $loan->return_date->format('d/m/Y H:i') : '-' }}
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
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $loan->notes ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @if($loan->status === 'active')
                                        <form method="POST" action="{{ route('loans.admin-return', $loan) }}" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-xs font-semibold">
                                                <i class="fas fa-check"></i> Proses Kembali
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 border-t">
                {{ $loans->links() }}
            </div>
        @else
            <div class="px-6 py-12 text-center text-gray-500">
                <i class="fas fa-inbox text-4xl mb-4"></i>
                <p>Tidak ada peminjaman dalam sistem</p>
            </div>
        @endif
    </div>
</div>
@endsection
