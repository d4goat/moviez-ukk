<?php

namespace Database\Seeders;

use App\Models\Film;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Film::create([
            'title' => 'The Matrix',
            'description' => 'A computer hacker learns about the true nature of reality and his role in the war against its controllers.',
            'duration' => 136,
            'producer' => 'Joel Silver',
            'director' => 'The Wachowskis',
            'writer' => 'The Wachowskis',
            'poster' => 'posters/matrix.jpg',
            'trailer' => 'https://www.youtube.com/watch?v=vKQi3bBA1y8',
            'release_date' => '1999-03-31',
        ]);

        Film::create([
            'title' => 'Inception',
            'description' => 'A thief who steals corporate secrets through the use of dream-sharing technology is given the inverse task of planting an idea into the mind of a C.E.O.',
            'duration' => 148,
            'producer' => 'Emma Thomas',
            'director' => 'Christopher Nolan',
            'writer' => 'Christopher Nolan',
            'poster' => 'posters/inception.jpg',
            'trailer' => 'https://www.youtube.com/watch?v=8hP9D6kZseM',
            'release_date' => '2010-07-16',
        ]);
    }
}
