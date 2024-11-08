<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use KodePandai\Indonesia\IndonesiaDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            PermissionSeeder::class,
            GenreSeeder::class,
            FilmSeeder::class,
            SettingSeeder::class,
            ReviewSeeder::class,
            FilmCastSeeder::class,
            IndonesiaDatabaseSeeder::class,
            CinemaSeeder::class,
            StudioSeeder::class,
            ShowtimeSeeder::class,
        ]);
    }
}
