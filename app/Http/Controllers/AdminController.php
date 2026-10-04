<?php

namespace App\Http\Controllers;

use App\Models\Motivation;
use App\Models\Story;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Halaman Dashboard Utama Fasilitator & Statistik.
     */
    public function dashboard()
    {
        $totalStories = Story::count();
        $todayStories = Story::whereDate('created_at', Carbon::today())->count();
        $activeMotivations = Motivation::where('is_active', true)->count();

        // Cari kategori yang paling sering dipilih
        $topCategoryRecord = Story::select('kategori', DB::raw('count(*) as total'))
            ->groupBy('kategori')
            ->orderByDesc('total')
            ->first();
        $topCategory = $topCategoryRecord ? $topCategoryRecord->kategori . ' (' . $topCategoryRecord->total . ')' : 'Belum ada data';

        // Distribusi berdasarkan Jenjang Pendidikan
        $educationList = ['SD', 'SMP', 'SMA', 'MAHASISWA', 'UMUM'];
        $educationCounts = [];
        foreach ($educationList as $edu) {
            $educationCounts[$edu] = Story::where('pendidikan', $edu)->count();
        }

        // Distribusi berdasarkan Kategori Cerita
        $categoryList = ['Diri Sendiri', 'Keluarga', 'Teman', 'Kekasih'];
        $categoryCounts = [];
        foreach ($categoryList as $cat) {
            $categoryCounts[$cat] = Story::where('kategori', $cat)->count();
        }

        // 5 Cerita Terakhir yang Masuk
        $recentStories = Story::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalStories',
            'todayStories',
            'activeMotivations',
            'topCategory',
            'educationCounts',
            'categoryCounts',
            'recentStories'
        ));
    }

    /**
     * Halaman Eksplorasi & Penyaringan Curahan Hati Peserta.
     */
    public function stories(Request $request)
    {
        $query = Story::query()->latest();

        // Filter Pencarian Teks (Nama atau Isi Cerita)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('cerita', 'like', "%{$search}%");
            });
        }

        // Filter Jenjang Pendidikan
        if ($request->filled('pendidikan')) {
            $query->where('pendidikan', $request->input('pendidikan'));
        }

        // Filter Kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->input('kategori'));
        }

        // Filter Tanggal Kegiatan
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->input('date'));
        }

        $stories = $query->paginate(12)->withQueryString();

        return view('admin.stories', compact('stories'));
    }

    /**
     * Hapus satu data cerita peserta.
     */
    public function destroyStory(Story $story)
    {
        $story->delete();

        return redirect()->back()->with('success', 'Data curahan hati berhasil dihapus.');
    }

    /**
     * Halaman Manajemen Bank Pesan Motivasi & Quotes (CRUD).
     */
    public function motivations(Request $request)
    {
        $query = Motivation::query()->latest();

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->input('kategori'));
        }

        $motivations = $query->paginate(12)->withQueryString();

        return view('admin.motivations', compact('motivations'));
    }

    /**
     * Simpan pesan motivasi baru ke bank data.
     */
    public function storeMotivation(Request $request)
    {
        $validated = $request->validate([
            'kategori' => 'required|string|in:Diri Sendiri,Keluarga,Teman,Kekasih',
            'pesan' => 'required|string',
            'quote' => 'required|string',
            'is_active' => 'nullable|boolean',
        ], [
            'kategori.required' => 'Kategori fokus motivasi wajib dipilih.',
            'pesan.required' => 'Kalimat pesan motivasi penguat hati wajib diisi.',
            'quote.required' => 'Kutipan kata bijak / quote wajib diisi.',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;

        Motivation::create($validated);

        return redirect()->back()->with('success', 'Pesan motivasi baru berhasil ditambahkan.');
    }

    /**
     * Perbarui data pesan motivasi yang sudah ada.
     */
    public function updateMotivation(Request $request, Motivation $motivation)
    {
        $validated = $request->validate([
            'kategori' => 'required|string|in:Diri Sendiri,Keluarga,Teman,Kekasih',
            'pesan' => 'required|string',
            'quote' => 'required|string',
            'is_active' => 'nullable|boolean',
        ], [
            'kategori.required' => 'Kategori fokus motivasi wajib dipilih.',
            'pesan.required' => 'Kalimat pesan motivasi penguat hati wajib diisi.',
            'quote.required' => 'Kutipan kata bijak / quote wajib diisi.',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;

        $motivation->update($validated);

        return redirect()->back()->with('success', 'Pesan motivasi berhasil diperbarui.');
    }

    /**
     * Toggle status keaktifan pesan motivasi (Aktif / Nonaktif).
     */
    public function toggleMotivation(Motivation $motivation)
    {
        $motivation->update([
            'is_active' => !$motivation->is_active,
        ]);

        $statusLabel = $motivation->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->back()->with('success', "Pesan motivasi berhasil {$statusLabel}.");
    }

    /**
     * Hapus pesan motivasi dari bank data.
     */
    public function destroyMotivation(Motivation $motivation)
    {
        $motivation->delete();

        return redirect()->back()->with('success', 'Pesan motivasi berhasil dihapus.');
    }
}
