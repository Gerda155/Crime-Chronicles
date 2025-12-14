<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EvidenceTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('evidence')->insert([
            [
                'case_id' => 1,
                'description' => 'Bildes ar pierādījumu nr.1',
                'image_path' => 'evidence1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'case_id' => 1,
                'description' => 'Aizdomīgā personas apraksts',
                'image_path' => 'suspect1.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'case_id' => 2,
                'description' => 'Kamera notikuma vietā',
                'image_path' => 'evidence2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
