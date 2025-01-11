<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payments = [
            [
                'booking_id' => 1,
                'amount' => 2 * 50000, // sesuai quantity dan harga show_time
                'status' => 'success',
            ],
            [
                'booking_id' => 2,
                'amount' => 3 * 50000, // sesuai quantity dan harga show_time
                'status' => 'pending',
            ],
            [
                'booking_id' => 3,
                'amount' => 1 * 60000, // sesuai quantity dan harga show_time
                'status' => 'success',
            ],
            [
                'booking_id' => 4,
                'amount' => 4 * 60000, // sesuai quantity dan harga show_time
                'status' => 'failed',
            ],
            [
                'booking_id' => 5,
                'amount' => 2 * 55000, // sesuai quantity dan harga show_time
                'status' => 'success',
            ],
            [
                'booking_id' => 6,
                'amount' => 5 * 55000, // sesuai quantity dan harga show_time
                'status' => 'pending',
            ],
        ];

        foreach($payments as $pay){
            Payment::create($pay);
        }
    }
}
