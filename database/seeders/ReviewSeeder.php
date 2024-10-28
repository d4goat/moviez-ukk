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
        Review::create([
            'user_id' => 1,
            'film_id' => 1,
            'review' => 'Sangat Bagus',
            'rating' => 5
        ]);
        Review::create([
            'user_id' => 2,
            'film_id' => 1,
            'review' => 'Lumayan',
            'rating' => 4.1
        ]);
    }
}
