<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('genres')->insert([
            ['name' => 'Misticisms'],
            ['name' => 'Slepkavība'],
            ['name' => 'Zādzība'],
            ['name' => 'Korupcija'],
            ['name' => 'Pazudusi persona'],
            ['name' => 'Psiholoģiskais trilleris'],
            ['name' => 'Vēsturiskais trilleris'],
            ['name' => 'Kriminālsatīra'],
            ['name' => 'Krimināldrāma'],
        ]);
    }
}