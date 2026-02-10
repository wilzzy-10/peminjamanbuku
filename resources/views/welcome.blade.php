<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Peminjaman Buku - Koleksi Lengkap Bacaan Terbaik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .book-card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .book-card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Top Navigation Bar -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-2 group">
                        <div class="bg-gradient-to-br from-blue-600 to-purple-600 p-2 rounded-lg">
                            <i class="fas fa-book text-white text-xl"></i>
                        </div>
                        <span class="text-2xl font-bold text-gray-800 group-hover:text-blue-600 transition">Perpustakaan</span>
                    </a>
                </div>

                <!-- Center Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-gray-600 hover:text-blue-600 font-medium transition">Beranda</a>
                    <a href="{{ route('books.index') }}" class="text-gray-600 hover:text-blue-600 font-medium transition">Koleksi Buku</a>
                    <a href="#" class="text-gray-600 hover:text-blue-600 font-medium transition">Tentang Kami</a>
                </div>

                <!-- Auth Buttons (Right Top) -->
                <div class="flex items-center space-x-3">
                    @auth
                        <div class="relative group">
                            <button class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 focus:outline-none">
                                <i class="fas fa-user-circle text-2xl"></i>
                                <span class="hidden sm:inline text-sm font-medium">{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 rounded-t-lg border-b">
                                    <i class="fas fa-tachometer-alt text-blue-600 mr-2"></i> Dashboard
                                </a>
                                <a href="{{ route('loans.my-loans') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 border-b">
                                    <i class="fas fa-list text-blue-600 mr-2"></i> Peminjaman Saya
                                </a>
                                <a href="{{ route('profile.show', auth()->user()) }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 border-b">
                                    <i class="fas fa-user text-blue-600 mr-2"></i> Profil
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 rounded-b-lg">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-blue-600 font-semibold hover:text-blue-700 transition">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg font-semibold hover:shadow-lg hover:scale-105 transition transform">
                            Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-gradient text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-5xl md:text-6xl font-bold mb-6">
                        Jelajahi Dunia Pengetahuan
                    </h1>
                    <p class="text-xl text-blue-100 mb-8">
                        Akses ribuan buku dari berbagai kategori. Pinjam, baca, dan kembangkan ilmu Anda bersama perpustakaan digital kami.
                    </p>
                    <div class="flex gap-4">
                        @guest
                            <a href="{{ route('register') }}" class="px-8 py-3 bg-white text-blue-600 font-bold rounded-lg hover:shadow-lg transition transform hover:scale-105">
                                Daftar Sekarang
                            </a>
                            <a href="{{ route('books.index') }}" class="px-8 py-3 bg-blue-500 text-white font-bold rounded-lg hover:bg-blue-700 transition">
                                Jelajahi Koleksi
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="px-8 py-3 bg-white text-blue-600 font-bold rounded-lg hover:shadow-lg transition transform hover:scale-105">
                                Go to Dashboard
                            </a>
                            <a href="{{ route('books.index') }}" class="px-8 py-3 bg-blue-500 text-white font-bold rounded-lg hover:bg-blue-700 transition">
                                Jelajahi Koleksi
                            </a>
                        @endguest
                    </div>
                </div>
                <div class="hidden md:flex justify-center">
                    <div class="relative">
                        <div class="absolute inset-0 bg-white rounded-3xl opacity-10 blur-3xl"></div>
                        <i class="fas fa-books text-9xl text-white opacity-80 relative"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Books Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Koleksi Terbaru Kami</h2>
                <p class="text-xl text-gray-600">Pilihan buku terbaik dari berbagai kategori menarik</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                @forelse(\App\Models\Book::latest()->take(8)->get() as $book)
                    <div class="book-card-hover bg-white rounded-xl overflow-hidden border border-gray-200">
                        <!-- Book Cover Placeholder -->
                        <div class="h-48 bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center relative overflow-hidden">
                            <i class="fas fa-book text-6xl text-white opacity-50"></i>
                            @if($book->available_quantity > 0)
                                <span class="absolute top-3 right-3 bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                    Tersedia
                                </span>
                            @else
                                <span class="absolute top-3 right-3 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                    Habis
                                </span>
                            @endif
                        </div>

                        <!-- Book Info -->
                        <div class="p-4">
                            <h3 class="text-lg font-bold text-gray-900 truncate mb-1">{{ $book->title }}</h3>
                            <p class="text-sm text-gray-600 mb-2">{{ $book->author }}</p>
                            <p class="text-xs text-gray-500 mb-3">{{ $book->category->name ?? 'Kategori' }}</p>

                            <div class="flex items-center justify-between pt-3 border-t">
                                <span class="text-xs text-gray-500">{{ $book->year ?? 'N/A' }}</span>
                                @auth
                                    @if($book->available_quantity > 0)
                                        <a href="{{ route('loans.create', $book) }}" class="text-xs bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition">
                                            Pinjam
                                        </a>
                                    @else
                                        <button disabled class="text-xs bg-gray-300 text-gray-600 px-3 py-1 rounded cursor-not-allowed">
                                            Habis
                                        </button>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="text-xs bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition">
                                        Pinjam
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-4 text-center py-12">
                        <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500 text-lg">Belum ada buku. Silakan menambahkan koleksi terlebih dahulu.</p>
                    </div>
                @endforelse
            </div>

            <!-- View All Button -->
            <div class="text-center">
                <a href="{{ route('books.index') }}" class="inline-block px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold rounded-lg hover:shadow-lg transition transform hover:scale-105">
                    Lihat Semua Koleksi <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-book-open text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Ribuan Judul Buku</h3>
                    <p class="text-gray-600">Koleksi buku lengkap dari berbagai kategori dan penerbit terkemuka</p>
                </div>
                <div class="text-center">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-mobile-alt text-2xl text-purple-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Akses Mudah</h3>
                    <p class="text-gray-600">Kelola peminjaman buku kapan saja dan di mana saja melalui platform kami</p>
                </div>
                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Dukungan 24/7</h3>
                    <p class="text-gray-600">Tim profesional kami siap membantu Anda kapan pun Anda membutuhkan</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    @guest
        <section class="py-16 bg-gradient-to-r from-blue-600 to-purple-600 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-4xl font-bold mb-4">Siap Memulai?</h2>
                <p class="text-xl text-blue-100 mb-8">Bergabunglah dengan ribuan pembaca dan mulai petualangan literasi Anda hari ini</p>
                <div class="flex gap-4 justify-center">
                    <a href="{{ route('register') }}" class="px-8 py-3 bg-white text-blue-600 font-bold rounded-lg hover:shadow-lg transition transform hover:scale-105">
                        Daftar Gratis
                    </a>
                    <a href="{{ route('login') }}" class="px-8 py-3 bg-blue-500 text-white font-bold rounded-lg hover:bg-blue-700 transition">
                        Masuk Akun Anda
                    </a>
                </div>
            </div>
        </section>
    @endguest

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h4 class="text-white font-bold mb-4">Tentang Kami</h4>
                    <p class="text-sm">Platform manajemen perpustakaan digital terpercaya untuk semua kalangan.</p>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Layanan</h4>
                    <ul class="text-sm space-y-2">
                        <li><a href="{{ route('books.index') }}" class="hover:text-white transition">Koleksi Buku</a></li>
                        <li><a href="#" class="hover:text-white transition">Kategori</a></li>
                        <li><a href="#" class="hover:text-white transition">Rekomendasi</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Bantuan</h4>
                    <ul class="text-sm space-y-2">
                        <li><a href="#" class="hover:text-white transition">FAQ</a></li>
                        <li><a href="#" class="hover:text-white transition">Hubungi Kami</a></li>
                        <li><a href="#" class="hover:text-white transition">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Kontak</h4>
                    <p class="text-sm">Email: info@perpustakaan.com</p>
                    <p class="text-sm">Telepon: (021) 1234-5678</p>
                </div>
            </div>
            <hr class="border-gray-800 mb-8">
            <p class="text-center text-sm">&copy; 2024 Aplikasi Peminjaman Buku. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <script>
        // Auto-hide alerts
        const alerts = document.querySelectorAll('[id$="-alert"]');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.display = 'none';
            }, 5000);
        });
    </script>
</body>
</html>
