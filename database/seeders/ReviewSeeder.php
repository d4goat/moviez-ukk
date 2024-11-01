<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Review::updateOrCreate([
            'user_id' => 1,
            'film_id' => 1,
            'review' => 'Sangat Bagus',
            'rating' => 5
        ]);
        Review::updateOrCreate([
            'user_id' => 2,
            'film_id' => 1,
            'review' => 'Lumayan',
            'rating' => 4.1
        ]);
        Review::updateOrCreate([
            'user_id' => 1,
            'film_id' => 2,
            'review' => 'NAISSS',
            'rating' => 4.4
        ]);
        Review::updateOrCreate([
            'user_id' => 2,
            'film_id' => 2,
            'review' => 'GLOOKK',
            'rating' => 4.9
        ]);
    }
}
