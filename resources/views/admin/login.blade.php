<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Fasilitator - LESTARI Jovian</title>

    <!-- Google Fonts: Playfair Display & Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,400&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
                            goldLight: '#F7F0D4'
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
            background-color: #FAFAFA;
            color: #1A1A1A;
            min-height: 100vh;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(212, 175, 55, 0.35);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.08), 0 0 20px rgba(212, 175, 55, 0.12);
        }

        .text-gold-gradient {
            background: linear-gradient(135deg, #8B0000 0%, #D32F2F 35%, #996515 75%, #D4AF37 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .input-custom {
            border: 2px solid #333333;
            transition: all 0.25s ease-in-out;
        }

        .input-custom:focus {
            border-color: #D32F2F;
            box-shadow: 0 0 0 3px rgba(211, 47, 47, 0.18);
            outline: none;
        }

        a:focus-visible, button:focus-visible, input:focus-visible {
            outline: 2px solid #D4AF37;
            outline-offset: 2px;
        }
    </style>
</head>
<body class="flex flex-col justify-between items-center p-4 min-h-screen relative selection:bg-amber-100 selection:text-red-900">

    <!-- Decorative Top & Bottom Background Graphics -->
    <div class="fixed top-0 right-0 w-72 h-72 opacity-20 pointer-events-none -z-10 translate-x-1/4 -translate-y-1/4" aria-hidden="true">
        <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
            <path fill="#8B0000" d="M44.7,-76.4C58.8,-69.2,71.8,-59.1,79.6,-45.8C87.4,-32.5,90,-16.3,88.5,-0.9C87,14.6,81.4,29.1,72.8,41.4C64.2,53.7,52.6,63.7,39.5,70.5C26.4,77.3,11.8,80.8,-2.2,84.7C-16.2,88.5,-32.4,92.8,-45.6,86.6C-58.8,80.3,-69,63.5,-76.5,47C-84,30.5,-88.8,15.3,-87.8,0.6C-86.8,-14.1,-80,-28.2,-71.4,-40.4C-62.8,-52.6,-52.4,-62.9,-40,-71C-27.6,-79.1,-13.8,-85,0.7,-86.2C15.2,-87.4,30.5,-83.6,44.7,-76.4Z" transform="translate(100 100)" />
        </svg>
    </div>

    <!-- Top Navbar Bar -->
    <header class="w-full max-w-md pt-4 flex justify-between items-center">
        <a href="{{ route('home') }}" class="text-xs font-semibold text-gray-600 hover:text-red-800 transition flex items-center gap-1.5 min-h-[44px]">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Ruang Publik</span>
        </a>
        <span class="text-xs font-bold uppercase tracking-wider text-amber-800">Panel Fasilitator</span>
    </header>

    <!-- Login Box Container -->
    <main class="w-full max-w-md my-auto py-8">
        <div class="glass-card rounded-3xl p-6 sm:p-8">
            
            <!-- Logo & Brand Header -->
            <div class="flex flex-col items-center mb-6 text-center">
                <div class="w-20 h-20 mb-3 p-2.5 rounded-full bg-white border border-amber-300 shadow-md flex items-center justify-center">
                    <svg width="100%" height="100%" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="60" cy="60" r="56" stroke="url(#goldGrad)" stroke-width="3" fill="none"/>
                        <circle cx="60" cy="60" r="48" fill="#8B0000"/>
                        <path d="M60 28C60 28 38 42 38 64C38 76.15 47.85 86 60 86C72.15 86 82 76.15 82 64C82 42 60 28 60 28Z" fill="url(#goldGrad)" opacity="0.9"/>
                        <path d="M60 38C60 38 46 50 46 65C46 72.7 52.3 79 60 79C67.7 79 74 72.7 74 65C74 50 60 38 60 38Z" fill="#8B0000"/>
                        <path d="M60 48V72M50 60H70" stroke="#D4AF37" stroke-width="2.5" stroke-linecap="round"/>
                        <defs>
                            <linearGradient id="goldGrad" x1="0" y1="0" x2="120" y2="120" gradientUnits="userSpaceOnUse">
                                <stop offset="0%" stop-color="#F7F0D4"/>
                                <stop offset="50%" stop-color="#D4AF37"/>
                                <stop offset="100%" stop-color="#996515"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                
                <h1 class="font-serif text-3xl font-extrabold text-gold-gradient mb-1">
                    LESTARI
                </h1>
                <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Masuk Dashboard Fasilitator
                </p>
            </div>

            <!-- Error Notification -->
            @if($errors->any())
                <div class="mb-5 p-3.5 rounded-2xl bg-red-50 border border-red-200 text-red-900 text-xs font-medium flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation text-red-600 text-base"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            @if(session('info'))
                <div class="mb-5 p-3.5 rounded-2xl bg-blue-50 border border-blue-200 text-blue-900 text-xs font-medium flex items-center gap-2">
                    <i class="fa-solid fa-circle-info text-blue-600 text-base"></i>
                    <span>{{ session('info') }}</span>
                </div>
            @endif

            <!-- Form Login -->
            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Input Email -->
                <div>
                    <label for="email" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <input type="email" id="email" name="email" value="{{ old('email', 'admin@lestari.com') }}" required autofocus
                               class="input-custom w-full pl-10 pr-4 py-3 rounded-2xl text-sm text-gray-900 bg-white placeholder-gray-400"
                               placeholder="nama@email.com">
                    </div>
                </div>

                <!-- Input Password -->
                <div>
                    <div class="flex justify-between items-center mb-1.5">
                        <label for="password" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Kata Sandi
                        </label>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <input type="password" id="password" name="password" required
                               class="input-custom w-full pl-10 pr-11 py-3 rounded-2xl text-sm text-gray-900 bg-white placeholder-gray-400"
                               placeholder="Masukkan kata sandi">
                        <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-700" aria-label="Lihat kata sandi">
                            <i id="passwordToggleIcon" class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me Checkbox -->
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded text-red-800 border-gray-300 focus:ring-amber-500">
                        <span class="text-xs text-gray-600 font-medium">Ingat Sesi Saya</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full min-h-[48px] py-3.5 px-6 rounded-full bg-gradient-to-r from-red-800 to-red-600 text-white font-semibold text-sm shadow-lg hover:shadow-red-900/30 hover:scale-[1.01] active:scale-[0.98] transition duration-300 flex items-center justify-center gap-2 mt-4">
                    <span>Masuk ke Dashboard</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>

            <!-- Default Credential Helper Note -->
            <div class="mt-6 pt-4 border-t border-gray-200 text-center">
                <p class="text-[11px] text-gray-500">
                    Akun bawaan seeder: <strong class="text-gray-700">admin@lestari.com</strong> / sandi: <strong class="text-gray-700">password</strong>
                </p>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full max-w-md text-center py-4 text-xs text-gray-500 font-medium">
        <p>&copy; 2026 LESTARI - Jovian Health Care</p>
    </footer>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('passwordToggleIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.className = 'fa-solid fa-eye-slash';
            } else {
                passwordInput.type = 'password';
                icon.className = 'fa-solid fa-eye';
            }
        }
    </script>
</body>
</html>
