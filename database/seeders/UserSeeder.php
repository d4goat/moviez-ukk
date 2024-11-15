<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@matix.cineplex.com',
            'password' => bcrypt('holy@shit'),
            'phone' => '08876245653',
        ])->assignRole('admin');

        User::create([
            'name' => 'User',
            'email' => 'user@matix.com',
            'password' => bcrypt('12345678'),
            'phone' => '08876845653',
        ])->assignRole('user');
    }
}
