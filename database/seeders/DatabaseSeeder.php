<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,      // brak zależności
            UserSeeder::class,          // brak zależności
            ActivitySeeder::class,      // wymaga: Category, User
            ParticipationSeeder::class, // wymaga: Activity, User
            ActivityReportSeeder::class, // wymaga: Activity, User
            UserReportSeeder::class,    // wymaga: User
        ]);
    }
}
