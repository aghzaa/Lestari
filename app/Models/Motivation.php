<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motivation extends Model
{
    use HasFactory;

    protected $table = 'motivations';

    protected $fillable = [
        'kategori',
        'pesan',
        'quote',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope to only active motivations
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get a random motivation entry by category and personalize the name
     */
    public static function getRandomByCategory(string $kategori, string $nama = 'Sahabat'): array
    {
        $item = self::active()
            ->where('kategori', $kategori)
            ->inRandomOrder()
            ->first();

        if ($item) {
            $pesan = str_replace('{NAMA}', $nama, $item->pesan);
            return [
                'pesan' => $pesan,
                'quote' => $item->quote,
                'id' => $item->id,
            ];
        }

        // Fallback default message if database empty for this category
        $fallbackQuotes = [
            'Diri Sendiri' => [
                'pesan' => "Kamu ga sendirian kok, {$nama}. Tidak apa-apa untuk merasa lelah saat memperjuangkan banyak hal. Izinkan dirimu beristirahat sejenak dari ekspektasi dunia. Ingatlah bahwa versi dirimu yang sekarang sudah berjuang luar biasa hebat. LESTARI selalu ada untuk menemani langkahmu! ✨",
                'quote' => "Mencintai dan menghargai diri sendiri adalah awal dari proses penyembuhan yang paling indah."
            ],
            'Keluarga' => [
                'pesan' => "Halo {$nama}, dinamika dengan keluarga memang terkadang menjadi ujian yang paling menyentuh hati. Ingatlah bahwa kamu tidak bisa mengontrol semua hal, tetapi kamu berhak menjaga ketenangan pikiranmu sendiri. Teruslah berbuat baik dengan batasan yang sehat. Kamu sosok yang tangguh! ✨",
                'quote' => "Rumah terbaik adalah kedamaian yang kamu ciptakan di dalam hatimu sendiri."
            ],
            'Teman' => [
                'pesan' => "Untuk {$nama}, pertemanan dan hubungan sosial memang memiliki pasang surutnya. Jangan biarkan rasa kecewa membuatmu ragu akan ketulusan hatimu. Orang-orang yang tepat akan selalu menghargai kehadiranmu apa adanya! ✨",
                'quote' => "Kualitas hubungan jauh lebih bermakna daripada kuantitas lingkaran pertemanan."
            ],
            'Kekasih' => [
                'pesan' => "Dear {$nama}, urusan perasaan dan pasangan memang membutuhkan kelapangan dada yang besar. Dengarkan suara hatimu atau beri jeda untuk saling memahami. Cinta yang sehat selalu memberikan rasa aman, bukan kecemasan yang berlarut! ✨",
                'quote' => "Cinta sejati selalu bertumbuh bersama rasa saling menghormati dan ketenangan jiwa."
            ],
        ];

        $default = $fallbackQuotes[$kategori] ?? $fallbackQuotes['Diri Sendiri'];
        return [
            'pesan' => $default['pesan'],
            'quote' => $default['quote'],
            'id' => null,
        ];
    }
}
