<?php

namespace App\Http\Controllers;

use App\Models\Motivation;
use App\Models\Story;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoryController extends Controller
{
    /**
     * Tampilkan antarmuka publik Ruang Cerita & Motivasi LESTARI.
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Simpan cerita narasumber dan kirimkan respons motivasi terpersonalisasi.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'umur' => 'required|integer|min:5|max:120',
            'jenis_kelamin' => 'required|string|in:Pria,Wanita',
            'pendidikan' => 'required|string|in:SD,SMP,SMA,MAHASISWA,UMUM',
            'kategori' => 'required|string|in:Diri Sendiri,Keluarga,Teman,Kekasih',
            'cerita' => 'required|string|min:10|max:500',
        ], [
            'nama.required' => 'Nama lengkap atau panggilan wajib diisi.',
            'umur.required' => 'Umur wajib diisi dengan angka yang valid.',
            'umur.min' => 'Umur minimal adalah 5 tahun.',
            'umur.max' => 'Umur maksimal adalah 120 tahun.',
            'jenis_kelamin.required' => 'Silakan pilih jenis kelamin Anda.',
            'pendidikan.required' => 'Silakan pilih jenjang pendidikan Anda.',
            'kategori.required' => 'Fokus kategori cerita wajib dipilih.',
            'cerita.required' => 'Tuliskan sedikit keluhan atau curahan hatimu.',
            'cerita.min' => 'Cerita minimal berisi 10 karakter agar kami dapat memahami perasaanmu dengan baik.',
            'cerita.max' => 'Curahan hati dibatasi maksimal 500 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        // Ambil kutipan motivasi dan kata bijak dinamis
        $motivationData = Motivation::getRandomByCategory(
            $validated['kategori'],
            $validated['nama']
        );

        // Rekam data cerita narasumber ke basis data MySQL
        $story = Story::create([
            'nama' => $validated['nama'],
            'umur' => $validated['umur'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'pendidikan' => $validated['pendidikan'],
            'kategori' => $validated['kategori'],
            'cerita' => $validated['cerita'],
            'motivation_text' => $motivationData['pesan'],
            'quote_text' => $motivationData['quote'],
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cerita berhasil didengarkan oleh LESTARI.',
            'data' => [
                'id' => $story->id,
                'nama' => $story->nama,
                'kategori' => $story->kategori,
                'pesan' => $motivationData['pesan'],
                'quote' => $motivationData['quote'],
            ],
        ], 201);
    }
}
