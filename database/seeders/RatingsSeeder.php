<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RatingsSeeder extends Seeder
{
    public function run()
    {
        $ratings = [
            ['user_id' => 11, 'case_id' => 9, 'rating' => 3, 'comment' => 'Имеются недочёты в тексте и логике.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 11, 'case_id' => 10, 'rating' => 4, 'comment' => 'Nav slikti', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 13, 'case_id' => 9, 'rating' => 5, 'comment' => 'очень интересная загадка супер захватывающая сюжетная линия егора жалко', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        
        DB::table('ratings')->insert($ratings);
    }
}