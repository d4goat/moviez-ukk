<?php

namespace Database\Seeders;

use App\Models\Studio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $studios = [
            ['name' => 'Studio 1', 'cinema_id' => 1],
            ['name' => 'Studio 2', 'cinema_id' => 1],
            ['name' => 'Studio 3', 'cinema_id' => 1],

            ['name' => 'Studio Atmos', 'cinema_id' => 2],
            ['name' => 'Studio Gold Class', 'cinema_id' => 2],

            ['name' => 'Studio Regular', 'cinema_id' => 3],
            ['name' => 'Studio VIP', 'cinema_id' => 3],

            ['name' => 'Studio Deluxe', 'cinema_id' => 4],
            ['name' => 'Studio Premiere', 'cinema_id' => 4],

            ['name' => 'Studio 4DX', 'cinema_id' => 5],
            ['name' => 'Studio Sweetbox', 'cinema_id' => 5]
        ];

        foreach($studios as $studio) {
            Studio::create($studio);
        }
    }
}
