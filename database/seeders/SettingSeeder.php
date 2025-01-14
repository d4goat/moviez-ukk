<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
        'name' => 'Matix Cineplex',
        'description' => 'Sebuah Website yang menyediakan fitur pemesanan tiket bioskop secara online',
        'image' => '/images/view-3d-cinema-theatre-room.jpg',
        'logo' => '/images/logo_matix.png',
        'email' => 'cinema51@dmoviez.com',
        'phone' => '0827468638643'
        ]); 
    }
}
