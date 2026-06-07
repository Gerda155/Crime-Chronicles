<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ActivityLogsSeeder extends Seeder
{
    public function run()
    {
        $logs = [
            ['user_id' => 4, 'username' => 'Chikulja', 'action_type' => 'login', 'object_type' => 'user', 'object_id' => 4, 'old_value' => null, 'new_value' => '{"message":"User logged in"}', 'ip_address' => '127.0.0.1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 4, 'username' => 'Chikulja', 'action_type' => 'logout', 'object_type' => 'user', 'object_id' => 4, 'old_value' => null, 'new_value' => '{"message":"User logged out"}', 'ip_address' => '127.0.0.1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 10, 'username' => 'superMod!', 'action_type' => 'login', 'object_type' => 'user', 'object_id' => 10, 'old_value' => null, 'new_value' => '{"message":"User logged in"}', 'ip_address' => '127.0.0.1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 4, 'username' => 'Chikulja', 'action_type' => 'update', 'object_type' => 'case', 'object_id' => 14, 'old_value' => '{"status":"pending"}', 'new_value' => '{"status":"approved"}', 'ip_address' => '127.0.0.1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['user_id' => 4, 'username' => 'Chikulja', 'action_type' => 'update', 'object_type' => 'rang', 'object_id' => 5, 'old_value' => '{"max_score":"489"}', 'new_value' => '{"max_score":"499"}', 'ip_address' => '127.0.0.1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        
        DB::table('activity_logs')->insert($logs);
    }
}