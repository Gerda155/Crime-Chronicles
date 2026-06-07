<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Andrejs Čikatilo',
                'username' => 'Chikulja',
                'email' => 'andrejChika@gmail.com',
                'password' => Hash::make('password123'),
                'bio' => 'Administrators ar 15 gadu pieredzi "cilvēku problēmu risināšanā". Mīlu kafiju, nakts maiņas un aizdomīgi klusos lietotājus </3',
                'avatar' => 'avatars/avatar_4_1779109019.jpg',
                'status' => 'active',
                'role' => 'admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Anzhelika Pezde',
                'username' => 'Anzhelika69',
                'email' => 'anzhelika@gmail.com',
                'password' => Hash::make('password123'),
                'bio' => 'Es atnācu šeit, lai sodītu menus.',
                'avatar' => 'avatars/avatar_5_1779109660.jpg',
                'status' => 'active',
                'role' => 'user',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Andrejs Račkovs',
                'username' => 'Andruha_ATSM',
                'email' => 'andrejs@gmail.com',
                'password' => Hash::make('password123'),
                'bio' => 'disappeared.',
                'avatar' => 'avatars/6a0b0fda48571.jpg',
                'status' => 'active',
                'role' => 'user',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Gerda Fedotova',
                'username' => 'gidra',
                'email' => 'gerdafedotova@inbox.lv',
                'password' => Hash::make('password123'),
                'bio' => 'Čikatilo man nozaga tiesības uz šo vietni. Tas ir mans diplomdarbs!(( Kāpēc es neesmu admins?',
                'avatar' => 'avatars/6a0b1105dd17b.jpg',
                'status' => 'active',
                'role' => 'user',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Nikole',
                'username' => 'Ov',
                'email' => 'nikole@gmail.com',
                'password' => Hash::make('password123'),
                'bio' => 'Давай устроим харлемшейк',
                'avatar' => 'avatars/6a0b1229d9a5e.jpg',
                'status' => 'active',
                'role' => 'user',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Люцифер',
                'username' => 'yourLuci~',
                'email' => 'lucifer@hell.com',
                'password' => Hash::make('password123'),
                'bio' => 'Тут как в своей тарелке',
                'avatar' => 'avatars/6a0b1349eee55.jpg',
                'status' => 'active',
                'role' => 'user',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Evgenijs Zheka',
                'username' => 'superMod!',
                'email' => 'moderator@gmail.com',
                'password' => Hash::make('password123'),
                'bio' => 'I\'m a moderator. I can ban you.',
                'avatar' => 'avatars/6a0b15fc7e9bd.jpg',
                'status' => 'active',
                'role' => 'moderator',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Taja ArbuZOVa',
                'username' => 'Absolute_esoteric_schizo',
                'email' => 'taja@gmail.com',
                'password' => Hash::make('password123'),
                'bio' => 'Cilvēks, kurš, diemžēl, izvēlējās kļūt par moderatoru, tā vietā, lai katru nakti ar dakšu pārbaudītu, vai acīs nav kameru un uz ādas – kukaiņu. Man ir talants dzert alu milzīgos daudzumos :3',
                'avatar' => 'avatars/6a0b16c8eb6e3.jpg',
                'status' => 'active',
                'role' => 'moderator',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Kar Karich',
                'username' => 'TrahTrahich2000',
                'email' => 'karich@inbox.lv',
                'password' => Hash::make('password123'),
                'bio' => 'Все преступники будут извиняться передо мной на коленях.',
                'avatar' => 'avatars/6a0b1bc10a6e4.jpg',
                'status' => 'active',
                'role' => 'user',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Agate Krūmiņa',
                'username' => 'BossPickMe',
                'email' => 'krumina@gmail.com',
                'password' => Hash::make('password123'),
                'bio' => '༺⎛⎝𝔇𝔢𝔪𝔬𝔫⎠⎞༻',
                'avatar' => 'avatars/6a0b1cfe4b22e.jpg',
                'status' => 'active',
                'role' => 'user',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Твоя тёща',
                'username' => 'lalka228',
                'email' => 'polinka@gmail.com',
                'password' => Hash::make('password123'),
                'bio' => 'Мой сыночка-корзиночка не виноват!',
                'avatar' => 'avatars/6a0b3b698f84d.jpg',
                'status' => 'active',
                'role' => 'user',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Jānis Ozolos',
                'username' => 'ozolins',
                'email' => 'ozols@ozols',
                'password' => Hash::make('password123'),
                'bio' => 'Es nezinu...',
                'avatar' => null,
                'status' => 'active',
                'role' => 'user',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Čepa',
                'username' => 'cepa_meow',
                'email' => 'chepa@inmox.lv',
                'password' => Hash::make('password123'),
                'bio' => null,
                'avatar' => null,
                'status' => 'inactive',
                'role' => 'moderator',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'moderator',
                'username' => 'moderator',
                'email' => 'moderator2@gmail.com',
                'password' => Hash::make('password123'),
                'bio' => 'Es esmu tikai testam',
                'avatar' => 'avatars/6a1f2316b71c3.jpg',
                'status' => 'active',
                'role' => 'moderator',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'alina',
                'username' => 'alina',
                'email' => 'alina@gmai',
                'password' => Hash::make('password123'),
                'bio' => 'qwerty',
                'avatar' => null,
                'status' => 'active',
                'role' => 'user',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];
        
        DB::table('users')->insert($users);
    }
}