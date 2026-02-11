<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Aplikasi Peminjaman Buku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .login-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .input-focus:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
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
                <!-- Auth Buttons (Right Top) -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('login') }}" class="px-4 py-2 text-blue-600 font-semibold hover:text-blue-700 transition border-b-2 border-blue-600">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg font-semibold hover:shadow-lg transition transform hover:scale-105">
                        Daftar
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Login Section -->
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            <!-- Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Header -->
                <div class="login-gradient px-8 py-12 text-white">
                    <div class="text-center">
                        <div class="text-5xl mb-4">
                            <i class="fas fa-book"></i>
                        </div>
                        <h1 class="text-3xl font-bold mb-2">Selamat Datang</h1>
                        <p class="text-blue-100">Masuk ke akun Anda dan jelajahi ribuan buku</p>
                    </div>
                </div>

                <!-- Content -->
                <div class="px-8 py-8">
                    @if($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                            <div class="flex">
                                <i class="fas fa-exclamation-circle mt-1 mr-3"></i>
                                <div>
                                    <p class="font-semibold mb-2">Login Gagal</p>
                                    @foreach($errors->all() as $error)
                                        <p class="text-sm">{{ $error }}</p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($message = Session::get('success'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
                            <i class="fas fa-check-circle mr-2"></i> {{ $message }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                        @csrf

                        <!-- Email Input -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-envelope text-blue-600 mr-2"></i>Email
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg input-focus transition bg-gray-50"
                                placeholder="nama@email.com"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                            >
                        </div>

                        <!-- Password Input -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-lock text-blue-600 mr-2"></i>Password
                            </label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg input-focus transition bg-gray-50"
                                placeholder="••••••••"
                                required
                                autocomplete="current-password"
                            >
                        </div>

                        <!-- Login Button -->
                        <button 
                            type="submit" 
                            class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-2.5 rounded-lg font-bold hover:shadow-lg transition transform hover:scale-105 duration-200 mt-6"
                        >
                            <i class="fas fa-sign-in-alt mr-2"></i> Login
                        </button>
                    </form>

                    <!-- Register Link -->
                    <div class="mt-6 text-center pt-6 border-t border-gray-200">
                        <p class="text-gray-600">
                            Belum punya akun? 
                            <a href="{{ route('register') }}" class="text-blue-600 font-bold hover:text-blue-700 transition">
                                Daftar di sini
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Footer Text -->
            <div class="text-center mt-8 text-sm text-gray-600">
                <p>Dengan login, Anda menyetujui <a href="#" class="text-blue-600 hover:underline">Syarat & Ketentuan</a> kami</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-sm">
                <p>&copy; 2024 Aplikasi Peminjaman Buku. Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>

    <script>
        // Auto-hide alerts
        const alerts = document.querySelectorAll('[role="alert"]');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.display = 'none';
            }, 5000);
        });
    </script>
</body>
</html>


