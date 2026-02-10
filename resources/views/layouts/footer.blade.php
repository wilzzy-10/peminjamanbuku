<footer class="bg-gradient-to-b from-gray-900 to-black text-white mt-20 border-t border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Main Footer Content -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
            <!-- Brand Section -->
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-lg">
                        <i class="fas fa-book-open text-white text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold">LibraryApp</h3>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Sistem manajemen peminjaman buku yang modern, aman, dan mudah digunakan untuk perpustakaan di era digital.
                </p>
            </div>
            
            <!-- Quick Links -->
            <div>
                <h4 class="text-lg font-bold mb-6 text-white flex items-center gap-2">
                    <i class="fas fa-link text-blue-400"></i> Tautan Cepat
                </h4>
                <ul class="space-y-3 text-sm text-gray-400">
                    @auth
                        <li>
                            <a href="{{ route('dashboard') }}" class="hover:text-blue-400 transition-colors duration-300">
                                <i class="fas fa-arrow-right mr-2 text-gray-600"></i>Dashboard
                            </a>
                        </li>
                        @if(auth()->user()->role === 'member' || auth()->user()->role === null)
                            <li>
                                <a href="{{ route('loans.my-loans') }}" class="hover:text-blue-400 transition-colors duration-300">
                                    <i class="fas fa-arrow-right mr-2 text-gray-600"></i>Peminjaman Saya
                                </a>
                            </li>
                        @endif
                    @else
                        <li>
                            <a href="{{ route('login') }}" class="hover:text-blue-400 transition-colors duration-300">
                                <i class="fas fa-arrow-right mr-2 text-gray-600"></i>Login
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}" class="hover:text-blue-400 transition-colors duration-300">
                                <i class="fas fa-arrow-right mr-2 text-gray-600"></i>Daftar
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>

            <!-- Features -->
            <div>
                <h4 class="text-lg font-bold mb-6 text-white flex items-center gap-2">
                    <i class="fas fa-star text-blue-400"></i> Fitur Utama
                </h4>
                <ul class="space-y-3 text-sm text-gray-400">
                    <li class="hover:text-blue-400 transition-colors duration-300 cursor-default">
                        <i class="fas fa-check mr-2 text-green-400"></i>Kelola Koleksi Buku
                    </li>
                    <li class="hover:text-blue-400 transition-colors duration-300 cursor-default">
                        <i class="fas fa-check mr-2 text-green-400"></i>Sistem Peminjaman
                    </li>
                    <li class="hover:text-blue-400 transition-colors duration-300 cursor-default">
                        <i class="fas fa-check mr-2 text-green-400"></i>Riwayat Lengkap
                    </li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h4 class="text-lg font-bold mb-6 text-white flex items-center gap-2">
                    <i class="fas fa-headset text-blue-400"></i> Hubungi Kami
                </h4>
                <ul class="space-y-3 text-sm text-gray-400">
                    <li class="flex items-center gap-3 hover:text-blue-400 transition-colors duration-300">
                        <i class="fas fa-envelope w-4 text-blue-400"></i>
                        <span>info@libraryapp.com</span>
                    </li>
                    <li class="flex items-center gap-3 hover:text-blue-400 transition-colors duration-300">
                        <i class="fas fa-phone w-4 text-blue-400"></i>
                        <span>(021) 1234-5678</span>
                    </li>
                    <li class="flex items-center gap-3 hover:text-blue-400 transition-colors duration-300">
                        <i class="fas fa-map-marker-alt w-4 text-blue-400"></i>
                        <span>Jakarta, Indonesia</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Social Media & Copyright -->
        <div class="border-t border-gray-800 pt-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <!-- Social Media -->
                <div class="flex items-center gap-4">
                    <span class="text-gray-400 text-sm">Ikuti Kami:</span>
                    <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-blue-600 rounded-full flex items-center justify-center transition-all duration-300 transform hover:scale-110">
                        <i class="fab fa-facebook-f text-white"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-blue-600 rounded-full flex items-center justify-center transition-all duration-300 transform hover:scale-110">
                        <i class="fab fa-twitter text-white"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-blue-600 rounded-full flex items-center justify-center transition-all duration-300 transform hover:scale-110">
                        <i class="fab fa-instagram text-white"></i>
                    </a>
                </div>

                <!-- Copyright -->
                <div class="text-center text-gray-400 text-sm">
                    <p>&copy; <span id="year">{{ date('Y') }}</span> LibraryApp. Semua hak dilindungi.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll to Top Button -->
    <div class="fixed bottom-8 right-8 z-40">
        <button onclick="window.scrollTo({ top: 0, behavior: 'smooth' })" class="hidden md:flex w-12 h-12 bg-gradient-to-br from-blue-600 to-indigo-600 text-white rounded-full items-center justify-center hover:shadow-lg transition-all duration-300 transform hover:scale-110 scroll-to-top-btn">
            <i class="fas fa-arrow-up"></i>
        </button>
    </div>

    <script>
        // Show/hide scroll to top button
        window.addEventListener('scroll', function() {
            const btn = document.querySelector('.scroll-to-top-btn');
            if (window.pageYOffset > 300) {
                btn.classList.remove('hidden');
            } else {
                btn.classList.add('hidden');
            }
        });
    </script>
</footer>
