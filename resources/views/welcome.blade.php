<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LESTARI - Ruang Cerita & Motivasi Jovian</title>
    
    <!-- Google Fonts: Playfair Display (Serif) & Poppins (Sans-serif) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700;0,800;1,400;1,600&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
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
                            goldLight: '#F7F0D4',
                            charcoal: '#1A1A1A',
                            cream: '#FCFBF7'
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
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #FAFAFA;
            color: #1A1A1A;
            overflow-x: hidden;
            min-height: 100vh;
        }

        /* Glassmorphism Card Styling */
        .glass-card {
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(212, 175, 55, 0.3);
            box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.08), 0 0 15px rgba(212, 175, 55, 0.12);
        }

        /* Gold Gradient Text */
        .text-gold-gradient {
            background: linear-gradient(135deg, #8B0000 0%, #D32F2F 35%, #996515 75%, #D4AF37 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .gold-border-glow {
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.25);
        }

        /* Input Custom Styling */
        .input-pill-custom {
            border: 2px solid #2B2B2B;
            transition: all 0.25s ease-in-out;
        }

        .input-pill-custom:focus-within {
            border-color: #D32F2F;
            box-shadow: 0 0 0 3px rgba(211, 47, 47, 0.18);
        }

        /* Custom Radio Buttons with accessible tap target */
        .gender-radio:checked + label {
            background-color: #8B0000;
            color: #FFFFFF;
            border-color: #8B0000;
            transform: scale(1.02);
            box-shadow: 0 4px 12px rgba(139, 0, 0, 0.25);
        }

        /* Option Pills Page 2 */
        .category-pill {
            transition: all 0.25s ease;
            border: 2px dashed #9CA3AF;
            background-color: #F3F4F6;
            min-height: 48px;
        }

        .category-pill:hover {
            border-color: #8B0000;
            background-color: #FEE2E2;
            color: #8B0000;
        }

        .category-pill.active {
            background: linear-gradient(135deg, #8B0000, #B91C1C);
            color: #FFFFFF;
            border: 2px solid #D4AF37;
            box-shadow: 0 6px 16px rgba(139, 0, 0, 0.3);
            transform: translateY(-2px);
        }

        /* Pulse Glowing Button OPEN */
        .open-btn-glow {
            position: relative;
            background: linear-gradient(135deg, #D32F2F, #8B0000);
            box-shadow: 0 8px 25px rgba(211, 47, 47, 0.4);
            animation: pulseGlow 2.5s infinite;
        }

        @keyframes pulseGlow {
            0% {
                box-shadow: 0 0 0 0 rgba(211, 47, 47, 0.6);
            }
            70% {
                box-shadow: 0 0 0 18px rgba(211, 47, 47, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(211, 47, 47, 0);
            }
        }

        .open-btn-glow:hover {
            transform: scale(1.06);
            background: linear-gradient(135deg, #B91C1C, #7F1D1D);
        }

        .open-btn-glow:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            animation: none;
            transform: none;
        }

        /* Smooth Page Transition */
        .page-step {
            display: none;
            opacity: 0;
            transform: translateY(15px);
            transition: opacity 0.4s ease, transform 0.4s ease;
        }

        .page-step.active {
            display: flex;
            opacity: 1;
            transform: translateY(0);
        }

        /* Background Particle Canvas */
        #bg-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -1;
            pointer-events: none;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #F1F1F1;
        }
        ::-webkit-scrollbar-thumb {
            background: #D4AF37;
            border-radius: 4px;
        }

        /* Visible Focus for Keyboard Accessibility (R-32) */
        a:focus-visible, button:focus-visible, input:focus-visible, select:focus-visible, textarea:focus-visible {
            outline: 3px solid #D4AF37;
            outline-offset: 2px;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen justify-between relative selection:bg-amber-100 selection:text-red-900">

    <!-- Background Canvas for Particles -->
    <canvas id="bg-canvas" aria-hidden="true"></canvas>

    <!-- Decorative Top & Bottom Background Graphics -->
    <div class="fixed top-0 right-0 w-72 h-72 opacity-20 pointer-events-none -z-10 translate-x-1/4 -translate-y-1/4" aria-hidden="true">
        <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
            <path fill="#8B0000" d="M44.7,-76.4C58.8,-69.2,71.8,-59.1,79.6,-45.8C87.4,-32.5,90,-16.3,88.5,-0.9C87,14.6,81.4,29.1,72.8,41.4C64.2,53.7,52.6,63.7,39.5,70.5C26.4,77.3,11.8,80.8,-2.2,84.7C-16.2,88.5,-32.4,92.8,-45.6,86.6C-58.8,80.3,-69,63.5,-76.5,47C-84,30.5,-88.8,15.3,-87.8,0.6C-86.8,-14.1,-80,-28.2,-71.4,-40.4C-62.8,-52.6,-52.4,-62.9,-40,-71C-27.6,-79.1,-13.8,-85,0.7,-86.2C15.2,-87.4,30.5,-83.6,44.7,-76.4Z" transform="translate(100 100)" />
        </svg>
    </div>

    <div class="fixed bottom-0 left-0 w-80 h-80 opacity-15 pointer-events-none -z-10 -translate-x-1/4 translate-y-1/4" aria-hidden="true">
        <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
            <path fill="#D4AF37" d="M38.1,-65.1C50.2,-58.2,61.4,-49,69.7,-37.2C78,-25.4,83.4,-11,83.3,3.3C83.2,17.7,77.5,32,68.6,43.7C59.7,55.4,47.6,64.5,34.3,69.8C21,75.1,6.5,76.6,-7.7,77.9C-21.9,79.2,-35.8,80.3,-47.9,74.7C-60,69.1,-70.3,56.8,-76.6,42.8C-82.9,28.8,-85.2,13.1,-83.8,-2C-82.4,-17.1,-77.3,-31.6,-68.8,-43.2C-60.3,-54.8,-48.4,-63.5,-35.7,-69.9C-23,-76.3,-9.5,-80.4,2.8,-84.7C15.1,-89,30.2,-93.5,38.1,-65.1Z" transform="translate(100 100)" />
        </svg>
    </div>

    <!-- Header & Controls Bar -->
    <header class="w-full max-w-4xl mx-auto pt-6 px-4 flex justify-between items-center z-20">
        <div class="flex items-center gap-2">
            <span class="inline-block w-2.5 h-2.5 rounded-full bg-amber-500 animate-ping" aria-hidden="true"></span>
            <span class="text-xs font-semibold tracking-widest uppercase text-gray-600">Jovian Health Care</span>
        </div>
        <div class="flex items-center gap-3">
            <button id="soundToggleBtn" onclick="toggleAudio()" class="p-2.5 px-4 rounded-full bg-white/90 border border-gray-300 text-xs font-medium text-gray-700 shadow-sm hover:border-amber-500 transition flex items-center gap-2" title="Relaksasi Suara Frekuensi 174 Hz">
                <i id="soundIcon" class="fa-solid fa-volume-xmark text-gray-500"></i>
                <span id="soundStatusText">Musik Off</span>
            </button>
            <button onclick="openHistoryModal()" class="p-2.5 px-4 rounded-full bg-white/90 border border-gray-300 text-xs font-medium text-gray-700 shadow-sm hover:border-amber-500 transition flex items-center gap-2">
                <i class="fa-solid fa-bookmark text-amber-600"></i>
                <span>Riwayat Cerita</span>
            </button>
        </div>
    </header>

    <!-- Main Container -->
    <main class="w-full max-w-xl mx-auto px-4 py-6 my-auto z-10 flex flex-col justify-center items-center">
        
        <!-- Logo Section -->
        <div class="flex flex-col items-center mb-6 text-center">
            <div class="w-24 h-24 mb-3 p-3 rounded-full bg-white glass-card gold-border-glow flex items-center justify-center transform hover:rotate-6 transition duration-500">
                <svg width="100%" height="100%" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Logo LESTARI">
                    <circle cx="60" cy="60" r="56" stroke="url(#goldGradient)" stroke-width="3" fill="none"/>
                    <circle cx="60" cy="60" r="48" fill="#8B0000"/>
                    <path d="M60 28C60 28 38 42 38 64C38 76.15 47.85 86 60 86C72.15 86 82 76.15 82 64C82 42 60 28 60 28Z" fill="url(#goldGradient)" opacity="0.9"/>
                    <path d="M60 38C60 38 46 50 46 65C46 72.7 52.3 79 60 79C67.7 79 74 72.7 74 65C74 50 60 38 60 38Z" fill="#8B0000"/>
                    <path d="M60 48V72M50 60H70" stroke="#D4AF37" stroke-width="2.5" stroke-linecap="round"/>
                    <defs>
                        <linearGradient id="goldGradient" x1="0" y1="0" x2="120" y2="120" gradientUnits="userSpaceOnUse">
                            <stop offset="0%" stop-color="#F7F0D4"/>
                            <stop offset="50%" stop-color="#D4AF37"/>
                            <stop offset="100%" stop-color="#996515"/>
                        </linearGradient>
                    </defs>
                </svg>
            </div>
            
            <h1 class="font-serif text-4xl sm:text-5xl font-extrabold tracking-tight text-gold-gradient mb-1">
                LESTARI
            </h1>
            <p class="font-sans text-xs sm:text-sm font-semibold tracking-wide text-amber-900 uppercase max-w-xs sm:max-w-md">
                Edukasi dan Aksi Nyata Hidup Sehat Bersama Jovian
            </p>
        </div>

        <!-- ================= PAGE 1: FORMULIR INFORMASI DIRI ================= -->
        <section id="page1" class="page-step active flex-col w-full glass-card rounded-3xl p-6 sm:p-8" aria-label="Formulir Informasi Diri">
            <div class="text-center mb-6">
                <h2 class="font-serif text-2xl font-bold text-gray-900 mb-1">Formulir Informasi Diri</h2>
                <p class="text-xs text-gray-600">Lengkapi data singkat berikut untuk memulai ruang cerita yang aman dan nyaman</p>
            </div>

            <form id="formLestari" onsubmit="handleFormSubmit(event)" class="w-full flex flex-col gap-5">
                
                <!-- Input Nama -->
                <div class="flex flex-col gap-1.5">
                    <label for="nama" class="font-serif text-base sm:text-lg font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fa-solid fa-user-pen text-red-700 text-sm"></i> Nama Lengkap / Panggilan
                    </label>
                    <div class="input-pill-custom rounded-full px-4 py-2.5 bg-white flex items-center">
                        <input type="text" id="nama" name="nama" placeholder="Tuliskan nama Anda..." required
                               class="w-full bg-transparent outline-none text-center font-medium text-gray-800 placeholder-gray-400 text-sm sm:text-base">
                    </div>
                </div>

                <!-- Input Umur -->
                <div class="flex flex-col gap-1.5">
                    <label for="umur" class="font-serif text-base sm:text-lg font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fa-solid fa-cake-candles text-red-700 text-sm"></i> Umur (Tahun)
                    </label>
                    <div class="input-pill-custom rounded-full px-4 py-2.5 bg-white flex items-center">
                        <input type="number" id="umur" name="umur" min="5" max="120" placeholder="Contoh: 17" required
                               class="w-full bg-transparent outline-none text-center font-medium text-gray-800 placeholder-gray-400 text-sm sm:text-base">
                    </div>
                </div>

                <!-- Input Jenis Kelamin -->
                <div class="flex flex-col gap-1.5">
                    <label class="font-serif text-base sm:text-lg font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fa-solid fa-venus-mars text-red-700 text-sm"></i> Jenis Kelamin
                    </label>
                    <div class="grid grid-cols-2 gap-3 w-full">
                        <div>
                            <input type="radio" id="pria" name="jenis_kelamin" value="Pria" class="gender-radio hidden" required>
                            <label for="pria" class="w-full block text-center py-3 px-4 rounded-full border-2 border-gray-300 font-semibold text-sm text-gray-700 cursor-pointer transition select-none hover:border-red-700">
                                <i class="fa-solid fa-mars mr-1 text-blue-700"></i> Pria
                            </label>
                        </div>
                        <div>
                            <input type="radio" id="wanita" name="jenis_kelamin" value="Wanita" class="gender-radio hidden" required>
                            <label for="wanita" class="w-full block text-center py-3 px-4 rounded-full border-2 border-gray-300 font-semibold text-sm text-gray-700 cursor-pointer transition select-none hover:border-red-700">
                                <i class="fa-solid fa-venus mr-1 text-pink-700"></i> Wanita
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Input Jenjang Pendidikan -->
                <div class="flex flex-col gap-1.5">
                    <label for="pendidikan" class="font-serif text-base sm:text-lg font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fa-solid fa-graduation-cap text-red-700 text-sm"></i> Jenjang Pendidikan
                    </label>
                    <div class="input-pill-custom rounded-full px-4 py-2.5 bg-white flex items-center relative">
                        <select id="pendidikan" name="pendidikan" required class="w-full bg-transparent outline-none text-center font-semibold text-gray-800 text-sm sm:text-base cursor-pointer appearance-none">
                            <option value="" disabled selected>Pilih Jenjang Pendidikan</option>
                            <option value="SD">SD / Sederajat</option>
                            <option value="SMP">SMP / Sederajat</option>
                            <option value="SMA">SMA / SMK / MA</option>
                            <option value="MAHASISWA">MAHASISWA</option>
                            <option value="UMUM">UMUM / LAINNYA</option>
                        </select>
                        <i class="fa-solid fa-chevron-down text-gray-500 absolute right-4 pointer-events-none text-xs"></i>
                    </div>
                </div>

                <!-- Submit / Next Button -->
                <button type="submit" class="mt-4 w-full min-h-[48px] py-3.5 px-6 rounded-full bg-gradient-to-r from-red-800 to-red-600 text-white font-semibold text-base shadow-lg hover:shadow-red-900/30 hover:scale-[1.01] active:scale-[0.98] transition duration-300 flex items-center justify-center gap-2 group">
                    <span>Lanjutkan ke Ruang Cerita</span>
                    <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition duration-300"></i>
                </button>
            </form>
        </section>

        <!-- ================= PAGE 2: RUANG CERITA ================= -->
        <section id="page2" class="page-step flex-col w-full glass-card rounded-3xl p-6 sm:p-8" aria-label="Ruang Cerita dan Motivasi">
            
            <!-- User Welcome Greeting -->
            <div class="text-center mb-6 border-b border-gray-200 pb-4">
                <span id="userBadge" class="inline-block px-3.5 py-1 bg-amber-100 text-amber-900 font-semibold text-xs rounded-full mb-2">
                    <i class="fa-solid fa-user-circle mr-1 text-amber-700"></i> Data Terverifikasi
                </span>
                <h2 id="welcomeGreeting" class="font-serif text-2xl sm:text-3xl font-bold text-gray-900">
                    Halo, Sahabat!
                </h2>
                <p class="text-xs sm:text-sm text-gray-600 mt-1">
                    Ingin bercerita atau meluapkan hal apa hari ini?
                </p>
            </div>

            <!-- Options Category Group -->
            <div class="mb-6">
                <label class="block font-serif text-base font-bold text-gray-800 text-center mb-3">
                    Pilih Fokus Cerita:
                </label>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                    <button type="button" class="category-pill active py-2.5 px-3 rounded-2xl text-xs sm:text-sm font-semibold flex flex-col items-center justify-center gap-1" onclick="selectCategory(this, 'Diri Sendiri')">
                        <i class="fa-solid fa-user text-base"></i>
                        <span>Diri Sendiri</span>
                    </button>
                    <button type="button" class="category-pill py-2.5 px-3 rounded-2xl text-xs sm:text-sm font-semibold flex flex-col items-center justify-center gap-1" onclick="selectCategory(this, 'Keluarga')">
                        <i class="fa-solid fa-house-chimney-window text-base"></i>
                        <span>Keluarga</span>
                    </button>
                    <button type="button" class="category-pill py-2.5 px-3 rounded-2xl text-xs sm:text-sm font-semibold flex flex-col items-center justify-center gap-1" onclick="selectCategory(this, 'Teman')">
                        <i class="fa-solid fa-user-group text-base"></i>
                        <span>Teman</span>
                    </button>
                    <button type="button" class="category-pill py-2.5 px-3 rounded-2xl text-xs sm:text-sm font-semibold flex flex-col items-center justify-center gap-1" onclick="selectCategory(this, 'Kekasih')">
                        <i class="fa-solid fa-heart text-base"></i>
                        <span>Kekasih</span>
                    </button>
                </div>
            </div>

            <!-- Textarea Expression Box -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-2">
                    <label for="storyText" class="font-serif text-sm sm:text-base font-bold text-gray-800">
                        Ungkapan Keluhan / Curahan Hati:
                    </label>
                    <span id="charCounter" class="text-xs text-gray-500 font-medium">0 / 500</span>
                </div>
                <div class="relative">
                    <textarea id="storyText" rows="5" maxlength="500" oninput="updateCharCount()"
                              placeholder="Tuliskan keluhan atau beban pikiran yang ingin kamu tuangkan di sini... LESTARI siap mendengarkan tanpa menghakimi (minimal 10 karakter)."
                              class="w-full p-4 rounded-2xl border-2 border-gray-300 focus:border-red-700 focus:ring-2 focus:ring-red-100 outline-none transition text-sm text-gray-800 bg-white/80 resize-none leading-relaxed"></textarea>
                </div>
                <p id="storyValidationError" class="text-xs text-red-600 mt-1 hidden font-medium">
                    <i class="fa-solid fa-circle-exclamation mr-1"></i> Tuliskan minimal 10 karakter agar perasaanmu dapat tersampaikan dengan baik.
                </p>
            </div>

            <!-- Big OPEN Button -->
            <div class="flex flex-col items-center justify-center my-2">
                <button type="button" id="openMotivationBtn" onclick="handleOpenMotivation()" class="open-btn-glow w-24 h-24 sm:w-28 sm:h-28 rounded-full text-white font-serif font-extrabold text-xl sm:text-2xl tracking-wider flex flex-col items-center justify-center gap-1 transition duration-300" aria-label="Buka pesan penguat hati">
                    <span id="openBtnLabel">OPEN</span>
                    <i id="openBtnIcon" class="fa-solid fa-sparkles text-xs text-amber-200 animate-bounce"></i>
                </button>
                <p class="text-xs text-gray-500 mt-3 italic text-center">Tekan tombol OPEN untuk menyimpan ceritamu dan membuka pesan penguat hati</p>
            </div>

            <!-- Motivational Result Card (Revealed after OPEN) -->
            <div id="resultBox" class="hidden opacity-0 transition-all duration-700 mt-6 p-6 rounded-2xl bg-gradient-to-br from-amber-50/90 via-white to-red-50/80 border-2 border-amber-300 text-center relative overflow-hidden shadow-xl" aria-live="polite">
                <div class="absolute -right-6 -bottom-6 text-amber-500/10 text-8xl pointer-events-none font-serif select-none">"</div>
                
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-red-800 text-white text-xs font-semibold rounded-full mb-3 shadow-sm">
                    <i class="fa-solid fa-heart-pulse"></i> Pesan Spesial Untukmu
                </div>

                <p id="motivationText" class="font-sans text-sm sm:text-base leading-relaxed text-gray-800 mb-4 font-medium text-justify sm:text-center">
                    <!-- Dynamic Text will be injected here -->
                </p>

                <div class="p-3.5 rounded-xl bg-white/90 border border-amber-200 text-xs italic text-amber-950 mb-4">
                    <span id="quoteText">"Setiap badai pasti berlalu, dan kamu jauh lebih kuat dari apa yang kamu bayangkan."</span>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap items-center justify-center gap-2.5 pt-2">
                    <button type="button" onclick="copyMotivation()" class="min-h-[44px] py-2 px-4 rounded-full bg-white border border-gray-300 text-gray-700 text-xs font-semibold hover:bg-gray-50 hover:border-amber-500 transition flex items-center gap-1.5 shadow-sm">
                        <i class="fa-regular fa-copy text-amber-700"></i> Salin Pesan
                    </button>
                    <button type="button" onclick="saveReflection()" class="min-h-[44px] py-2 px-4 rounded-full bg-amber-600 text-white text-xs font-semibold hover:bg-amber-700 transition flex items-center gap-1.5 shadow-sm">
                        <i class="fa-solid fa-bookmark"></i> Simpan Catatan
                    </button>
                </div>
            </div>

            <!-- Navigation Back Button -->
            <div class="mt-8 pt-4 border-t border-gray-200 flex justify-between items-center">
                <button type="button" onclick="goToPage(1)" class="min-h-[44px] py-2 px-5 rounded-full border-2 border-gray-400 text-gray-700 font-semibold text-xs hover:bg-gray-100 hover:text-gray-900 transition flex items-center gap-2">
                    <i class="fa-solid fa-chevron-left"></i> Kembali & Edit Data
                </button>
                
                <button type="button" onclick="resetFormStory()" class="min-h-[44px] px-3 text-xs text-gray-600 hover:text-red-700 underline transition font-medium">
                    Tulis Cerita Baru
                </button>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="w-full text-center py-4 text-xs text-gray-500 font-medium z-10">
        <p>&copy; 2026 LESTARI - Aksi Nyata Hidup Sehat dan Kesehatan Mental Bersama Jovian</p>
    </footer>

    <!-- Saved Reflections History Modal -->
    <div id="historyModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden opacity-0 transition-opacity duration-300" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-amber-300 flex flex-col max-h-[85vh]">
            <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                <h3 id="modalTitle" class="font-serif text-xl font-bold text-gray-900 flex items-center gap-2">
                    <i class="fa-solid fa-box-archive text-amber-600"></i> Riwayat Refleksi
                </h3>
                <button onclick="closeHistoryModal()" class="w-9 h-9 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 flex items-center justify-center transition" aria-label="Tutup Riwayat">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div id="historyList" class="my-4 overflow-y-auto flex flex-col gap-3 pr-1 text-sm">
                <!-- Injected via JavaScript -->
            </div>

            <div class="pt-3 border-t border-gray-200 flex justify-between items-center">
                <span class="text-xs text-gray-400">Tersimpan di perangkat ini</span>
                <button onclick="clearHistory()" class="text-xs text-red-600 hover:text-red-800 underline font-medium">Hapus Semua Riwayat</button>
            </div>
        </div>
    </div>

    <!-- Notification Toast -->
    <div id="toast" class="fixed bottom-5 right-5 z-50 transform translate-y-20 opacity-0 transition-all duration-300 pointer-events-none" role="status" aria-live="polite">
        <div class="bg-gray-900 text-white px-5 py-3 rounded-2xl shadow-2xl flex items-center gap-3 border border-amber-400/40">
            <i id="toastIcon" class="fa-solid fa-circle-check text-amber-400 text-lg"></i>
            <span id="toastMessage" class="text-xs font-medium">Pesan berhasil disalin!</span>
        </div>
    </div>

    <script>
        /* State Variables */
        let userData = {
            nama: '',
            umur: '',
            jenisKelamin: '',
            pendidikan: ''
        };
        let selectedCategory = 'Diri Sendiri';
        let audioContext = null;
        let isAudioPlaying = false;
        let audioOscillator = null;
        let isSubmitting = false;

        /* Category Quotes Fallback Template */
        const fallbackDatabase = {
            'Diri Sendiri': {
                message: "Kamu ga sendirian kok, {NAMA}. Tidak apa-apa untuk merasa lelah saat memperjuangkan banyak hal sendirian. Izinkan dirimu beristirahat sejenak dari ekspektasi dunia. Ingatlah bahwa versi dirimu yang sekarang sudah berjuang luar biasa hebat. Kembali melangkah pelan-pelan saat kamu sudah siap. LESTARI selalu ada untuk menemani langkahmu! ✨",
                quote: "Mencintai dan menghargai diri sendiri adalah awal dari proses penyembuhan yang paling indah."
            },
            'Keluarga': {
                message: "Halo {NAMA}, dinamika dengan keluarga memang terkadang menjadi ujian yang paling menyentuh hati. Ingatlah bahwa kamu tidak bisa mengontrol semua hal, tetapi kamu berhak menjaga ketenangan pikiranmu sendiri. Teruslah berbuat baik dengan batasan yang sehat. Kamu adalah sosok yang tangguh dan penuh kasih sayang! ✨",
                quote: "Rumah terbaik adalah kedamaian yang kamu ciptakan di dalam hatimu sendiri."
            },
            'Teman': {
                message: "Untuk {NAMA}, pertemanan dan hubungan sosial memang memiliki pasang surutnya. Jangan biarkan kekecewaan membuatmu ragu akan ketulusan hatimu. Orang-orang yang tepat akan selalu menghargai kehadiranmu apa adanya. Tetaplah menjadi pribadi yang hangat dan jujur pada dirimu sendiri! ✨",
                quote: "Kualitas hubungan jauh lebih bermakna daripada kuantitas lingkaran pertemanan."
            },
            'Kekasih': {
                message: "Dear {NAMA}, urusan perasaan dan pasangan memang membutuhkan kelapangan dada yang besar. Dengarkan suara hatimu, komunikasikan apa yang kamu rasakan, atau beri jeda untuk saling memahami. Cinta yang sehat selalu memberikan rasa aman, bukan kecemasan yang berlarut. Kamu layak mendapatkan kedamaian cinta! ✨",
                quote: "Cinta sejati selalu bertumbuh bersama rasa saling menghormati dan ketenangan jiwa."
            }
        };

        /* Initialization on Load */
        window.addEventListener('DOMContentLoaded', () => {
            initBackgroundParticles();

            // Keyboard Escape listener for Modal (R-32)
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    closeHistoryModal();
                }
            });
        });

        /* Form Handler Page 1 */
        function handleFormSubmit(event) {
            event.preventDefault();
            
            const nama = document.getElementById('nama').value.trim();
            const umur = document.getElementById('umur').value;
            const genderEl = document.querySelector('input[name="jenis_kelamin"]:checked');
            const pendidikan = document.getElementById('pendidikan').value;

            if (!nama || !umur || !genderEl || !pendidikan) {
                showToast("Mohon lengkapi seluruh data formulir terlebih dahulu.", "fa-triangle-exclamation");
                return;
            }

            userData = {
                nama: nama,
                umur: parseInt(umur),
                jenisKelamin: genderEl.value,
                pendidikan: pendidikan
            };

            // Update Page 2 Personal Greetings
            document.getElementById('welcomeGreeting').innerText = `Halo, ${userData.nama}!`;
            document.getElementById('userBadge').innerHTML = `<i class="fa-solid fa-user-check mr-1 text-amber-700"></i> ${userData.jenisKelamin}, ${userData.umur} Thn (${userData.pendidikan})`;

            goToPage(2);
            showToast(`Selamat datang di Ruang Cerita, ${userData.nama}!`, "fa-heart");
        }

        /* Page Navigation with Smooth Animation */
        function goToPage(pageNumber) {
            const page1 = document.getElementById('page1');
            const page2 = document.getElementById('page2');

            if (pageNumber === 1) {
                page2.classList.remove('active');
                setTimeout(() => {
                    page2.style.display = 'none';
                    page1.style.display = 'flex';
                    setTimeout(() => page1.classList.add('active'), 50);
                }, 300);
            } else if (pageNumber === 2) {
                page1.classList.remove('active');
                setTimeout(() => {
                    page1.style.display = 'none';
                    page2.style.display = 'flex';
                    setTimeout(() => page2.classList.add('active'), 50);
                }, 300);
            }

            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        /* Select Category Pill */
        function selectCategory(button, categoryName) {
            const buttons = document.querySelectorAll('.category-pill');
            buttons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            selectedCategory = categoryName;
            playClickSound();
        }

        /* Character Counter */
        function updateCharCount() {
            const textarea = document.getElementById('storyText');
            const charCounter = document.getElementById('charCounter');
            const errorEl = document.getElementById('storyValidationError');
            const len = textarea.value.length;
            charCounter.innerText = `${len} / 500`;

            if (len >= 10 && !errorEl.classList.contains('hidden')) {
                errorEl.classList.add('hidden');
            }
        }

        /* Open Motivation Button Action with Backend Integration */
        async function handleOpenMotivation() {
            if (isSubmitting) return;

            const textarea = document.getElementById('storyText');
            const storyContent = textarea.value.trim();
            const errorEl = document.getElementById('storyValidationError');

            // Validasi: Wajib minimal 10 karakter sesuai kesepakatan spesifikasi
            if (storyContent.length < 10) {
                errorEl.classList.remove('hidden');
                textarea.focus();
                showToast("Cerita minimal 10 karakter sebelum membuka motivasi.", "fa-triangle-exclamation");
                return;
            }
            errorEl.classList.add('hidden');

            const openBtn = document.getElementById('openMotivationBtn');
            const openBtnLabel = document.getElementById('openBtnLabel');
            const openBtnIcon = document.getElementById('openBtnIcon');
            const resultBox = document.getElementById('resultBox');
            const motivationText = document.getElementById('motivationText');
            const quoteText = document.getElementById('quoteText');

            // Set loading state
            isSubmitting = true;
            openBtn.disabled = true;
            openBtnLabel.innerText = "MEMUAT";
            openBtnIcon.className = "fa-solid fa-circle-notch fa-spin text-xs text-amber-200";

            let resultPesan = '';
            let resultQuote = '';

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const response = await fetch('/stories', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        nama: userData.nama,
                        umur: userData.umur,
                        jenis_kelamin: userData.jenisKelamin,
                        pendidikan: userData.pendidikan,
                        kategori: selectedCategory,
                        cerita: storyContent
                    })
                });

                const json = await response.json();

                if (response.ok && json.success) {
                    resultPesan = json.data.pesan;
                    resultQuote = json.data.quote;
                } else {
                    throw new Error(json.message || 'Gagal menyimpan cerita');
                }
            } catch (err) {
                // Fallback offline / network error handling gracefully
                const template = fallbackDatabase[selectedCategory] || fallbackDatabase['Diri Sendiri'];
                resultPesan = template.message.replace(/{NAMA}/g, userData.nama || 'Sahabat');
                resultQuote = template.quote;
            } finally {
                // Reset button state
                isSubmitting = false;
                openBtn.disabled = false;
                openBtnLabel.innerText = "OPEN";
                openBtnIcon.className = "fa-solid fa-sparkles text-xs text-amber-200 animate-bounce";
            }

            // Tampilkan hasil motivasi
            motivationText.innerText = resultPesan;
            quoteText.innerText = `"${resultQuote}"`;

            resultBox.classList.remove('hidden');
            setTimeout(() => {
                resultBox.classList.add('opacity-100');
                resultBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 100);

            // Trigger Visual Particle Burst & Soft Audio Chime (MOTION 3)
            triggerParticleBurst();
            playChimeSound();
        }

        /* Reset Form & Story: Pertahankan data identitas di Halaman 2 sesuai kesepakatan */
        function resetFormStory() {
            document.getElementById('storyText').value = '';
            document.getElementById('charCounter').innerText = '0 / 500';
            document.getElementById('storyValidationError').classList.add('hidden');
            const resultBox = document.getElementById('resultBox');
            resultBox.classList.remove('opacity-100');
            setTimeout(() => resultBox.classList.add('hidden'), 300);
            showToast("Area cerita telah dibersihkan. Silakan tulis cerita baru.", "fa-rotate-right");
        }

        /* Copy Motivation Text */
        function copyMotivation() {
            const textToCopy = document.getElementById('motivationText').innerText + "\n\n" + document.getElementById('quoteText').innerText;
            
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(textToCopy).then(() => {
                    showToast("Pesan motivasi berhasil disalin ke clipboard!", "fa-copy");
                }).catch(() => {
                    fallbackCopy(textToCopy);
                });
            } else {
                fallbackCopy(textToCopy);
            }
        }

        function fallbackCopy(text) {
            const dummy = document.createElement("textarea");
            document.body.appendChild(dummy);
            dummy.value = text;
            dummy.select();
            document.execCommand("copy");
            document.body.removeChild(dummy);
            showToast("Pesan motivasi berhasil disalin ke clipboard!", "fa-copy");
        }

        /* Save Reflection to LocalStorage */
        function saveReflection() {
            const story = document.getElementById('storyText').value.trim() || 'Tanpa keluhan tertulis';
            const motivation = document.getElementById('motivationText').innerText;
            const quote = document.getElementById('quoteText').innerText;

            const newEntry = {
                id: Date.now(),
                date: new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' }),
                nama: userData.nama || 'Sahabat',
                category: selectedCategory,
                story: story,
                motivation: motivation,
                quote: quote
            };

            let history = JSON.parse(localStorage.getItem('lestari_reflections') || '[]');
            history.unshift(newEntry);
            localStorage.setItem('lestari_reflections', JSON.stringify(history));

            showToast("Refleksi berhasil disimpan ke riwayat catatan!", "fa-bookmark");
        }

        /* History Modal Logic */
        function openHistoryModal() {
            const modal = document.getElementById('historyModal');
            const historyList = document.getElementById('historyList');
            const history = JSON.parse(localStorage.getItem('lestari_reflections') || '[]');

            if (history.length === 0) {
                historyList.innerHTML = `
                    <div class="text-center py-8 text-gray-500">
                        <i class="fa-solid fa-folder-open text-3xl mb-2 text-gray-400"></i>
                        <p class="text-xs">Belum ada catatan refleksi yang tersimpan di perangkat ini.</p>
                    </div>
                `;
            } else {
                historyList.innerHTML = history.map(item => `
                    <div class="p-3.5 rounded-2xl bg-gray-50 border border-gray-200 flex flex-col gap-1.5">
                        <div class="flex justify-between items-center text-xs">
                            <span class="font-bold text-red-800">${item.category} • ${item.nama}</span>
                            <span class="text-gray-500 text-[11px]">${item.date}</span>
                        </div>
                        <p class="text-xs text-gray-700 italic line-clamp-2">"${item.story}"</p>
                        <p class="text-xs text-gray-900 font-medium bg-white p-2.5 rounded-xl border border-amber-200">${item.motivation}</p>
                    </div>
                `).join('');
            }

            modal.classList.remove('hidden');
            setTimeout(() => modal.classList.add('opacity-100'), 50);
        }

        function closeHistoryModal() {
            const modal = document.getElementById('historyModal');
            modal.classList.remove('opacity-100');
            setTimeout(() => modal.classList.add('hidden'), 300);
        }

        function clearHistory() {
            if (confirm("Apakah Anda yakin ingin menghapus seluruh riwayat catatan di perangkat ini?")) {
                localStorage.removeItem('lestari_reflections');
                openHistoryModal();
                showToast("Semua riwayat catatan telah dibersihkan.", "fa-trash");
            }
        }

        /* Toast Notification System */
        function showToast(message, iconClass = "fa-circle-check") {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toastMessage');
            const toastIcon = document.getElementById('toastIcon');

            toastMessage.innerText = message;
            toastIcon.className = `fa-solid ${iconClass} text-amber-400 text-lg`;

            toast.classList.remove('pointer-events-none', 'translate-y-20', 'opacity-0');
            toast.classList.add('translate-y-0', 'opacity-100');

            setTimeout(() => {
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('translate-y-20', 'opacity-0', 'pointer-events-none');
            }, 3000);
        }

        /* Ambient Synth & Sound Effects via Web Audio API */
        function getAudioContext() {
            if (!audioContext) {
                audioContext = new (window.AudioContext || window.webkitAudioContext)();
            }
            if (audioContext.state === 'suspended') {
                audioContext.resume();
            }
            return audioContext;
        }

        function playClickSound() {
            try {
                const ctx = getAudioContext();
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();

                osc.type = 'sine';
                osc.frequency.setValueAtTime(587.33, ctx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(880, ctx.currentTime + 0.08);

                gain.gain.setValueAtTime(0.08, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.08);

                osc.connect(gain);
                gain.connect(ctx.destination);

                osc.start();
                osc.stop(ctx.currentTime + 0.09);
            } catch (e) {}
        }

        function playChimeSound() {
            try {
                const ctx = getAudioContext();
                const notes = [523.25, 659.25, 783.99, 1046.50]; // C5, E5, G5, C6
                notes.forEach((freq, idx) => {
                    const osc = ctx.createOscillator();
                    const gain = ctx.createGain();

                    osc.type = 'sine';
                    osc.frequency.setValueAtTime(freq, ctx.currentTime + idx * 0.1);

                    gain.gain.setValueAtTime(0, ctx.currentTime + idx * 0.1);
                    gain.gain.linearRampToValueAtTime(0.12, ctx.currentTime + idx * 0.1 + 0.02);
                    gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + idx * 0.1 + 0.8);

                    osc.connect(gain);
                    gain.connect(ctx.destination);

                    osc.start(ctx.currentTime + idx * 0.1);
                    osc.stop(ctx.currentTime + idx * 0.1 + 0.85);
                });
            } catch (e) {}
        }

        function toggleAudio() {
            const statusText = document.getElementById('soundStatusText');
            const soundIcon = document.getElementById('soundIcon');
            if (!isAudioPlaying) {
                startAmbientDrone();
                isAudioPlaying = true;
                statusText.innerText = "Musik On";
                soundIcon.className = "fa-solid fa-volume-high text-red-700";
                showToast("Relaksasi nada 174 Hz diaktifkan.", "fa-music");
            } else {
                stopAmbientDrone();
                isAudioPlaying = false;
                statusText.innerText = "Musik Off";
                soundIcon.className = "fa-solid fa-volume-xmark text-gray-500";
                showToast("Relaksasi nada dimatikan.", "fa-volume-xmark");
            }
        }

        function startAmbientDrone() {
            try {
                const ctx = getAudioContext();
                audioOscillator = ctx.createOscillator();
                const gain = ctx.createGain();

                audioOscillator.type = 'triangle';
                audioOscillator.frequency.setValueAtTime(174, ctx.currentTime);

                gain.gain.setValueAtTime(0.001, ctx.currentTime);
                gain.gain.linearRampToValueAtTime(0.03, ctx.currentTime + 2);

                audioOscillator.connect(gain);
                gain.connect(ctx.destination);

                audioOscillator.start();
            } catch(e) {}
        }

        function stopAmbientDrone() {
            if (audioOscillator) {
                try {
                    audioOscillator.stop();
                    audioOscillator.disconnect();
                } catch(e) {}
                audioOscillator = null;
            }
        }

        /* Canvas Particle Engine for Background & Bursts */
        let canvas, ctx;
        let particles = [];
        let burstParticles = [];

        function initBackgroundParticles() {
            canvas = document.getElementById('bg-canvas');
            if (!canvas) return;
            ctx = canvas.getContext('2d');

            resizeCanvas();
            window.addEventListener('resize', resizeCanvas);

            // Floating background particles
            particles = [];
            for (let i = 0; i < 35; i++) {
                particles.push({
                    x: Math.random() * canvas.width,
                    y: Math.random() * canvas.height,
                    radius: Math.random() * 2.5 + 0.5,
                    color: Math.random() > 0.5 ? 'rgba(212, 175, 55, ' : 'rgba(139, 0, 0, ',
                    alpha: Math.random() * 0.4 + 0.1,
                    speedX: (Math.random() - 0.5) * 0.4,
                    speedY: -Math.random() * 0.5 - 0.2
                });
            }

            animateParticles();
        }

        function resizeCanvas() {
            if (canvas) {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            }
        }

        function animateParticles() {
            if (!ctx || !canvas) return;
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Render floating background particles
            particles.forEach(p => {
                p.x += p.speedX;
                p.y += p.speedY;

                if (p.y < 0) {
                    p.y = canvas.height;
                    p.x = Math.random() * canvas.width;
                }
                if (p.x < 0 || p.x > canvas.width) {
                    p.speedX *= -1;
                }

                ctx.beginPath();
                ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
                ctx.fillStyle = p.color + p.alpha + ')';
                ctx.fill();
            });

            // Render active burst particles
            for (let i = burstParticles.length - 1; i >= 0; i--) {
                let bp = burstParticles[i];
                bp.x += bp.vx;
                bp.y += bp.vy;
                bp.vy += 0.08;
                bp.alpha -= 0.015;

                if (bp.alpha <= 0) {
                    burstParticles.splice(i, 1);
                    continue;
                }

                ctx.beginPath();
                ctx.arc(bp.x, bp.y, bp.radius, 0, Math.PI * 2);
                ctx.fillStyle = bp.color + bp.alpha + ')';
                ctx.fill();
            }

            requestAnimationFrame(animateParticles);
        }

        function triggerParticleBurst() {
            if (!canvas) return;
            const centerX = canvas.width / 2;
            const centerY = canvas.height / 2;

            const colors = ['rgba(212, 175, 55, ', 'rgba(211, 47, 47, ', 'rgba(247, 240, 212, ', 'rgba(255, 255, 255, '];

            for (let i = 0; i < 70; i++) {
                const angle = Math.random() * Math.PI * 2;
                const speed = Math.random() * 8 + 2;
                burstParticles.push({
                    x: centerX,
                    y: centerY,
                    vx: Math.cos(angle) * speed,
                    vy: Math.sin(angle) * speed - 2,
                    radius: Math.random() * 4 + 2,
                    color: colors[Math.floor(Math.random() * colors.length)],
                    alpha: 1.0
                });
            }
        }
    </script>
</body>
</html>
