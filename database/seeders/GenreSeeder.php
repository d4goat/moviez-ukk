<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            // Genre Utama yang Sudah Ada
            [
                'name' => 'Drama',
                'description' => 'Genre yang fokus pada pengembangan karakter dan emosi, mengeksplorasi konflik internal atau hubungan antar karakter.'
            ],
            [
                'name' => 'Action',
                'description' => 'Genre yang menekankan pada adegan intens seperti perkelahian, kejar-kejaran, dan tantangan fisik yang ekstrem.'
            ],
            [
                'name' => 'Comedy',
                'description' => 'Genre yang dirancang untuk membuat penonton tertawa dengan situasi lucu, dialog cerdas, atau perilaku karakter yang aneh dan konyol.'
            ],
            [
                'name' => 'Romance',
                'description' => 'Genre yang fokus pada hubungan cinta antara karakter utama, mengeksplorasi kebahagiaan, konflik, dan kesedihan dalam percintaan.'
            ],
            [
                'name' => 'Horror',
                'description' => 'Genre yang dirancang untuk menimbulkan rasa takut, kecemasan, atau ketegangan, sering kali dengan unsur supernatural atau makhluk mengerikan.'
            ],
            [
                'name' => 'Sci-Fi',
                'description' => 'Genre yang menggabungkan elemen ilmiah dan teknologi futuristik, alien, atau perjalanan ruang angkasa.'
            ],
            [
                'name' => 'Fantasy',
                'description' => 'Genre yang menghadirkan dunia imajinatif dengan sihir, makhluk mitologi, dan peristiwa supranatural.'
            ],
            [
                'name' => 'Thriller',
                'description' => 'Genre yang menimbulkan ketegangan dan ketidakpastian, sering berpusat pada konspirasi, kejahatan, atau situasi berbahaya.'
            ],
            [
                'name' => 'Adventure',
                'description' => 'Genre yang fokus pada eksplorasi atau perjalanan, dengan tantangan besar yang harus dihadapi karakter dalam pencarian atau misi tertentu.'
            ],
            [
                'name' => 'Musical',
                'description' => 'Genre yang menggabungkan elemen naratif dengan musik dan tarian sebagai bagian dari penceritaan.'
            ],
            [
                'name' => 'Documentary',
                'description' => 'Genre yang berfokus pada fakta dan peristiwa nyata, sering memberikan wawasan tentang topik tertentu atau profil orang-orang signifikan.'
            ],

            // Genre Tambahan
            [
                'name' => 'Crime',
                'description' => 'Genre yang berfokus pada aktivitas kriminal, investigasi, dan dinamika dunia kejahatan.'
            ],
            [
                'name' => 'Biographical',
                'description' => 'Genre yang menceritakan kisah nyata seseorang yang terkenal atau memiliki pengaruh signifikan.'
            ],
            [
                'name' => 'Western',
                'description' => 'Genre yang berlatar belakang Amerika Serikat abad ke-19, menampilkan koboi, pengembara, dan konflik di wilayah barat.'
            ],
            [
                'name' => 'Animated',
                'description' => 'Genre film yang dibuat dengan teknik animasi, baik 2D maupun 3D, untuk semua kelompok umur.'
            ],
            [
                'name' => 'Mystery',
                'description' => 'Genre yang berfokus pada pemecahan teka-teki atau rahasia, dengan plot yang penuh misteri dan kejutan.'
            ],
            [
                'name' => 'War',
                'description' => 'Genre yang mengeksplorasi konflik perang, perjuangan, dan dampak psikologis pertempuran.'
            ],
            [
                'name' => 'Historical',
                'description' => 'Genre yang berlatar belakang periode sejarah tertentu, menggambarkan peristiwa, budaya, dan suasana masa lalu.'
            ],
            [
                'name' => 'Psychological',
                'description' => 'Genre yang mendalami kondisi mental, konflik internal, dan dinamika psikologis karakter.'
            ],
            [
                'name' => 'Supernatural',
                'description' => 'Genre yang menghadirkan elemen di luar logika dan hukum alam, seperti hantu, kekuatan gaib, atau fenomena metafisik.'
            ],
            [
                'name' => 'Family',
                'description' => 'Genre yang dirancang untuk ditonton oleh seluruh anggota keluarga, dengan pesan moral dan hiburan yang sesuai.'
            ],
            [
                'name' => 'Sport',
                'description' => 'Genre yang berfokus pada olahraga, atlet, dan perjuangan mencapai kesuksesan dalam kompetisi.'
            ],
            [
                'name' => 'Disaster',
                'description' => 'Genre yang menampilkan bencana alam atau buatan manusia dan upaya bertahan hidup para karakter.'
            ],
            [
                'name' => 'Post-Apocalyptic',
                'description' => 'Genre yang berlatar belakang dunia setelah terjadinya bencana besar yang memusnahkan sebagian besar peradaban.'
            ],
            [
                'name' => 'Spy',
                'description' => 'Genre yang mengeksplorasi dunia mata-mata, intrik, dan misi rahasia.'
            ]
        ];

        foreach ($genres as $genre) {
            Genre::create($genre);
        }
    }
}