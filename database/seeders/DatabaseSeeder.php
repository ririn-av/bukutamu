<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil AdminSeeder agar data admin otomatis terbuat
        $this->call([
            AdminSeeder::class,
        ]);
    }
}