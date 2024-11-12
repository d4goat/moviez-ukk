<?php

namespace Database\Seeders;

use App\Models\ShowTime;
use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShowtimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $films = [
            ['film_id' => 1, 'duration' => 180],
            ['film_id' => 2, 'duration' => 206],
            ['film_id' => 3, 'duration' => 105],
            ['film_id' => 4, 'duration' => 155],
            ['film_id' => 5, 'duration' => 133],
            ['film_id' => 6, 'duration' => 151],
            ['film_id' => 7, 'duration' => 127],
        ];
        
        $filmsData = [];
        foreach ($films as $film) {
            $filmsData[$film['film_id']] = $film['duration'];
        }
        
        $showtime = [
            ['film_id' => 1, 'studio_id' => 1, 'price' => 50000, 'start_time' => '10:00'],
            ['film_id' => 1, 'studio_id' => 1, 'price' => 50000, 'start_time' => '13:15'],
            ['film_id' => 2, 'studio_id' => 4, 'price' => 60000, 'start_time' => '11:00'],
            ['film_id' => 2, 'studio_id' => 4, 'price' => 60000, 'start_time' => '14:30'],
            ['film_id' => 3, 'studio_id' => 6, 'price' => 55000, 'start_time' => '12:00'],
            ['film_id' => 3, 'studio_id' => 6, 'price' => 55000, 'start_time' => '14:00'],
            ['film_id' => 4, 'studio_id' => 8, 'price' => 65000, 'start_time' => '10:30'],
            ['film_id' => 4, 'studio_id' => 8, 'price' => 65000, 'start_time' => '13:10'],
            ['film_id' => 5, 'studio_id' => 10, 'price' => 60000, 'start_time' => '11:30'],
            ['film_id' => 5, 'studio_id' => 10, 'price' => 60000, 'start_time' => '13:45'],
            ['film_id' => 6, 'studio_id' => 2, 'price' => 45000, 'start_time' => '11:30'],
            ['film_id' => 6, 'studio_id' => 2, 'price' => 45000, 'start_time' => '14:10'],
            ['film_id' => 7, 'studio_id' => 3, 'price' => 45000, 'start_time' => '11:00'],
            ['film_id' => 7, 'studio_id' => 3, 'price' => 45000, 'start_time' => '13:15'],
        ];
        
        function calculateEndTime($startTime, $duration) {
            $startDateTime = new DateTime($startTime);
            $startDateTime->modify("+{$duration} minutes");
            return $startDateTime->format('H:i');
        }
        
        foreach ($showtime as &$value) {
            $filmId = $value['film_id'];
            $duration = $filmsData[$filmId];
            $startTime = $value['start_time'];
            $value['end_time'] = calculateEndTime($startTime, $duration);
        }
        
        foreach ($showtime as $value) {
            ShowTime::create($value);
        }
        
    }
}
