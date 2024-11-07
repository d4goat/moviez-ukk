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
        $casts =[
            [
                'film_title' => 'Oppenheimer',
                'cast_names' => [
                    'Cillian Murphy',
                    'Emily Blunt',
                    'Robert Downey Jr.',
                    'Matt Damon',
                    'Florence Pugh',
                    'Rami Malek',
                    'Kenneth Branagh'
                ],
            ],
            [
                'film_title' => 'Killers of the Flower Moon',
                'cast_names' => [
                    'Leonardo DiCaprio',
                    'Robert De Niro',
                    'Lily Gladstone',
                    'Jesse Plemons',
                    'Tantoo Cardinal',
                    'Cara Jade Myers',
                    'Janae Collins'
                ],
            ],
            [
                'film_title' => 'The Marvels',
                'cast_names' => [
                    'Brie Larson',
                    'Iman Vellani',
                    'Teyonah Parris',
                    'Zawe Ashton',
                    'Park Seo-joon',
                    'Samuel L. Jackson',
                    'Mohan Kapur'
                ],
            ],
            [
                'film_title' => 'Dune: Part Two',
                'cast_names' => [
                    'Timothée Chalamet',
                    'Zendaya',
                    'Rebecca Ferguson',
                    'Josh Brolin',
                    'Austin Butler',
                    'Florence Pugh',
                    'Christopher Walken'
                ],
            ],
            [
                'film_title' => 'The Creator',
                'cast_names' => [
                    'John David Washington',
                    'Gemma Chan',
                    'Ken Watanabe',
                    'Sturgill Simpson',
                    'Madeleine Yuna Voyles',
                    'Allison Janney',
                    'Ralph Ineson'
                ],
            ],
            [
                'film_title' => 'The Fabelmans',
                'cast_names' => [
                    'Gabriel LaBelle',
                    'Michelle Williams',
                    'Paul Dano',
                    'Seth Rogen',
                    'Judd Hirsch',
                    'Julia Butters',
                    'Keeley Karsten'
                ],
            ],
            [
                'film_title' => 'Blue Beetle',
                'cast_names' => [
                    'Xolo Maridueña',
                    'Adriana Barraza',
                    'Damían Alcázar',
                    'Raoul Max Trujillo',
                    'Susan Sarandon',
                    'George Lopez',
                    'Harvey Guillén'
                ],
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
