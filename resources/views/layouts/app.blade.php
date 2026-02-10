<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Peminjaman Buku')</title>
    
    <!-- Tailwind CSS -->
    @vite('resources/css/app.css')
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Global Navbar Styles -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Navbar Styles */
        .global-navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 8px 32px rgba(102, 126, 234, 0.25);
            position: sticky;
            top: 0;
            z-index: 50;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .navbar-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 75px;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 15px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .navbar-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 26px;
            transition: all 0.3s ease;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .navbar-brand:hover .navbar-icon {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-3px);
            border-color: rgba(255, 255, 255, 0.5);
        }

        .navbar-title {
            font-size: 26px;
            font-weight: 800;
            color: white;
            transition: all 0.3s ease;
            letter-spacing: -0.5px;
        }

        .navbar-brand:hover .navbar-title {
            transform: scale(1.05);
        }

        /* Navigation Links */
        .navbar-links {
            display: flex;
            align-items: center;
            gap: 5px;
            margin: 0 30px;
        }

        .navbar-link {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .navbar-link:hover {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            transform: translateY(-2px);
        }

        .navbar-link.active {
            background: rgba(255, 255, 255, 0.25);
            color: white;
            border-bottom: 2px solid white;
        }

        .navbar-link i {
            font-size: 0.95rem;
        }

        /* User Section */
        .navbar-user {
            position: relative;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .user-button {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 18px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.2);
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            color: white;
            font-size: 0.95rem;
        }

        .user-button:hover {
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.4);
            transform: translateY(-2px);
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            background: rgba(255, 255, 255, 0.3);
            border: 2px solid rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .user-button:hover .user-avatar {
            background: rgba(255, 255, 255, 0.4);
            border-color: white;
            transform: scale(1.05);
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            margin-top: 10px;
            width: 320px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 50px rgba(102, 126, 234, 0.3);
            border: 1px solid rgba(102, 126, 234, 0.1);
            overflow: hidden;
            z-index: 100;
            animation: slideDown 0.3s ease-out;
        }

        .navbar-user:hover .dropdown-menu {
            display: block;
        }

        .dropdown-header {
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-bottom: none;
            color: white;
        }

        .dropdown-header .user-name {
            font-weight: bold;
            color: white;
            font-size: 15px;
        }

        .dropdown-header .user-email {
            color: rgba(255, 255, 255, 0.8);
            font-size: 13px;
            margin-top: 5px;
        }

        .dropdown-header .user-role {
            display: inline-block;
            margin-top: 10px;
            padding: 6px 14px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .dropdown-divider {
            height: 8px;
            background: #f7fafc;
            border: none;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 20px;
            border: none;
            text-decoration: none;
            color: #4a5568;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .dropdown-item:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            color: #667eea;
            padding-left: 26px;
        }

        .dropdown-item i {
            width: 20px;
            text-align: center;
            color: #667eea;
            font-size: 1rem;
        }

        .dropdown-item:hover i {
            transform: scale(1.1);
        }

        .dropdown-logout {
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
            margin-top: 10px;
            color: #e53e3e;
        }

        .dropdown-logout:hover {
            background: linear-gradient(135deg, rgba(245, 101, 101, 0.05) 0%, rgba(229, 62, 62, 0.05) 100%);
        }

        .dropdown-logout:hover i {
            color: #e53e3e;
        }

        .dropdown-logout button {
            width: 100%;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            text-align: left;
            font-weight: 600;
            color: inherit;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .navbar-container {
                padding: 0 15px;
                height: 70px;
            }

            .navbar-title {
                font-size: 20px;
            }

            .navbar-links {
                margin: 0 15px;
                gap: 3px;
            }

            .navbar-link span {
                display: none;
            }

            .navbar-link {
                padding: 10px 12px;
            }
        }
    </style>
    
    <!-- Additional Styles -->
    @stack('styles')
</head>
<body class="bg-gray-50">
    @auth
        <!-- Global Navigation Bar -->
        <nav class="global-navbar">
            <div class="navbar-container">
                <a href="{{ route('dashboard') }}" class="navbar-brand">
                    <div class="navbar-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <span class="navbar-title">Perpustakaan</span>
                </a>

                <!-- Navigation Links -->
                <div class="navbar-links">
                    <a href="{{ route('books.index') }}" class="navbar-link">
                        <i class="fas fa-book-open"></i>
                        <span>Koleksi</span>
                    </a>
                    <a href="{{ route('loans.my-loans') }}" class="navbar-link">
                        <i class="fas fa-bookmark"></i>
                        <span>Peminjaman</span>
                    </a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('dashboard') }}" class="navbar-link">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Admin</span>
                        </a>
                    @endif
                    @if(auth()->user()->isPetugas())
                        <a href="{{ route('loans.index') }}" class="navbar-link">
                            <i class="fas fa-tasks"></i>
                            <span>Verifikasi</span>
                        </a>
                    @endif
                </div>

                <div class="navbar-user">
                    <button class="user-button">
                        <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                        <span>{{ Str::limit(auth()->user()->name, 12) }}</span>
                        <i class="fas fa-chevron-down" style="font-size: 11px;"></i>
                    </button>

                    <div class="dropdown-menu">
                        <div class="dropdown-header">
                            <div class="user-name">{{ auth()->user()->name }}</div>
                            <div class="user-email">{{ auth()->user()->email }}</div>
                            <span class="user-role">
                                @if(auth()->user()->isAdmin())
                                    Admin
                                @elseif(auth()->user()->isPetugas())
                                    Petugas
                                @else
                                    Pengguna
                                @endif
                            </span>
                        </div>
                        
                        <div class="dropdown-divider"></div>
                        
                        <a href="{{ route('profile.show') }}" class="dropdown-item">
                            <i class="fas fa-user-circle"></i>
                            <span>Lihat Profil</span>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            <i class="fas fa-edit"></i>
                            <span>Edit Profil</span>
                        </a>
                        
                        <div class="dropdown-divider"></div>
                        
                        <div class="dropdown-item dropdown-logout">
                            <form method="POST" action="{{ route('logout') }}" style="display: flex; align-items: center; gap: 12px; width: 100%;">
                                @csrf
                                <i class="fas fa-sign-out-alt"></i>
                                <button type="submit">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    @endauth

    <div class="min-h-screen flex flex-col">
        <!-- Main Content -->
        <main class="flex-1">
            @yield('content')
        </main>
        
        <!-- Footer -->
        @include('layouts.footer')
    </div>
    
    <!-- Scripts -->
    @vite('resources/js/app.js')
    @stack('scripts')
</body>
</html>
