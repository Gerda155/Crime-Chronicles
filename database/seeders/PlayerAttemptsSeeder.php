<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PlayerAttemptsSeeder extends Seeder
{
    public function run()
    {
        $attempts = [
            ['user_id' => 11, 'case_id' => 9, 'suspect_id' => 20, 'is_correct' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 11, 'case_id' => 10, 'suspect_id' => 23, 'is_correct' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 13, 'case_id' => 9, 'suspect_id' => 19, 'is_correct' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 13, 'case_id' => 9, 'suspect_id' => 18, 'is_correct' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 13, 'case_id' => 9, 'suspect_id' => 20, 'is_correct' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 4, 'case_id' => 9, 'suspect_id' => 20, 'is_correct' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 7, 'case_id' => 15, 'suspect_id' => 37, 'is_correct' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 7, 'case_id' => 15, 'suspect_id' => 39, 'is_correct' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 7, 'case_id' => 15, 'suspect_id' => 38, 'is_correct' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 18, 'case_id' => 15, 'suspect_id' => 38, 'is_correct' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 17, 'case_id' => 9, 'suspect_id' => 18, 'is_correct' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 17, 'case_id' => 9, 'suspect_id' => 19, 'is_correct' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 17, 'case_id' => 9, 'suspect_id' => 20, 'is_correct' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        
        DB::table('player_attempts')->insert($attempts);
    }
}