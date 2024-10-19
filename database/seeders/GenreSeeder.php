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
        ];

        foreach ($genres as $genre) {
            Genre::create($genre);
        }
    }
}
