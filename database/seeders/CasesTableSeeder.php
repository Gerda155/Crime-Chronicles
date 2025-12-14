<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CaseModel;

class CasesTableSeeder extends Seeder
{
    public function run()
    {
        $cases = [
            [
                'title' => 'Lieta №5',
                'description' => 'Pārbaudīt telefonus aizdomās turamajiem.',
                'preview' => 'Kriminālizmeklēšana pirms sākuma.',
                'genre_id' => 1,
                'status' => 'jauna',
                'rating' => 0,
                'answer' => 'Pierādījumi',
            ],
            [
                'title' => 'Lieta №6',
                'description' => 'Analizēt bankas transakcijas.',
                'preview' => 'Kopsavilkums pirms izmeklēšanas.',
                'genre_id' => 2,
                'status' => 'procesa',
                'rating' => 0,
                'answer' => 'Finanšu pārskats',
            ],
            [
                'title' => 'Lieta №7',
                'description' => 'Intervēt aculieciniekus.',
                'preview' => 'Kopsavilkums pirms izmeklēšanas.',
                'genre_id' => 1,
                'status' => 'pabeigta',
                'rating' => 0,
                'answer' => 'Liecinieki',
            ],
            [
                'title' => 'Lieta №8',
                'description' => 'Pārbaudīt videoierakstus no CCTV.',
                'preview' => 'Kopsavilkums pirms izmeklēšanas.',
                'genre_id' => 3,
                'status' => 'jauna',
                'rating' => 0,
                'answer' => 'Videoieraksti',
            ],
            [
                'title' => 'Lieta №9',
                'description' => 'Analizēt e-pastus un saziņu.',
                'preview' => 'Kopsavilkums pirms izmeklēšanas.',
                'genre_id' => 2,
                'status' => 'procesa',
                'rating' => 0,
                'answer' => 'E-pasti',
            ],
            [
                'title' => 'Lieta №10',
                'description' => 'Pārbaudīt aizdomīgās automašīnas.',
                'preview' => 'Kopsavilkums pirms izmeklēšanas.',
                'genre_id' => 3,
                'status' => 'pabeigta',
                'rating' => 0,
                'answer' => 'Transportlīdzeklis',
            ],
            [
                'title' => 'Lieta №11',
                'description' => 'Analizēt interneta aktivitātes.',
                'preview' => 'Kopsavilkums pirms izmeklēšanas.',
                'genre_id' => 1,
                'status' => 'jauna',
                'rating' => 0,
                'answer' => 'Interneta pēdas',
            ],
            [
                'title' => 'Lieta №12',
                'description' => 'Pārbaudīt dokumentus un līgumus.',
                'preview' => 'Kopsavilkums pirms izmeklēšanas.',
                'genre_id' => 2,
                'status' => 'procesa',
                'rating' => 0,
                'answer' => 'Dokumenti',
            ],
            [
                'title' => 'Lieta №13',
                'description' => 'Pārbaudīt GPS un lokācijas datus.',
                'preview' => 'Kopsavilkums pirms izmeklēšanas.',
                'genre_id' => 3,
                'status' => 'pabeigta',
                'rating' => 0,
                'answer' => 'GPS dati',
            ],
        ];

        foreach ($cases as $case) {
            CaseModel::create($case);
        }
    }
}
