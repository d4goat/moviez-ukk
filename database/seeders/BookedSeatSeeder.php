<?php

namespace Database\Seeders;

use App\Models\BookedSeat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookedSeatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bookedSeats = [
            [
                'booking_id' => 1, // Booking pertama (1 tiket per entri)
                'seat_id' => 1, // Kursi studio 1 (show_time_id: 1)
            ],
            [
                'booking_id' => 1,
                'seat_id' => 2, // Kursi studio 1 (show_time_id: 1)
            ],
            [
                'booking_id' => 2, // Booking kedua (1 tiket per entri)
                'seat_id' => 61, // Kursi studio 1 (show_time_id: 2)
            ],
            [
                'booking_id' => 2,
                'seat_id' => 62, // Kursi studio 1 (show_time_id: 2)
            ],
            [
                'booking_id' => 2,
                'seat_id' => 63, // Kursi studio 1 (show_time_id: 2)
            ],
            [
                'booking_id' => 3, // Booking ketiga (1 tiket per entri)
                'seat_id' => 201, // Kursi studio 4 (show_time_id: 3)
            ],
            [
                'booking_id' => 4, // Booking keempat (1 tiket per entri)
                'seat_id' => 221, // Kursi studio 4 (show_time_id: 4)
            ],
            [
                'booking_id' => 4,
                'seat_id' => 222, // Kursi studio 4 (show_time_id: 4)
            ],
            [
                'booking_id' => 4,
                'seat_id' => 223, // Kursi studio 4 (show_time_id: 4)
            ],
            [
                'booking_id' => 4,
                'seat_id' => 224, // Kursi studio 4 (show_time_id: 4)
            ],
            [
                'booking_id' => 5, // Booking kelima (1 tiket per entri)
                'seat_id' => 361, // Kursi studio 6 (show_time_id: 5)
            ],
            [
                'booking_id' => 5,
                'seat_id' => 362, // Kursi studio 6 (show_time_id: 5)
            ],
            [
                'booking_id' => 6, // Booking keenam (1 tiket per entri)
                'seat_id' => 381, // Kursi studio 6 (show_time_id: 6)
            ],
            [
                'booking_id' => 6,
                'seat_id' => 382, // Kursi studio 6 (show_time_id: 6)
            ],
            [
                'booking_id' => 6,
                'seat_id' => 383, // Kursi studio 6 (show_time_id: 6)
            ],
            [
                'booking_id' => 6,
                'seat_id' => 384, // Kursi studio 6 (show_time_id: 6)
            ],
            [
                'booking_id' => 6,
                'seat_id' => 385, // Kursi studio 6 (show_time_id: 6)
            ],
        ];

        foreach ($bookedSeats as $data) {
                BookedSeat::create([
                    'booking_id' => $data['booking_id'],
                    'seat_id' => $data['seat_id'],
                ]);
        }
    }
}
