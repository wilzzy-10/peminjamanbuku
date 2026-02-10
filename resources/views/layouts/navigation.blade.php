<nav class="bg-white shadow-md sticky top-0 z-50 border-b-2 border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            
            
            <!-- Navigation Links -->
            @auth
                <div class="hidden md:flex items-center gap-8">
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('dashboard') }}" class="relative text-gray-700 hover:text-blue-600 font-medium transition-colors duration-300 group">
                            <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 group-hover:w-full transition-all duration-300"></span>
                        </a>
                        <a href="{{ route('users.index') }}" class="relative text-gray-700 hover:text-blue-600 font-medium transition-colors duration-300 group">
                            <i class="fas fa-users mr-2"></i> Pengguna
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 group-hover:w-full transition-all duration-300"></span>
                        </a>
                        <a href="{{ route('categories.index') }}" class="relative text-gray-700 hover:text-blue-600 font-medium transition-colors duration-300 group">
                            <i class="fas fa-tag mr-2"></i> Kategori
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 group-hover:w-full transition-all duration-300"></span>
                        </a>
                    @elseif(auth()->user()->role === 'petugas')
                        <a href="{{ route('dashboard') }}" class="relative text-gray-700 hover:text-blue-600 font-medium transition-colors duration-300 group">
                            <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 group-hover:w-full transition-all duration-300"></span>
                        </a>
                        <a href="{{ route('loans.index') }}" class="relative text-gray-700 hover:text-blue-600 font-medium transition-colors duration-300 group">
                            <i class="fas fa-list mr-2"></i> Peminjaman
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 group-hover:w-full transition-all duration-300"></span>
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="relative text-gray-700 hover:text-blue-600 font-medium transition-colors duration-300 group">
                            <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 group-hover:w-full transition-all duration-300"></span>
                        </a>
                        <a href="{{ route('loans.my-loans') }}" class="relative text-gray-700 hover:text-blue-600 font-medium transition-colors duration-300 group">
                            <i class="fas fa-bookmark mr-2"></i> Peminjaman Saya
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 group-hover:w-full transition-all duration-300"></span>
                        </a>
                    @endif
                </div>
            @endauth
            
            <!-- User Menu / Auth Links -->
            <div class="flex items-center gap-6">
                @auth
                    <div class="relative group/dropdown">
                        <button class="flex items-center gap-3 text-gray-700 hover:text-purple-600 font-medium transition-colors duration-300 px-4 py-2.5 rounded-lg hover:bg-purple-50">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-purple-700 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <span class="hidden md:inline text-gray-800">{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                        </button>
                        <div class="hidden group-hover/dropdown:block absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-2xl z-50 overflow-hidden border border-gray-100">
                            <div class="px-5 py-4 bg-gradient-to-r from-purple-50 to-pink-50 border-b border-gray-100">
                                <p class="text-sm font-bold text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 mt-1.5">{{ auth()->user()->email }}</p>
                                <span class="inline-block mt-2 px-3 py-1 bg-purple-600 text-white text-xs font-bold rounded-full">{{ strtoupper(auth()->user()->role) }}</span>
                            </div>
                            <a href="{{ route('profile.show') }}" class="flex items-center gap-3 px-5 py-3 text-gray-700 hover:bg-purple-50 transition-colors duration-150 border-b border-gray-100">
                                <i class="fas fa-user text-purple-600 w-5"></i>
                                <span class="font-medium">Lihat Profil</span>
                            </a>
                            <a href="{{ route('profile.show') }}" class="flex items-center gap-3 px-5 py-3 text-gray-700 hover:bg-purple-50 transition-colors duration-150 border-b border-gray-100">
                                <i class="fas fa-edit text-purple-600 w-5"></i>
                                <span class="font-medium">Edit Profil</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-5 py-3 text-gray-700 hover:bg-red-50 transition-colors duration-150">
                                    <i class="fas fa-sign-out-alt text-red-600 w-5"></i>
                                    <span class="font-medium">Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="bg-gradient-to-r from-purple-600 to-purple-700 text-white px-6 py-2.5 rounded-lg hover:shadow-lg transition-all duration-300 font-medium flex items-center gap-2">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
