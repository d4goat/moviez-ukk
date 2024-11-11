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
        
        // Mengubah array films menjadi associative array untuk akses lebih mudah
        $filmsData = [];
        foreach ($films as $film) {
            $filmsData[$film['film_id']] = $film['duration'];
        }
        
        // Data showtime awal
        $showtime = [
            ['film_id' => 1, 'studio_id' => 1, 'price' => 50000, 'start_time' => '10:00'],
            ['film_id' => 2, 'studio_id' => 3, 'price' => 60000, 'start_time' => '11:00'],
            ['film_id' => 3, 'studio_id' => 5, 'price' => 55000, 'start_time' => '12:00'],
            ['film_id' => 4, 'studio_id' => 7, 'price' => 65000, 'start_time' => '10:30'],
            ['film_id' => 5, 'studio_id' => 9, 'price' => 60000, 'start_time' => '11:30'],
            ['film_id' => 6, 'studio_id' => 1, 'price' => 50000, 'start_time' => '09:30'],
            ['film_id' => 7, 'studio_id' => 3, 'price' => 55000, 'start_time' => '10:00'],
        ];
        
        // Fungsi untuk menghitung waktu berakhir (end_time)
        function calculateEndTime($startTime, $duration) {
            // Mengonversi waktu mulai menjadi objek DateTime
            $startDateTime = new DateTime($startTime);
            // Menambahkan durasi film (dalam menit)
            $startDateTime->modify("+{$duration} minutes");
            // Mengembalikan waktu berakhir dalam format 'H:i'
            return $startDateTime->format('H:i');
        }
        
        // Menambahkan end_time ke data showtime
        foreach ($showtime as &$value) {
            $filmId = $value['film_id'];
            $duration = $filmsData[$filmId];
            $startTime = $value['start_time'];
            // Menghitung end_time berdasarkan durasi film
            $value['end_time'] = calculateEndTime($startTime, $duration);
        }
        
        foreach ($showtime as $value) {
            ShowTime::create($value);
        }
        
    }
}
