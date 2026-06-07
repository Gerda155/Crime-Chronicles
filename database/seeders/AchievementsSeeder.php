<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AchievementsSeeder extends Seeder
{
    public function run()
    {
        $achievements = [
            [
                'title' => 'Pirmais solis',
                'description' => 'Tu atrisināji savu pirmo lietu.',
                'icon' => 'achievements/uxMG3Qf6Pcv33Qmcxlb3jUreMlvHTol32lBwWN91.png',
                'required_cases' => 1,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Zaļais detektīvs',
                'description' => 'Tu sāc saprast, kā darbojas izmeklēšana.',
                'icon' => 'achievements/vcmMihbuASU7Pd1XUcEN71Hx6xoncbOeUC7qN05Q.png',
                'required_cases' => 3,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Pierādījumu mednieks',
                'description' => 'Neviena detaļa nepaslīd garām tavām acīm.',
                'icon' => 'achievements/jFIm0tq1CTKU11Ke7agmDAbO83TrrCvfmJVBZ5bj.png',
                'required_cases' => 5,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Aukstais prāts',
                'description' => 'Tu saglabā mieru pat sarežģītās lietās.',
                'icon' => 'achievements/h2Ars427iASTj6BvekzKl1Cz5b5L40p9JX4PFrde.png',
                'required_cases' => 10,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Ēnu izmeklētājs',
                'description' => 'Tu strādā klusumā, bet rezultāti runā paši par sevi.',
                'icon' => 'achievements/Z4LU35KfqbkF6WNrEiLds2KnzpFikKGaFw0U3YX0.png',
                'required_cases' => 15,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Detektīvs',
                'description' => 'Tu jau esi īsts profesionālis.',
                'icon' => 'achievements/tdE63j5vXGf5YtEsXgYvjCatDXutkC9nDgWgmVXF.png',
                'required_cases' => 20,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Nakts maiņa',
                'description' => 'Tu pārāk bieži pavadi naktis pie lietām.',
                'icon' => 'achievements/khyoNybH1ztJuOsN35ak2nCr6sRMUzvFiuIwcsZ3.png',
                'required_cases' => 25,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Patiesības meklētājs',
                'description' => 'Melošana tevi neapturēs.',
                'icon' => 'achievements/fpHhLDVRPDhRk2J3jBQGIF2Tn4P1lEJcTskA7v6t.png',
                'required_cases' => 30,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Kriminālistikas fans',
                'description' => 'Pierādījumi tev ir skaistāki par mākslu.',
                'icon' => 'achievements/vbjwpJ39esfHbjok4RwpLe8cIzLsnXW7f5sOpYSU.png',
                'required_cases' => 40,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Leģenda arhīvā',
                'description' => 'Tavas atrisinātās lietas kļūst par piemēru citiem.',
                'icon' => 'achievements/HrA1BlJiQx8KLDswkgqVIfu7fv3Y2Ri1CVfOhuAX.png',
                'required_cases' => 50,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Nepārspējamais',
                'description' => 'Gandrīz nav lietas, kuru tu nevarētu atrisināt.',
                'icon' => 'achievements/Y9HcgMGVnuMCs9RW7rFCUm0YqDpyp17jUGxPj837.png',
                'required_cases' => 75,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Hroniku meistars',
                'description' => 'Tu esi kļuvis par daļu no Crime Chronicles vēstures.',
                'icon' => 'achievements/UtTlRgFyj7j8LtWTzcQ3wegNPt0FKjZQtb9qvuTQ.png',
                'required_cases' => 100,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];
        
        DB::table('achievements')->insert($achievements);
    }
}