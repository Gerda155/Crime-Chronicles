<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('achievements')->insert([
            [
                'title' => 'Первое дело',
                'description' => 'Заверши своё первое расследование',
                'points' => 10,
            ],
            [
                'title' => 'Детектив-новичок',
                'description' => 'Реши 5 дел',
                'points' => 50,
            ],
            [
                'title' => 'Мастер дедукции',
                'description' => 'Реши 20 дел',
                'points' => 200,
            ],
            [
                'title' => 'Без ошибок',
                'description' => 'Реши дело без неправильных попыток',
                'points' => 75,
            ],
        ]);
    }
}