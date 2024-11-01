<?php

namespace Database\Seeders;

use App\Models\Film;
use Illuminate\Database\Seeder;

class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $films = [
            [
                'title' => 'Oppenheimer',
                'description' => 'The story of J. Robert Oppenheimer and his role in the development of the atomic bomb during World War II.',
                'duration' => 180,
                'producer' => 'Emma Thomas',
                'director' => 'Christopher Nolan',
                'writer' => 'Christopher Nolan',
                'poster' => '/images/posters/Oppenheimer.jpg',
                'trailer' => 'https://www.youtube.com/watch?v=bK6ldnjE3Y0',
                'release_date' => '2023-07-21',
                'genre_film_id' => [1, 13], // Drama, Biographical
            ],
            [
                'title' => 'Killers of the Flower Moon',
                'description' => 'Members of the Osage tribe in the United States are murdered under mysterious circumstances in the 1920s, sparking a major FBI investigation.',
                'duration' => 206,
                'producer' => 'Martin Scorsese',
                'director' => 'Martin Scorsese',
                'writer' => 'Eric Roth, Martin Scorsese',
                'poster' => '/images/posters/Killers_of_the_Flower_Moon.jpg',
                'trailer' => 'https://www.youtube.com/watch?v=AWO7NOxnSaE',
                'release_date' => '2023-10-20',
                'genre_film_id' => [1, 12, 17], // Drama, Crime, Mystery
            ],
            [
                'title' => 'The Marvels',
                'description' => 'Captain Marvel, Ms. Marvel, and Monica Rambeau team up to face a powerful intergalactic threat.',
                'duration' => 105,
                'producer' => 'Kevin Feige',
                'director' => 'Nia DaCosta',
                'writer' => 'Megan McDonnell',
                'poster' => '/images/posters/the_marvels.jpeg',
                'trailer' => 'https://www.youtube.com/watch?v=go6GEIrcvFY',
                'release_date' => '2023-11-10',
                'genre_film_id' => [2, 6, 9], // Action, Sci-Fi, Adventure
            ],
            [
                'title' => 'Dune: Part Two',
                'description' => 'Paul Atreides unites with Chani and the Fremen to seek revenge against those who destroyed his family.',
                'duration' => 155,
                'producer' => 'Mary Parent, Denis Villeneuve',
                'director' => 'Denis Villeneuve',
                'writer' => 'Jon Spaihts, Denis Villeneuve',
                'poster' => '/images/posters/dune_part_two.jpg',
                'trailer' => 'https://www.youtube.com/watch?v=8g18jFHCLXk',
                'release_date' => '2023-11-03',
                'genre_film_id' => [6, 9, 1], // Sci-Fi, Adventure, Drama
            ],
        ];

        foreach ($films as $filmData) {
            $film = Film::create([
                'title' => $filmData['title'],
                'description' => $filmData['description'],
                'duration' => $filmData['duration'],
                'producer' => $filmData['producer'],
                'director' => $filmData['director'],
                'writer' => $filmData['writer'],
                'poster' => $filmData['poster'],
                'trailer' => $filmData['trailer'],
                'release_date' => $filmData['release_date'],
            ]);

            $film->genreFilms()->sync($filmData['genre_film_id']);
        }
    }
}
