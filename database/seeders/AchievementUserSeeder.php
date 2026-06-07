<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AchievementUserSeeder extends Seeder
{
    public function run()
    {
        $achievementUsers = [
            ['user_id' => 11, 'achievement_id' => 4, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 13, 'achievement_id' => 4, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 4, 'achievement_id' => 4, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 7, 'achievement_id' => 4, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 18, 'achievement_id' => 4, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 17, 'achievement_id' => 4, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        
        DB::table('achievement_user')->insert($achievementUsers);
    }
}