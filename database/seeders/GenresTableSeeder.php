<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenresTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('genres')->insert([
            ['name' => 'Krimināls'],
            ['name' => 'Mistērija'],
            ['name' => 'Thriller'],
            ['name' => 'Drama'],
        ]);
    }
}
