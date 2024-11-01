<?php

namespace Database\Seeders;

use App\Models\Film;
use App\Models\FilmCast;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FilmCastSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $casts = [
            [
                'film_title' => 'Oppenheimer',
                'cast_names' => ['Cillian Murphy', 'Emily Blunt', 'Robert Downey Jr.', 'Matt Damon'],
            ],
            [
                'film_title' => 'Barbie',
                'cast_names' => ['Margot Robbie', 'Ryan Gosling', 'America Ferrera', 'Simu Liu'],
            ],
            [
                'film_title' => 'Killers of the Flower Moon',
                'cast_names' => ['Leonardo DiCaprio', 'Robert De Niro', 'Lily Gladstone', 'Jesse Plemons'],
            ],
            [
                'film_title' => 'The Marvels',
                'cast_names' => ['Brie Larson', 'Iman Vellani', 'Teyonah Parris', 'Zawe Ashton'],
            ],
            [
                'film_title' => 'Dune: Part Two',
                'cast_names' => ['Timothée Chalamet', 'Zendaya', 'Rebecca Ferguson', 'Josh Brolin'],
            ],
        ];

        foreach ($casts as $castData) {
            $film = Film::where('title', $castData['film_title'])->first();

            if ($film) {
                foreach ($castData['cast_names'] as $name) {
                    FilmCast::create([
                        'cast_name' => $name,
                        'film_id' => $film->id,
                    ]);
                }
            }
        }
    }
}
