@extends('admin.layout')

@section('title', 'Manajemen Bank Motivasi & Quotes')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-gray-200">
        <div>
            <h2 class="font-serif text-2xl sm:text-3xl font-bold text-gray-900">Bank Pesan Motivasi & Quotes</h2>
            <p class="text-xs sm:text-sm text-gray-600 mt-1">Kelola variasi pesan penguat hati dan kutipan bijak yang diberikan kepada peserta</p>
        </div>
        <div>
            <button type="button" onclick="openCreateModal()" class="min-h-[44px] py-2.5 px-5 rounded-full bg-red-800 hover:bg-red-900 text-white font-semibold text-xs shadow-md transition flex items-center gap-2">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Tambah Pesan Baru</span>
            </button>
        </div>
    </div>

    <!-- Category Filter Tabs -->
    <div class="flex flex-wrap items-center gap-2">
        <a href="{{ route('admin.motivations') }}" 
           class="min-h-[38px] px-4 py-2 rounded-xl text-xs font-semibold border transition flex items-center gap-1.5 {{ !request('kategori') ? 'bg-red-800 text-white border-red-800 shadow-sm' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }}">
            <span>Semua Kategori</span>
        </a>
        @foreach(['Diri Sendiri', 'Keluarga', 'Teman', 'Kekasih'] as $cat)
            <a href="{{ route('admin.motivations', ['kategori' => $cat]) }}" 
               class="min-h-[38px] px-4 py-2 rounded-xl text-xs font-semibold border transition flex items-center gap-1.5 {{ request('kategori') == $cat ? 'bg-red-800 text-white border-red-800 shadow-sm' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }}">
                <span>{{ $cat }}</span>
            </a>
        @endforeach
    </div>

    <!-- Grid Kartu Motivasi -->
    @if($motivations->isEmpty())
        <div class="p-12 text-center rounded-2xl bg-white border border-gray-200">
            <i class="fa-solid fa-folder-open text-4xl mb-3 text-gray-300"></i>
            <h3 class="font-serif text-lg font-bold text-gray-800">Belum ada pesan motivasi</h3>
            <p class="text-xs text-gray-500 max-w-sm mx-auto mt-1">Klik tombol "Tambah Pesan Baru" di atas untuk menambahkan pesan motivasi ke bank data.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($motivations as $item)
                <div class="p-5 rounded-2xl bg-white border border-gray-200 shadow-sm flex flex-col justify-between hover:border-amber-300 transition group">
                    <div class="space-y-3">
                        
                        <!-- Top Bar: Category & Status Badge -->
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-md text-xs font-bold bg-amber-50 text-amber-900 border border-amber-200">
                                {{ $item->kategori }}
                            </span>
                            
                            <!-- Status Aktif / Nonaktif -->
                            <form action="{{ route('admin.motivations.toggle', $item->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="min-h-[32px] px-2.5 py-1 rounded-full text-[11px] font-bold border transition flex items-center gap-1.5 {{ $item->is_active ? 'bg-emerald-50 text-emerald-800 border-emerald-300 hover:bg-emerald-100' : 'bg-gray-100 text-gray-500 border-gray-300 hover:bg-gray-200' }}" title="Klik untuk mengubah status aktif">
                                    <span class="w-2 h-2 rounded-full {{ $item->is_active ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
                                    <span>{{ $item->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                </button>
                            </form>
                        </div>

                        <!-- Pesan Motivasi -->
                        <div>
                            <p class="text-xs text-gray-800 leading-relaxed font-medium">
                                {!! preg_replace('/(\{NAMA\})/', '<span class="bg-amber-100 text-amber-900 font-bold px-1.5 py-0.5 rounded">$1</span>', e($item->pesan)) !!}
                            </p>
                        </div>

                        <!-- Kutipan / Quote -->
                        <div class="p-3 rounded-xl bg-gray-50 border border-gray-200 text-xs italic text-gray-700">
                            "{{ $item->quote }}"
                        </div>
                    </div>

                    <!-- Bottom Bar: Action Buttons -->
                    <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between text-xs">
                        <span class="text-[11px] text-gray-400">ID #{{ $item->id }}</span>
                        <div class="flex items-center gap-1.5">
                            <!-- Edit Button -->
                            <button type="button" 
                                    onclick="openEditModal({{ json_encode($item) }})" 
                                    class="min-h-[36px] px-3 py-1.5 rounded-lg bg-gray-100 hover:bg-amber-100 hover:text-amber-900 text-gray-700 font-semibold transition flex items-center gap-1">
                                <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                                <span>Edit</span>
                            </button>

                            <!-- Delete Button -->
                            <form action="{{ route('admin.motivations.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan motivasi ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="min-h-[36px] min-w-[36px] rounded-lg text-gray-400 hover:text-red-700 hover:bg-red-50 transition flex items-center justify-center" title="Hapus Pesan">
                                    <i class="fa-solid fa-trash-can text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="pt-2">
            {{ $motivations->links() }}
        </div>
    @endif

</div>

<!-- Modal Tambah Pesan Motivasi Baru -->
<div id="createModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden opacity-0 transition-opacity duration-300" role="dialog" aria-modal="true" aria-labelledby="modalCreateTitle">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-amber-300 flex flex-col max-h-[90vh]">
        <div class="flex justify-between items-center pb-3 border-b border-gray-200">
            <h3 id="modalCreateTitle" class="font-serif text-xl font-bold text-gray-900">
                Tambah Pesan Motivasi Baru
            </h3>
            <button onclick="closeCreateModal()" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 flex items-center justify-center transition" aria-label="Tutup">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="{{ route('admin.motivations.store') }}" method="POST" class="my-4 space-y-4 text-xs overflow-y-auto pr-1">
            @csrf
            
            <!-- Kategori -->
            <div>
                <label for="createKategori" class="block font-bold text-gray-700 uppercase text-[11px] tracking-wider mb-1">
                    Fokus Kategori Cerita
                </label>
                <select id="createKategori" name="kategori" required class="w-full px-3 py-2.5 rounded-xl border border-gray-300 text-xs text-gray-800 focus:border-red-700 outline-none bg-white">
                    <option value="Diri Sendiri">Diri Sendiri</option>
                    <option value="Keluarga">Keluarga</option>
                    <option value="Teman">Teman</option>
                    <option value="Kekasih">Kekasih</option>
                </select>
            </div>

            <!-- Pesan Motivasi -->
            <div>
                <div class="flex justify-between items-center mb-1">
                    <label for="createPesan" class="block font-bold text-gray-700 uppercase text-[11px] tracking-wider">
                        Kalimat Pesan Penguat Hati
                    </label>
                    <span class="text-[10px] text-amber-800 bg-amber-50 px-2 py-0.5 rounded border border-amber-200">Gunakan tag <strong>{NAMA}</strong></span>
                </div>
                <textarea id="createPesan" name="pesan" rows="4" required
                          placeholder="Tuliskan pesan motivasi hangat di sini... Sisipkan tag {NAMA} agar nama narasumber muncul secara personal."
                          class="w-full p-3 rounded-xl border border-gray-300 text-xs text-gray-800 focus:border-red-700 outline-none leading-relaxed"></textarea>
            </div>

            <!-- Quote Inspiratif -->
            <div>
                <label for="createQuote" class="block font-bold text-gray-700 uppercase text-[11px] tracking-wider mb-1">
                    Kutipan Kata Bijak (Quote)
                </label>
                <textarea id="createQuote" name="quote" rows="2" required
                          placeholder="Contoh: Setiap badai pasti berlalu, dan kamu jauh lebih kuat dari apa yang kamu bayangkan."
                          class="w-full p-3 rounded-xl border border-gray-300 text-xs text-gray-800 focus:border-red-700 outline-none leading-relaxed"></textarea>
            </div>

            <!-- Checkbox Aktif -->
            <div class="flex items-center gap-2 pt-1">
                <input type="checkbox" id="createIsActive" name="is_active" value="1" checked class="w-4 h-4 rounded text-red-800 border-gray-300 focus:ring-amber-500">
                <label for="createIsActive" class="font-semibold text-gray-700 text-xs cursor-pointer select-none">
                    Langsung aktifkan pesan ini di sistem
                </label>
            </div>

            <!-- Modal Action Buttons -->
            <div class="pt-4 border-t border-gray-200 flex justify-end gap-2">
                <button type="button" onclick="closeCreateModal()" class="py-2.5 px-4 rounded-xl border border-gray-300 text-gray-700 font-semibold text-xs hover:bg-gray-100 transition min-h-[44px]">
                    Batal
                </button>
                <button type="submit" class="py-2.5 px-5 rounded-xl bg-red-800 hover:bg-red-900 text-white font-semibold text-xs transition shadow-sm min-h-[44px]">
                    Simpan Pesan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Pesan Motivasi -->
<div id="editModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden opacity-0 transition-opacity duration-300" role="dialog" aria-modal="true" aria-labelledby="modalEditTitle">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-amber-300 flex flex-col max-h-[90vh]">
        <div class="flex justify-between items-center pb-3 border-b border-gray-200">
            <h3 id="modalEditTitle" class="font-serif text-xl font-bold text-gray-900">
                Sunting Pesan Motivasi
            </h3>
            <button onclick="closeEditModal()" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 flex items-center justify-center transition" aria-label="Tutup">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="editForm" method="POST" class="my-4 space-y-4 text-xs overflow-y-auto pr-1">
            @csrf
            @method('PUT')
            
            <!-- Kategori -->
            <div>
                <label for="editKategori" class="block font-bold text-gray-700 uppercase text-[11px] tracking-wider mb-1">
                    Fokus Kategori Cerita
                </label>
                <select id="editKategori" name="kategori" required class="w-full px-3 py-2.5 rounded-xl border border-gray-300 text-xs text-gray-800 focus:border-red-700 outline-none bg-white">
                    <option value="Diri Sendiri">Diri Sendiri</option>
                    <option value="Keluarga">Keluarga</option>
                    <option value="Teman">Teman</option>
                    <option value="Kekasih">Kekasih</option>
                </select>
            </div>

            <!-- Pesan Motivasi -->
            <div>
                <div class="flex justify-between items-center mb-1">
                    <label for="editPesan" class="block font-bold text-gray-700 uppercase text-[11px] tracking-wider">
                        Kalimat Pesan Penguat Hati
                    </label>
                    <span class="text-[10px] text-amber-800 bg-amber-50 px-2 py-0.5 rounded border border-amber-200">Gunakan tag <strong>{NAMA}</strong></span>
                </div>
                <textarea id="editPesan" name="pesan" rows="4" required
                          class="w-full p-3 rounded-xl border border-gray-300 text-xs text-gray-800 focus:border-red-700 outline-none leading-relaxed"></textarea>
            </div>

            <!-- Quote Inspiratif -->
            <div>
                <label for="editQuote" class="block font-bold text-gray-700 uppercase text-[11px] tracking-wider mb-1">
                    Kutipan Kata Bijak (Quote)
                </label>
                <textarea id="editQuote" name="quote" rows="2" required
                          class="w-full p-3 rounded-xl border border-gray-300 text-xs text-gray-800 focus:border-red-700 outline-none leading-relaxed"></textarea>
            </div>

            <!-- Checkbox Aktif -->
            <div class="flex items-center gap-2 pt-1">
                <input type="checkbox" id="editIsActive" name="is_active" value="1" class="w-4 h-4 rounded text-red-800 border-gray-300 focus:ring-amber-500">
                <label for="editIsActive" class="font-semibold text-gray-700 text-xs cursor-pointer select-none">
                    Status Pesan Aktif
                </label>
            </div>

            <!-- Modal Action Buttons -->
            <div class="pt-4 border-t border-gray-200 flex justify-end gap-2">
                <button type="button" onclick="closeEditModal()" class="py-2.5 px-4 rounded-xl border border-gray-300 text-gray-700 font-semibold text-xs hover:bg-gray-100 transition min-h-[44px]">
                    Batal
                </button>
                <button type="submit" class="py-2.5 px-5 rounded-xl bg-red-800 hover:bg-red-900 text-white font-semibold text-xs transition shadow-sm min-h-[44px]">
                    Perbarui Pesan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openCreateModal() {
        const modal = document.getElementById('createModal');
        modal.classList.remove('hidden');
        setTimeout(() => modal.classList.add('opacity-100'), 50);
    }

    function closeCreateModal() {
        const modal = document.getElementById('createModal');
        modal.classList.remove('opacity-100');
        setTimeout(() => modal.classList.add('hidden'), 300);
    }

    function openEditModal(item) {
        const form = document.getElementById('editForm');
        form.action = `/admin/motivations/${item.id}`;
        document.getElementById('editKategori').value = item.kategori;
        document.getElementById('editPesan').value = item.pesan;
        document.getElementById('editQuote').value = item.quote;
        document.getElementById('editIsActive').checked = Boolean(item.is_active);

        const modal = document.getElementById('editModal');
        modal.classList.remove('hidden');
        setTimeout(() => modal.classList.add('opacity-100'), 50);
    }

    function closeEditModal() {
        const modal = document.getElementById('editModal');
        modal.classList.remove('opacity-100');
        setTimeout(() => modal.classList.add('hidden'), 300);
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeCreateModal();
            closeEditModal();
        }
    });
</script>
@endpush
