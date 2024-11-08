<?php

namespace Database\Seeders;

use App\Models\ShowTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShowtimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $showtime = [
            // Oppenheimer
            ['film_id' => 1, 'studio_id' => 1, 'price' => 50000, 'start_time' => '10:00', 'end_time' => '13:00'],
            ['film_id' => 1, 'studio_id' => 2, 'price' => 75000, 'start_time' => '14:00', 'end_time' => '17:00'],

            // Killers of the Flower Moon
            ['film_id' => 2, 'studio_id' => 3, 'price' => 60000, 'start_time' => '11:00', 'end_time' => '14:26'],
            ['film_id' => 2, 'studio_id' => 4, 'price' => 80000, 'start_time' => '15:30', 'end_time' => '18:56'],

            // The Marvels
            ['film_id' => 3, 'studio_id' => 5, 'price' => 55000, 'start_time' => '12:00', 'end_time' => '13:45'],
            ['film_id' => 3, 'studio_id' => 6, 'price' => 70000, 'start_time' => '16:00', 'end_time' => '17:45'],

            // Dune: Part Two
            ['film_id' => 4, 'studio_id' => 7, 'price' => 65000, 'start_time' => '10:30', 'end_time' => '13:05'],
            ['film_id' => 4, 'studio_id' => 8, 'price' => 90000, 'start_time' => '14:30', 'end_time' => '17:05'],

            // The Creator
            ['film_id' => 5, 'studio_id' => 9, 'price' => 60000, 'start_time' => '11:30', 'end_time' => '13:43'],
            ['film_id' => 5, 'studio_id' => 10, 'price' => 85000, 'start_time' => '15:00', 'end_time' => '17:13'],

            // The Fabelmans
            ['film_id' => 6, 'studio_id' => 1, 'price' => 50000, 'start_time' => '09:30', 'end_time' => '11:41'],
            ['film_id' => 6, 'studio_id' => 2, 'price' => 75000, 'start_time' => '13:00', 'end_time' => '15:11'],

            // Blue Beetle
            ['film_id' => 7, 'studio_id' => 3, 'price' => 55000, 'start_time' => '10:00', 'end_time' => '12:07'],
            ['film_id' => 7, 'studio_id' => 4, 'price' => 80000, 'start_time' => '14:00', 'end_time' => '16:07'],
        ];

        foreach ($showtime as $value){
            ShowTime::create($value);
        } 
    }
}
