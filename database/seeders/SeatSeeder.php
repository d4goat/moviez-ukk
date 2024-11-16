<?php

namespace Database\Seeders;

use App\Models\Seats;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $studios = range(1, 11); // Studio ID dari 1 sampai 11
        $rows = ['A', 'B', 'C', 'D', 'E', 'F', 'G']; // Baris kursi
        $seatPerRow = 20; // Jumlah kursi per baris

        foreach ($studios as $studioId) {
            foreach ($rows as $row) {
                for ($i = 1; $i <= $seatPerRow; $i++) {
                    $seatNumber = $row . $i;

                    Seats::create([
                        'seat_number' => $seatNumber,
                        'studio_id' => $studioId
                    ]);
                }
            }
        }
    }
}
