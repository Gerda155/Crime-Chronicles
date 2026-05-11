<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('cases')->insert([
            [
                'title' => 'Исчезновение в отеле',
                'description' => 'Гость пропал ночью без следа',
                'genre_id' => 5,
            ],
            [
                'title' => 'Кража в музее',
                'description' => 'Украдено редкое произведение искусства',
                'genre_id' => 3,
            ],
            [
                'title' => 'Тайна старого дома',
                'description' => 'Жильцы слышат странные звуки по ночам',
                'genre_id' => 1,
            ],
        ]);
    }
}