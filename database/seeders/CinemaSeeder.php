<?php

namespace Database\Seeders;

use App\Models\Cinema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CinemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cinemas = [
            [
                'name' => 'Cinema XXI Tunjungan Plaza',
                'city' =>  3578,
                'address' => 'Jl. Basuki Rahmat No.8-12, Surabaya, Jawa Timur',
            ],
            [
                'name' => 'CGV Marvell City',
                'city' =>  3578,
                'address' => 'Jl. Ngagel No.123, Surabaya, Jawa Timur',
            ],
            [
                'name' => 'Cinepolis East Coast Center',
                'city' =>  3578,
                'address' => 'Jl. Dr. Ir. H. Soekarno, Mulyorejo, Surabaya, Jawa Timur',
            ],
            [
                'name' => 'Cinema XXI Galaxy Mall',
                'city' =>  3578,
                'address' => 'Jl. Dharmahusada Indah Timur No.37, Surabaya, Jawa Timur',
            ],
            [
                'name' => 'CGV BG Junction',
                'city' =>  3578,
                'address' => 'Jl. Bubutan No.1-7, Surabaya, Jawa Timur',
            ]
        ];

        foreach($cinemas as $cinema){
            Cinema::create($cinema);
        }
    }
}
