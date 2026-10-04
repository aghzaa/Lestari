@extends('admin.layout')

@section('title', 'Dashboard & Metrik Sosialisasi')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-gray-200">
        <div>
            <h2 class="font-serif text-2xl sm:text-3xl font-bold text-gray-900">Dashboard & Metrik Sosialisasi</h2>
            <p class="text-xs sm:text-sm text-gray-600 mt-1">Ringkasan analisis data curahan hati narasumber kegiatan Jovian Health Care</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-semibold">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Sistem Aktif</span>
            </span>
        </div>
    </div>

    <!-- 4 Metrik Utama -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Card 1: Total Cerita -->
        <div class="p-5 rounded-2xl bg-white border border-gray-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-gray-500">Total Cerita Masuk</p>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mt-1">{{ number_format($totalStories) }}</h3>
                <p class="text-[11px] text-gray-500 mt-1">Akumulasi seluruh sesi</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-800 flex items-center justify-center text-xl">
                <i class="fa-solid fa-comments"></i>
            </div>
        </div>

        <!-- Card 2: Hari Ini -->
        <div class="p-5 rounded-2xl bg-white border border-gray-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-gray-500">Narasumber Hari Ini</p>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-red-800 mt-1">{{ number_format($todayStories) }}</h3>
                <p class="text-[11px] text-gray-500 mt-1">Peserta sesi aktif</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center text-xl">
                <i class="fa-solid fa-calendar-day"></i>
            </div>
        </div>

        <!-- Card 3: Kategori Terbanyak -->
        <div class="p-5 rounded-2xl bg-white border border-gray-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-gray-500">Kategori Terpopuler</p>
                <h3 class="text-lg font-bold text-gray-900 mt-1 truncate max-w-[170px]" title="{{ $topCategory }}">{{ $topCategory }}</h3>
                <p class="text-[11px] text-gray-500 mt-1">Fokus utama curahan</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-orange-50 text-orange-700 flex items-center justify-center text-xl">
                <i class="fa-solid fa-fire"></i>
            </div>
        </div>

        <!-- Card 4: Motivasi Aktif -->
        <div class="p-5 rounded-2xl bg-white border border-gray-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-gray-500">Bank Motivasi Aktif</p>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mt-1">{{ number_format($activeMotivations) }}</h3>
                <p class="text-[11px] text-gray-500 mt-1">Pesan siap diberikan</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-800 flex items-center justify-center text-xl">
                <i class="fa-solid fa-heart-pulse"></i>
            </div>
        </div>

    </div>

    <!-- Grafik Visualisasi Data -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Grafik Jenjang Pendidikan (Bar Chart) -->
        <div class="lg:col-span-2 p-6 rounded-2xl bg-white border border-gray-200 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="font-serif text-lg font-bold text-gray-900">Distribusi Jenjang Pendidikan Peserta</h3>
                    <p class="text-xs text-gray-500">Persebaran narasumber berdasarkan tingkatan sekolah dan kampus</p>
                </div>
                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 text-xs">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
            </div>
            <div class="relative h-64 sm:h-72 w-full">
                <canvas id="educationChart"></canvas>
            </div>
        </div>

        <!-- Grafik Kategori Cerita (Doughnut Chart) -->
        <div class="p-6 rounded-2xl bg-white border border-gray-200 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="font-serif text-lg font-bold text-gray-900">Fokus Kategori Keluhan</h3>
                    <p class="text-xs text-gray-500">Sebaran topik curahan hati</p>
                </div>
                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 text-xs">
                    <i class="fa-solid fa-chart-pie"></i>
                </div>
            </div>
            <div class="relative h-64 sm:h-72 w-full flex items-center justify-center">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>

    </div>

    <!-- 5 Cerita Terakhir yang Masuk -->
    <div class="p-6 rounded-2xl bg-white border border-gray-200 shadow-sm">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-100">
            <div>
                <h3 class="font-serif text-lg font-bold text-gray-900">Curahan Hati Terbaru</h3>
                <p class="text-xs text-gray-500">5 narasumber terakhir yang menuangkan keluhannya</p>
            </div>
            <a href="{{ route('admin.stories') }}" class="text-xs font-semibold text-red-800 hover:text-red-950 flex items-center gap-1 min-h-[44px]">
                <span>Lihat Seluruh Cerita</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        @if($recentStories->isEmpty())
            <div class="text-center py-10 text-gray-400">
                <i class="fa-solid fa-inbox text-4xl mb-2 text-gray-300"></i>
                <p class="text-sm font-medium">Belum ada cerita narasumber yang masuk ke sistem.</p>
                <p class="text-xs text-gray-400 mt-1">Data akan otomatis tampil begitu siswa mulai bercerita di Ruang Cerita.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-gray-700">
                    <thead class="bg-gray-50 text-gray-500 uppercase font-semibold text-[11px] border-b border-gray-200">
                        <tr>
                            <th class="py-3 px-4">Waktu</th>
                            <th class="py-3 px-4">Narasumber</th>
                            <th class="py-3 px-4">Jenjang</th>
                            <th class="py-3 px-4">Kategori</th>
                            <th class="py-3 px-4">Isi Curahan Hati</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($recentStories as $item)
                            <tr class="hover:bg-gray-50/80 transition">
                                <td class="py-3.5 px-4 whitespace-nowrap text-gray-500">
                                    {{ $item->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="py-3.5 px-4 font-semibold text-gray-900 whitespace-nowrap">
                                    {{ $item->nama }} ({{ $item->umur }} th)
                                </td>
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    <span class="px-2.5 py-1 rounded-md text-[11px] font-semibold bg-gray-100 text-gray-700 border border-gray-200">
                                        {{ $item->pendidikan }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    <span class="px-2.5 py-1 rounded-md text-[11px] font-semibold bg-red-50 text-red-800 border border-red-200">
                                        {{ $item->kategori }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 max-w-xs truncate text-gray-600" title="{{ $item->cerita }}">
                                    "{{ $item->cerita }}"
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Chart Jenjang Pendidikan (Bar Chart)
        const ctxEdu = document.getElementById('educationChart').getContext('2d');
        new Chart(ctxEdu, {
            type: 'bar',
            data: {
                labels: ['SD / Sederajat', 'SMP / Sederajat', 'SMA / SMK', 'MAHASISWA', 'UMUM'],
                datasets: [{
                    label: 'Jumlah Peserta',
                    data: [
                        {{ $educationCounts['SD'] }},
                        {{ $educationCounts['SMP'] }},
                        {{ $educationCounts['SMA'] }},
                        {{ $educationCounts['MAHASISWA'] }},
                        {{ $educationCounts['UMUM'] }}
                    ],
                    backgroundColor: [
                        '#991B1B', // SD
                        '#DC2626', // SMP
                        '#D97706', // SMA
                        '#B45309', // Mahasiswa
                        '#6B7280'  // Umum
                    ],
                    borderRadius: 8,
                    maxBarThickness: 45
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });

        // Chart Kategori Cerita (Doughnut Chart)
        const ctxCat = document.getElementById('categoryChart').getContext('2d');
        new Chart(ctxCat, {
            type: 'doughnut',
            data: {
                labels: ['Diri Sendiri', 'Keluarga', 'Teman', 'Kekasih'],
                datasets: [{
                    data: [
                        {{ $categoryCounts['Diri Sendiri'] }},
                        {{ $categoryCounts['Keluarga'] }},
                        {{ $categoryCounts['Teman'] }},
                        {{ $categoryCounts['Kekasih'] }}
                    ],
                    backgroundColor: [
                        '#8B0000',
                        '#B45309',
                        '#059669',
                        '#D97706'
                    ],
                    borderWidth: 2,
                    borderColor: '#FFFFFF'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            padding: 15,
                            font: { size: 11, family: 'Poppins' }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
