<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RangsSeeder extends Seeder
{
    public function run()
    {
        $rangs = [
            ['name' => 'Iesācējs', 'min_score' => 0, 'max_score' => 99, 'status' => 'active', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Meklētājs', 'min_score' => 100, 'max_score' => 249, 'status' => 'active', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Izmeklētājs', 'min_score' => 250, 'max_score' => 499, 'status' => 'active', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Detektīvs', 'min_score' => 500, 'max_score' => 999, 'status' => 'active', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Vecākais detektīvs', 'min_score' => 1000, 'max_score' => 1999, 'status' => 'active', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Kriminālists', 'min_score' => 2000, 'max_score' => 3499, 'status' => 'active', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Slepenais aģents', 'min_score' => 3500, 'max_score' => 5499, 'status' => 'active', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Noziegumu analītiķis', 'min_score' => 5500, 'max_score' => 7999, 'status' => 'active', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Elites izmeklētājs', 'min_score' => 8000, 'max_score' => 11999, 'status' => 'active', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Leģendārais detektīvs', 'min_score' => 12000, 'max_score' => 19999, 'status' => 'active', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Ēnu meistars', 'min_score' => 20000, 'max_score' => 34999, 'status' => 'active', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Hroniku sargs', 'min_score' => 35000, 'max_score' => 99999, 'status' => 'active', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        
        DB::table('rangs')->insert($rangs);
    }
}