<?php

namespace Database\Seeders;

use App\Models\Booking;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bookings = [
            [
                'tanggal' => '2024-12-01',
                'quantity' => 2,
                'total_price' => 2 * 50000, // 2 tiket x 50,000
                'invoice_number' => 'INV-0001',
                'user_id' => 1,
                'show_time_id' => 1,
            ],
            [
                'tanggal' => '2024-12-02',
                'quantity' => 3,
                'total_price' => 3 * 50000, // 3 tiket x 50,000
                'invoice_number' => 'INV-0002',
                'user_id' => 2,
                'show_time_id' => 2,
            ],
            [
                'tanggal' => '2024-12-03',
                'quantity' => 1,
                'total_price' => 1 * 60000, // 1 tiket x 60,000
                'invoice_number' => 'INV-0003',
                'user_id' => 2,
                'show_time_id' => 3,
            ],
            [
                'tanggal' => '2024-12-04',
                'quantity' => 4,
                'total_price' => 4 * 60000, // 4 tiket x 60,000
                'invoice_number' => 'INV-0004',
                'user_id' => 2,
                'show_time_id' => 4,
            ],
            [
                'tanggal' => '2024-12-05',
                'quantity' => 2,
                'total_price' => 2 * 55000, // 2 tiket x 55,000
                'invoice_number' => 'INV-0005',
                'user_id' => 2,
                'show_time_id' => 5,
            ],
            [
                'tanggal' => '2024-12-06',
                'quantity' => 5,
                'total_price' => 5 * 55000, // 5 tiket x 55,000
                'invoice_number' => 'INV-0006',
                'user_id' => 2,
                'show_time_id' => 6,
            ],
        ];

        foreach($bookings as $book){
            Booking::create($book);
        }
    }
}
