@extends('admin.layout')

@section('title', 'Eksplorasi Curahan Hati Peserta')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-gray-200">
        <div>
            <h2 class="font-serif text-2xl sm:text-3xl font-bold text-gray-900">Curahan Hati Peserta</h2>
            <p class="text-xs sm:text-sm text-gray-600 mt-1">Daftar rekaman keluhan dan motivasi narasumber kegiatan sosialisasi Jovian</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3.5 py-1.5 rounded-full bg-red-50 text-red-800 border border-red-200 text-xs font-bold">
                {{ number_format($stories->total()) }} Cerita Ditemukan
            </span>
        </div>
    </div>

    <!-- Filter & Search Form -->
    <div class="p-5 rounded-2xl bg-white border border-gray-200 shadow-sm">
        <form method="GET" action="{{ route('admin.stories') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            
            <!-- Pencarian Teks -->
            <div class="lg:col-span-2">
                <label for="search" class="block text-[11px] font-bold text-gray-600 uppercase tracking-wider mb-1">Cari Nama / Kata Kunci</label>
                <div class="relative">
                    <input type="text" id="search" name="search" value="{{ request('search') }}" 
                           placeholder="Ketik nama atau kata dalam cerita..."
                           class="w-full pl-9 pr-3 py-2.5 rounded-xl border border-gray-300 text-xs text-gray-800 focus:border-red-700 focus:ring-1 focus:ring-red-700 outline-none">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-gray-400 text-xs"></i>
                </div>
            </div>

            <!-- Filter Jenjang Pendidikan -->
            <div>
                <label for="pendidikan" class="block text-[11px] font-bold text-gray-600 uppercase tracking-wider mb-1">Jenjang Pendidikan</label>
                <select id="pendidikan" name="pendidikan" class="w-full px-3 py-2.5 rounded-xl border border-gray-300 text-xs text-gray-800 focus:border-red-700 focus:ring-1 focus:ring-red-700 outline-none bg-white">
                    <option value="">Semua Jenjang</option>
                    <option value="SD" {{ request('pendidikan') == 'SD' ? 'selected' : '' }}>SD / Sederajat</option>
                    <option value="SMP" {{ request('pendidikan') == 'SMP' ? 'selected' : '' }}>SMP / Sederajat</option>
                    <option value="SMA" {{ request('pendidikan') == 'SMA' ? 'selected' : '' }}>SMA / SMK / MA</option>
                    <option value="MAHASISWA" {{ request('pendidikan') == 'MAHASISWA' ? 'selected' : '' }}>MAHASISWA</option>
                    <option value="UMUM" {{ request('pendidikan') == 'UMUM' ? 'selected' : '' }}>UMUM / LAINNYA</option>
                </select>
            </div>

            <!-- Filter Kategori -->
            <div>
                <label for="kategori" class="block text-[11px] font-bold text-gray-600 uppercase tracking-wider mb-1">Kategori Cerita</label>
                <select id="kategori" name="kategori" class="w-full px-3 py-2.5 rounded-xl border border-gray-300 text-xs text-gray-800 focus:border-red-700 focus:ring-1 focus:ring-red-700 outline-none bg-white">
                    <option value="">Semua Kategori</option>
                    <option value="Diri Sendiri" {{ request('kategori') == 'Diri Sendiri' ? 'selected' : '' }}>Diri Sendiri</option>
                    <option value="Keluarga" {{ request('kategori') == 'Keluarga' ? 'selected' : '' }}>Keluarga</option>
                    <option value="Teman" {{ request('kategori') == 'Teman' ? 'selected' : '' }}>Teman</option>
                    <option value="Kekasih" {{ request('kategori') == 'Kekasih' ? 'selected' : '' }}>Kekasih</option>
                </select>
            </div>

            <!-- Tombol Terapkan & Reset -->
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 py-2.5 px-4 rounded-xl bg-red-800 hover:bg-red-900 text-white font-semibold text-xs shadow-sm transition min-h-[40px] flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-filter text-[11px]"></i>
                    <span>Terapkan</span>
                </button>
                @if(request()->anyFilled(['search', 'pendidikan', 'kategori', 'date']))
                    <a href="{{ route('admin.stories') }}" class="py-2.5 px-3 rounded-xl border border-gray-300 text-gray-600 hover:bg-gray-100 text-xs font-semibold transition min-h-[40px] flex items-center justify-center" title="Reset Filter">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>

        </form>
    </div>

    <!-- Tabel Daftar Cerita -->
    <div class="rounded-2xl bg-white border border-gray-200 shadow-sm overflow-hidden">
        @if($stories->isEmpty())
            <div class="text-center py-16 px-4">
                <i class="fa-solid fa-comment-slash text-4xl mb-3 text-gray-300"></i>
                <h3 class="font-serif text-lg font-bold text-gray-800">Tidak ada cerita yang cocok</h3>
                <p class="text-xs text-gray-500 max-w-sm mx-auto mt-1">Coba sesuaikan kata kunci pencarian atau ubah kriteria filter kategori di atas.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-gray-700">
                    <thead class="bg-gray-50 text-gray-600 uppercase font-bold text-[11px] border-b border-gray-200">
                        <tr>
                            <th class="py-3.5 px-4">Waktu</th>
                            <th class="py-3.5 px-4">Narasumber</th>
                            <th class="py-3.5 px-4">Jenjang</th>
                            <th class="py-3.5 px-4">Kategori</th>
                            <th class="py-3.5 px-4">Cuplikan Cerita</th>
                            <th class="py-3.5 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($stories as $story)
                            <tr class="hover:bg-gray-50/70 transition">
                                <td class="py-3.5 px-4 whitespace-nowrap text-gray-500">
                                    {{ $story->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    <div class="font-bold text-gray-900">{{ $story->nama }}</div>
                                    <div class="text-[11px] text-gray-500">{{ $story->jenis_kelamin }}, {{ $story->umur }} tahun</div>
                                </td>
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    <span class="px-2.5 py-1 rounded-md text-[11px] font-semibold bg-gray-100 text-gray-700 border border-gray-200">
                                        {{ $story->pendidikan }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    <span class="px-2.5 py-1 rounded-md text-[11px] font-semibold bg-red-50 text-red-800 border border-red-200">
                                        {{ $story->kategori }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 max-w-sm truncate text-gray-600" title="{{ $story->cerita }}">
                                    "{{ $story->cerita }}"
                                </td>
                                <td class="py-3.5 px-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <!-- Tombol Baca Lengkap -->
                                        <button type="button" 
                                                onclick="openStoryModal({{ json_encode($story) }})"
                                                class="min-h-[36px] py-1.5 px-3 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 font-semibold text-xs transition flex items-center gap-1">
                                            <i class="fa-solid fa-eye text-[11px]"></i>
                                            <span>Detail</span>
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('admin.stories.destroy', $story->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan cerita dari {{ $story->nama }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="min-h-[36px] min-w-[36px] rounded-lg text-gray-400 hover:text-red-700 hover:bg-red-50 transition flex items-center justify-center" title="Hapus Cerita">
                                                <i class="fa-solid fa-trash-can text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination Bar -->
            <div class="p-4 border-t border-gray-100">
                {{ $stories->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Modal Detail Cerita Lengkap -->
<div id="storyDetailModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden opacity-0 transition-opacity duration-300" role="dialog" aria-modal="true" aria-labelledby="modalDetailTitle">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-amber-300 flex flex-col max-h-[90vh]">
        
        <div class="flex justify-between items-center pb-3 border-b border-gray-200">
            <div>
                <h3 id="modalDetailTitle" class="font-serif text-xl font-bold text-gray-900">
                    Detail Curahan Hati
                </h3>
                <p id="modalSubmitTime" class="text-[11px] text-gray-500 mt-0.5"></p>
            </div>
            <button onclick="closeStoryModal()" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 flex items-center justify-center transition" aria-label="Tutup">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="my-4 overflow-y-auto pr-1 space-y-4 text-xs">
            
            <!-- Narasumber Badge Box -->
            <div class="p-3.5 rounded-2xl bg-gray-50 border border-gray-200 flex flex-wrap items-center justify-between gap-2">
                <div>
                    <span class="text-gray-400 uppercase text-[10px] font-bold tracking-wider block">Narasumber</span>
                    <span id="modalNama" class="text-sm font-bold text-gray-900"></span>
                    <span id="modalProfil" class="text-gray-600 ml-1"></span>
                </div>
                <div>
                    <span id="modalKategoriBadge" class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-900 border border-red-200"></span>
                </div>
            </div>

            <!-- Isi Curahan Hati Utuh -->
            <div>
                <label class="font-bold text-gray-700 uppercase text-[10px] tracking-wider block mb-1">Curahan Hati Peserta:</label>
                <div class="p-4 rounded-2xl bg-amber-50/60 border border-amber-200 text-gray-800 text-sm leading-relaxed whitespace-pre-wrap font-medium">
                    <span id="modalCerita"></span>
                </div>
            </div>

            <!-- Pesan Motivasi yang Diterima -->
            <div>
                <label class="font-bold text-gray-700 uppercase text-[10px] tracking-wider block mb-1">Pesan Motivasi yang Diterima:</label>
                <div class="p-4 rounded-2xl bg-white border border-gray-200 space-y-2">
                    <p id="modalPesan" class="text-gray-800 leading-relaxed font-medium"></p>
                    <div class="p-2.5 rounded-xl bg-amber-50 text-amber-900 italic text-[11px] border border-amber-100">
                        <span id="modalQuote"></span>
                    </div>
                </div>
            </div>

            <!-- Info Metadata Teknis -->
            <div class="pt-2 text-[10px] text-gray-400 flex justify-between items-center">
                <span id="modalIp"></span>
                <span>ID Rekaman: #<span id="modalId"></span></span>
            </div>

        </div>

        <div class="pt-3 border-t border-gray-200 flex justify-end">
            <button type="button" onclick="closeStoryModal()" class="py-2 px-5 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-xs transition">
                Tutup
            </button>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    function openStoryModal(story) {
        document.getElementById('modalNama').innerText = story.nama;
        document.getElementById('modalProfil').innerText = `(${story.jenis_kelamin}, ${story.umur} th, ${story.pendidikan})`;
        document.getElementById('modalKategoriBadge').innerText = story.kategori;
        document.getElementById('modalCerita').innerText = story.cerita;
        document.getElementById('modalPesan').innerText = story.motivation_text || 'Tidak ada catatan motivasi.';
        document.getElementById('modalQuote').innerText = story.quote_text ? `"${story.quote_text}"` : '';
        document.getElementById('modalSubmitTime').innerText = `Diterima pada ${story.created_at}`;
        document.getElementById('modalIp').innerText = story.ip_address ? `Alamat IP: ${story.ip_address}` : 'IP: Anonim';
        document.getElementById('modalId').innerText = story.id;

        const modal = document.getElementById('storyDetailModal');
        modal.classList.remove('hidden');
        setTimeout(() => modal.classList.add('opacity-100'), 50);
    }

    function closeStoryModal() {
        const modal = document.getElementById('storyDetailModal');
        modal.classList.remove('opacity-100');
        setTimeout(() => modal.classList.add('hidden'), 300);
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeStoryModal();
        }
    });
</script>
@endpush
