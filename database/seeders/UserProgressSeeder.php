<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class UserProgressSeeder extends Seeder
{
    public function run()
    {
        $progress = [
            ['user_id' => 11, 'case_id' => 9, 'score' => 75, 'opened_evidence' => 8, 'questions_used' => 2, 'completed' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 11, 'case_id' => 10, 'score' => 30, 'opened_evidence' => 5, 'questions_used' => 0, 'completed' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 13, 'case_id' => 9, 'score' => 0, 'opened_evidence' => 3, 'questions_used' => 2, 'completed' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 7, 'case_id' => 10, 'score' => 45, 'opened_evidence' => 3, 'questions_used' => 0, 'completed' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 4, 'case_id' => 10, 'score' => 15, 'opened_evidence' => 17, 'questions_used' => 0, 'completed' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 4, 'case_id' => 9, 'score' => 75, 'opened_evidence' => 7, 'questions_used' => 1, 'completed' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 10, 'case_id' => 15, 'score' => 80, 'opened_evidence' => 12, 'questions_used' => 0, 'completed' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 4, 'case_id' => 15, 'score' => 50, 'opened_evidence' => 17, 'questions_used' => 0, 'completed' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 7, 'case_id' => 9, 'score' => 65, 'opened_evidence' => 3, 'questions_used' => 0, 'completed' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 7, 'case_id' => 15, 'score' => 100, 'opened_evidence' => 20, 'questions_used' => 1, 'completed' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 17, 'case_id' => 15, 'score' => 30, 'opened_evidence' => 7, 'questions_used' => 0, 'completed' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 6, 'case_id' => 15, 'score' => 60, 'opened_evidence' => 4, 'questions_used' => 0, 'completed' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 18, 'case_id' => 15, 'score' => 15, 'opened_evidence' => 9, 'questions_used' => 0, 'completed' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 18, 'case_id' => 9, 'score' => 15, 'opened_evidence' => 1, 'questions_used' => 0, 'completed' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 17, 'case_id' => 9, 'score' => 50, 'opened_evidence' => 29, 'questions_used' => 1, 'completed' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        
        DB::table('user_progress')->insert($progress);
    }
}