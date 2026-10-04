<?php

namespace Database\Seeders;

use App\Models\Motivation;
use Illuminate\Database\Seeder;

class MotivationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $motivations = [
            // Kategori Diri Sendiri
            [
                'kategori' => 'Diri Sendiri',
                'pesan' => 'Kamu ga sendirian kok, {NAMA}. Tidak apa-apa untuk merasa lelah saat memperjuangkan banyak hal sendirian. Izinkan dirimu beristirahat sejenak dari ekspektasi dunia. Ingatlah bahwa versi dirimu yang sekarang sudah berjuang luar biasa hebat. Kembali melangkah pelan-pelan saat kamu sudah siap. LESTARI selalu ada untuk menemani langkahmu! ✨',
                'quote' => 'Mencintai dan menghargai diri sendiri adalah awal dari proses penyembuhan yang paling indah.',
                'is_active' => true,
            ],
            [
                'kategori' => 'Diri Sendiri',
                'pesan' => 'Halo {NAMA}, setiap perjalanan hidup memiliki ritmenya masing-masing. Jangan bandingkan prosesmu dengan orang lain. Tarik napas dalam-dalam, hargai usahamu hari ini, dan percayalah kamu sedang bertumbuh menjadi pribadi yang jauh lebih tangguh! 🌱',
                'quote' => 'Kesabaran dan kelembutan pada diri sendiri adalah kekuatan sejati.',
                'is_active' => true,
            ],
            [
                'kategori' => 'Diri Sendiri',
                'pesan' => 'Untuk {NAMA}, perasaan cemas dan ragu adalah hal yang sangat manusiawi. Kamu tidak harus menyelesaikan semua beban sekaligus hari ini. Cukup selesaikan hari ini dengan baik dan berterima kasihlah pada tubuh serta jiwamu. Kamu sangat berharga! 💫',
                'quote' => 'Kamu berharga bukan semata karena apa yang kamu capai, melainkan karena keberanianmu untuk terus bangkit.',
                'is_active' => true,
            ],

            // Kategori Keluarga
            [
                'kategori' => 'Keluarga',
                'pesan' => 'Halo {NAMA}, dinamika dengan keluarga memang terkadang menjadi ujian yang paling menyentuh hati. Ingatlah bahwa kamu tidak bisa mengontrol semua hal, tetapi kamu berhak menjaga ketenangan pikiranmu sendiri. Teruslah berbuat baik dengan batasan yang sehat. Kamu adalah sosok yang tangguh dan penuh kasih sayang! ✨',
                'quote' => 'Rumah terbaik adalah kedamaian yang kamu ciptakan di dalam hatimu sendiri.',
                'is_active' => true,
            ],
            [
                'kategori' => 'Keluarga',
                'pesan' => 'Dear {NAMA}, setiap keluarga memiliki ceritanya masing-masing, lengkap dengan lika-liku dan kehangatannya. Jangan biarkan ekspektasi berlebih membebani langkahmu. Tetaplah menjadi versi terbaik dirimu dengan hati yang tulus dan lapang. 🏡',
                'quote' => 'Kedamaian sejati bermula saat kita menerima hal-hal di luar kendali kita dengan lapang dada.',
                'is_active' => true,
            ],

            // Kategori Teman
            [
                'kategori' => 'Teman',
                'pesan' => 'Untuk {NAMA}, pertemanan dan hubungan sosial memang memiliki pasang surutnya. Jangan biarkan kekecewaan membuatmu ragu akan ketulusan hatimu. Orang-orang yang tepat akan selalu menghargai kehadiranmu apa adanya. Tetaplah menjadi pribadi yang hangat dan jujur pada dirimu sendiri! ✨',
                'quote' => 'Kualitas hubungan jauh lebih bermakna daripada kuantitas lingkaran pertemanan.',
                'is_active' => true,
            ],
            [
                'kategori' => 'Teman',
                'pesan' => 'Halo {NAMA}, pertemanan yang sehat adalah tempat di mana kamu merasa aman untuk menjadi dirimu seutuhnya. Jika ada yang mengecewakanmu, ambil hikmahnya untuk merawat batasan diri. Kamu pantas dikelilingi orang-orang yang tulus saling mendukung! 🤝',
                'quote' => 'Lingkari dirimu dengan orang-orang yang menyalakan semangat kebaikan dan ketenangan jiwamu.',
                'is_active' => true,
            ],

            // Kategori Kekasih
            [
                'kategori' => 'Kekasih',
                'pesan' => 'Dear {NAMA}, urusan perasaan dan pasangan memang membutuhkan kelapangan dada yang besar. Dengarkan suara hatimu, komunikasikan apa yang kamu rasakan, atau beri jeda untuk saling memahami. Cinta yang sehat selalu memberikan rasa aman, bukan kecemasan yang berlarut. Kamu layak mendapatkan kedamaian cinta! ✨',
                'quote' => 'Cinta sejati selalu bertumbuh bersama rasa saling menghormati dan ketenangan jiwa.',
                'is_active' => true,
            ],
            [
                'kategori' => 'Kekasih',
                'pesan' => 'Halo {NAMA}, cinta yang tulus tidak akan membuatmu kehilangan jati dirimu sendiri. Jika hatimu sedang bimbang atau terluka, peluklah dirimu terlebih dahulu. Ingat bahwa kamu berharga dan pantas dicintai dengan penuh ketulusan dan penghormatan. 💖',
                'quote' => 'Kejujuran dan rasa aman adalah pondasi terindah dalam sebuah hubungan.',
                'is_active' => true,
            ],
        ];

        foreach ($motivations as $item) {
            Motivation::firstOrCreate(
                [
                    'kategori' => $item['kategori'],
                    'pesan' => $item['pesan'],
                ],
                [
                    'quote' => $item['quote'],
                    'is_active' => $item['is_active'],
                ]
            );
        }
    }
}
