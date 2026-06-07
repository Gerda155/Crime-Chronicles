<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CasesSeeder extends Seeder
{
    public function run()
    {
        $cases = [
            [
                'title' => 'Дело о чёрной флешке',
                'description' => 'Программист был найден без сознания прямо в туалете .. Свидетели видели у него чёрную флешку, из-за которой он с кем-то спорил. Когда молодой человек пришел в себя, он не помнил с кем спорил, но выразил огромное разочаровние и страх, что флешка не с ним.',
                'genre_id' => 15,
                'rating' => 4,
                'answer_id' => 20,
                'user_id' => 14,
                'status' => 'active',
                'is_tutorial' => 1,
                'solution_explanation' => 'Егор Ёлочкин попросили скидку, но пострадавший отказал из-за чего Егор Ёлочкин ограбил его.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Pamestā lidlauka noslēpums',
                'description' => 'Vecā pamestā lidostā parādās mirdzošs "spoku astronauts". Tuvējā noliktavā strādnieki viens pēc otra pamet darbu pēc nakts maiņām.',
                'genre_id' => 13,
                'rating' => 4,
                'answer_id' => 23,
                'user_id' => 11,
                'status' => 'active',
                'is_tutorial' => 0,
                'solution_explanation' => '"Spoks" ir noliktavas īpašnieks. Viņš iebiedēja cilvēkus, lai šī teritorija tiktu pasludināta par bīstamu un pārdota gandrīz par velti. Tērps bija izgatavots no veciem aizsarglīdzekļiem un fluorescējošas krāsas.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Pazudušais students',
                'description' => 'Universitātē pazūd students Artūrs Bērziņš. Viņš pēdējo reizi redzēts lekcijā, bet pēc tam viņa pēdas pazūd. Aizdomas krīt uz pasniedzēju un kursabiedreni. Tavs uzdevums ir noskaidrot, kas patiesībā notika. (bildes: Magnific)',
                'genre_id' => 10,
                'rating' => 4,
                'answer_id' => 38,
                'user_id' => 6,
                'status' => 'active',
                'is_tutorial' => 0,
                'solution_explanation' => 'Artūrs Bērziņš nav pazudis piespiedu kārtā. Viņš pats inscenēja savu pazušanu, jo tika šantažēts saistībā ar akadēmisku krāpšanu. Elza Liepa zināja par situāciju un palīdzēja viņam to noslēpt. Pasniedzējs nebija iesaistīts.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Nozagtais velosipēds',
                'description' => 'Pilsētas parkā tika nozagts dārgs kalnu velosipēds. Policija nopratināja vairākus cilvēkus, kuri atradās notikuma vietā.',
                'genre_id' => 15,
                'rating' => 0,
                'answer_id' => 46,
                'user_id' => 8,
                'status' => 'active',
                'is_tutorial' => 0,
                'solution_explanation' => 'Liecinieks aprakstīja personu melnā jakā. Nopratināšanas laikā tika noskaidrots, ka tikai Jānis atradās parkā šādā apģērbā.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Noslēpumainā grāmatas pazušana',
                'description' => 'No bibliotēkas pazudusi reta vēsturiska grāmata.',
                'genre_id' => 8,
                'rating' => 0,
                'answer_id' => 49,
                'user_id' => 8,
                'status' => 'active',
                'is_tutorial' => 0,
                'solution_explanation' => 'Sistēmas dati parādīja, ka tieši Laura bija pēdējā persona, kura saņēma grāmatu.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Sabojātais dators',
                'description' => 'Skolas datorklasē tika bojāts viens no datoriem.',
                'genre_id' => 5,
                'rating' => 0,
                'answer_id' => 53,
                'user_id' => 7,
                'status' => 'active',
                'is_tutorial' => 0,
                'solution_explanation' => 'Salauztā USB atmiņa piederēja Mikam, un bojājums radās tās nepareizas lietošanas dēļ.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Trūkstošā nauda',
                'description' => 'Nelielā veikalā pēc darba dienas tika konstatēts naudas iztrūkums.',
                'genre_id' => 15,
                'rating' => 0,
                'answer_id' => 54,
                'user_id' => 7,
                'status' => 'active',
                'is_tutorial' => 0,
                'solution_explanation' => 'Video novērošanas ieraksti apliecināja, ka Ilze vienīgā neatļauti atvēra kasi.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Aizdomīgi augstais vērtējums',
                'description' => 'Skolotājs pamanīja, ka viens eksāmena darbs ir aizdomīgi līdzīgs internetā pieejamam risinājumam.',
                'genre_id' => 11,
                'rating' => 0,
                'answer_id' => 58,
                'user_id' => 7,
                'status' => 'active',
                'is_tutorial' => 0,
                'solution_explanation' => 'Roberta darbā tika atrastas identiskas kļūdas, kas sakrita ar internetā publicēto risinājumu.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];
        
        DB::table('cases')->insert($cases);
    }
}