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
        $this->call([
            GenresSeeder::class,
            RangsSeeder::class,
            AchievementsSeeder::class,
            UsersSeeder::class,
            CasesSeeder::class,
            SuspectsSeeder::class,
            EvidenceSeeder::class,
            QuestionsSeeder::class,
            AchievementUserSeeder::class,
            PlayerAttemptsSeeder::class,
            RatingsSeeder::class,
            UserProgressSeeder::class,
            ActivityLogsSeeder::class,
        ]);
    }
}