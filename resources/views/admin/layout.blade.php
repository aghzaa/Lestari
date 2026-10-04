<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Fasilitator') - LESTARI Jovian</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo-transparant.png') }}">

    <!-- Google Fonts: Playfair Display & Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        lestari: {
                            red: '#8B0000',
                            redBright: '#D32F2F',
                            gold: '#D4AF37',
                            goldDark: '#996515',
                            goldLight: '#F7F0D4',
                            dark: '#18181B'
                        }
                    },
                    fontFamily: {
                        serif: ['Playfair Display', 'serif'],
                        sans: ['Poppins', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #F8FAFC;
            color: #0F172A;
        }

        .sidebar-link {
            transition: all 0.2s ease-in-out;
        }

        .sidebar-link.active {
            background-color: #8B0000;
            color: #FFFFFF;
            box-shadow: 0 4px 12px rgba(139, 0, 0, 0.25);
        }

        .sidebar-link:not(.active):hover {
            background-color: #F1F5F9;
            color: #8B0000;
        }

        /* Focus rings for keyboard navigation */
        a:focus-visible, button:focus-visible, input:focus-visible, select:focus-visible, textarea:focus-visible {
            outline: 2px solid #D4AF37;
            outline-offset: 2px;
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen flex flex-col md:flex-row antialiased">

    <!-- Mobile Top Header Bar -->
    <div class="md:hidden bg-white border-b border-gray-200 px-4 py-3 flex items-center justify-between sticky top-0 z-40">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-full bg-red-800 flex items-center justify-center text-amber-300 font-serif font-bold text-sm">
                L
            </div>
            <span class="font-serif font-bold text-gray-900 tracking-wide text-base">LESTARI Admin</span>
        </div>
        <button onclick="toggleMobileSidebar()" class="min-h-[44px] min-w-[44px] flex items-center justify-center text-gray-700 hover:text-red-800" aria-label="Menu Navigasi">
            <i class="fa-solid fa-bars text-xl"></i>
        </button>
    </div>

    <!-- Sidebar Navigation -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 flex flex-col justify-between transform -translate-x-full md:translate-x-0 md:static transition-transform duration-300 ease-in-out">
        <div>
            <!-- Brand Header -->
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-200/70 p-1 flex items-center justify-center shadow-sm">
                        <img src="{{ asset('img/logo-transparant.png') }}" alt="Logo LESTARI Jovian" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h1 class="font-serif font-bold text-lg text-gray-900 leading-tight">LESTARI</h1>
                        <p class="text-[11px] font-medium text-amber-800 tracking-wider uppercase">Jovian Health Care</p>
                    </div>
                </div>
                <button onclick="toggleMobileSidebar()" class="md:hidden text-gray-400 hover:text-gray-600 p-2" aria-label="Tutup Sidebar">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="p-4 space-y-1.5" aria-label="Navigasi Utama">
                <a href="{{ route('admin.dashboard') }}" 
                   class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-gray-700 min-h-[44px]">
                    <i class="fa-solid fa-chart-pie w-5 text-center"></i>
                    <span>Dashboard & Metrik</span>
                </a>

                <a href="{{ route('admin.stories') }}" 
                   class="sidebar-link {{ request()->routeIs('admin.stories*') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-gray-700 min-h-[44px]">
                    <i class="fa-solid fa-comment-dots w-5 text-center"></i>
                    <span>Curahan Hati Peserta</span>
                </a>

                <a href="{{ route('admin.motivations') }}" 
                   class="sidebar-link {{ request()->routeIs('admin.motivations*') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-gray-700 min-h-[44px]">
                    <i class="fa-solid fa-quote-left w-5 text-center"></i>
                    <span>Bank Pesan Motivasi</span>
                </a>

                <div class="pt-4 mt-4 border-t border-gray-100">
                    <span class="px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 block mb-2">Tautan Eksternal</span>
                    <a href="{{ route('home') }}" target="_blank" 
                       class="flex items-center justify-between px-4 py-2.5 rounded-xl text-xs font-semibold text-gray-600 hover:bg-gray-50 hover:text-red-800 transition min-h-[44px]">
                        <span class="flex items-center gap-2">
                            <i class="fa-solid fa-arrow-up-right-from-square text-amber-600"></i>
                            <span>Buka Ruang Publik</span>
                        </span>
                        <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
                    </a>
                </div>
            </nav>
        </div>

        <!-- User Profile & Logout -->
        <div class="p-4 border-t border-gray-100 bg-gray-50/50">
            <div class="flex items-center gap-3 mb-3 px-2">
                <div class="w-9 h-9 rounded-full bg-amber-100 text-amber-900 border border-amber-300 flex items-center justify-center font-bold text-sm">
                    {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-xs font-bold text-gray-900 truncate">{{ Auth::user()->name ?? 'Fasilitator' }}</p>
                    <p class="text-[11px] text-gray-500 truncate">{{ Auth::user()->email ?? 'admin@lestari.com' }}</p>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl border border-gray-300 text-xs font-semibold text-gray-700 hover:bg-red-50 hover:border-red-300 hover:text-red-700 transition min-h-[44px]">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Keluar dari Akun</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Overlay Backdrop for Mobile Sidebar -->
    <div id="sidebarBackdrop" onclick="toggleMobileSidebar()" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40 hidden md:hidden"></div>

    <!-- Main Content Shell -->
    <div class="flex-1 flex flex-col min-w-0">
        
        <!-- Flash Alert Messages -->
        @if(session('success'))
            <div class="m-4 md:m-6 mb-0 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs sm:text-sm font-medium flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900 p-1">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if(session('info'))
            <div class="m-4 md:m-6 mb-0 p-4 rounded-2xl bg-blue-50 border border-blue-200 text-blue-900 text-xs sm:text-sm font-medium flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-info text-blue-600 text-base"></i>
                    <span>{{ session('info') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-blue-700 hover:text-blue-900 p-1">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if(session('error') || $errors->any())
            <div class="m-4 md:m-6 mb-0 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-900 text-xs sm:text-sm font-medium flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-triangle-exclamation text-red-600 text-base"></i>
                    <span>{{ session('error') ?? $errors->first() }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-900 p-1">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        <!-- Main Page View Content -->
        <main class="flex-1 p-4 md:p-8">
            @yield('content')
        </main>

        <!-- Admin Footer -->
        <footer class="p-4 md:p-6 border-t border-gray-200 bg-white text-center text-xs text-gray-500 font-medium">
            <p>&copy; 2026 LESTARI - Sistem Manajemen Sosialisasi Kesehatan Mental Jovian Health Care</p>
        </footer>
    </div>

    <script>
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }
    </script>
    @stack('scripts')
</body>
</html>
