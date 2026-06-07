<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class SuspectsSeeder extends Seeder
{
    public function run()
    {
        $suspects = [
            // Case 9 suspects
            [
                'case_id' => 9,
                'name' => 'Тётя Оля',
                'description' => 'Уборщика в техникуме. В тот момент должна была убираться на этаже, где произошло наподение, но по словам очевидцев и по рабочим логам мы узнали, что её в тот момент там не было',
                'image_path' => 'storage/cases/suspects/ZzIEcaZ3NfQr7N0O2D9m1TMa5H9jR4BZY9sOS6Wa.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 9,
                'name' => 'Мартыньш Сверчков',
                'description' => 'Учитель пострадавшего. Как говорил сам пострадавший, учитель уделял ему повышенное внимание и оказывал странные знаки внимания. Его кабинет находится напротив туалета. Этот учитель нашел пострадавшего и позвонил в полицию.',
                'image_path' => 'storage/cases/suspects/VBpAbpJJsaBzTFlaKbpbW1BcDcz9spQCaJWxa3Wv.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 9,
                'name' => 'Егор Ёлочкин',
                'description' => 'Одногруппник пострадавшего. Мнётся и неохотно говорит с полицейскими.',
                'image_path' => 'storage/cases/suspects/EQvrWVFspAA0r3acf2xkx8bxw9YROnGDBwPPx4kW.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            // Case 10 suspects
            [
                'case_id' => 10,
                'name' => 'Bijušais pilots',
                'description' => 'Viņš pazīst teritoriju; Viņš daudzus gadus pavadīja tiesā par lidlauka zemi.',
                'image_path' => 'storage/cases/suspects/hjPTnLyTiJA2y8JrzE3R0gYagdZN2VjOEvLY3DNn.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 10,
                'name' => 'Apsargs',
                'description' => 'Apsargs ir vienīgais, kurš "redzēja spoku"; Viņš savā liecībā apjūk.',
                'image_path' => 'storage/cases/suspects/9VIPZMQ4AsDgzZe7o6LXnzK9XUnZt9TQCmm9z2QM.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 10,
                'name' => 'Noliktavas īpašnieks',
                'description' => 'Vēlas iegādāties zemi par zemāku cenu; Viņš slēpj finansiālas problēmas.',
                'image_path' => 'storage/cases/suspects/vgsY8Fh6NjGbgzCHWM0JpoKjj8l9tluWL7xDeiL8.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 10,
                'name' => 'Radiotehniķis',
                'description' => 'Prasmīgi strādā ar vecām frekvencēm; Viņš tika pamanīts naktī pie torņa.',
                'image_path' => 'storage/cases/suspects/Uir90iv19mfTUtyPEucTm2TmxlTo9D05PhTHV0uE.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            // Case 15 suspects
            [
                'case_id' => 15,
                'name' => 'Dmitrijs Kalniņš',
                'description' => 'Stingrs universitātes pasniedzējs. Pazīstams ar disciplīnu un augstām prasībām. Studenti viņu respektē, bet arī baidās. Strādā universitātē vairāk nekā 10 gadus.',
                'image_path' => 'storage/cases/suspects/gNezuQ4bar0saMrpqDDPUlER9icC0Tp395pBTv2L.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 15,
                'name' => 'Elza Liepa',
                'description' => 'Artūra kursabiedrene. Gudra, klusa, bet ļoti uzmanīga. Bieži redzēta kopā ar Artūru pēdējās nedēļās pirms pazušanas.',
                'image_path' => 'storage/cases/suspects/SDIGBPOThF6pP0FOZSOVsyrRVD6HRTvEkQUqExgK.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 15,
                'name' => 'Mikus Jansons',
                'description' => 'Sportisks students, kurš bieži konfliktē ar citiem. Apgalvo, ka neko nezina par Artūra pazušanu, bet viņš bija pēdējais, kurš ar viņu strīdējās auditorijā.',
                'image_path' => 'storage/cases/suspects/OtIAOA6gdCp2GXsmiXy6V9GcrjzPRfhwuyeGexhG.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            // Case 20 suspects
            [
                'case_id' => 20,
                'name' => 'Jānis Ozols',
                'description' => 'Bieži uzturas parkā un ir redzēts pie velosipēdu novietnes.',
                'image_path' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 20,
                'name' => 'Mārtiņš Liepa',
                'description' => 'Velosipēdu remontdarbnīcas darbinieks.',
                'image_path' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 20,
                'name' => 'Edgars Bērziņš',
                'description' => 'Apsargs, kurš tajā dienā patrulēja teritorijā.',
                'image_path' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            // Case 21 suspects
            [
                'case_id' => 21,
                'name' => 'Laura Kalniņa',
                'description' => 'Vēstures studente.',
                'image_path' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 21,
                'name' => 'Rihards Jansons',
                'description' => 'Bibliotēkas darbinieks.',
                'image_path' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            // Case 22 suspects
            [
                'case_id' => 22,
                'name' => 'Artūrs Siliņš',
                'description' => 'Interesējas par datoriem.',
                'image_path' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 22,
                'name' => 'Deniss Freimanis',
                'description' => 'Bija pēdējais pie datora.',
                'image_path' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 22,
                'name' => 'Miks Krūmiņš',
                'description' => 'Aizmirsa savu USB atmiņu klasē.',
                'image_path' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            // Case 23 suspects
            [
                'case_id' => 23,
                'name' => 'Ilze Mežule',
                'description' => 'Kasieres palīdze.',
                'image_path' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 23,
                'name' => 'Linda Bērziņa',
                'description' => 'Maiņas vadītāja.',
                'image_path' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 23,
                'name' => 'Andris Vītols',
                'description' => 'Noliktavas darbinieks.',
                'image_path' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            // Case 24 suspects
            [
                'case_id' => 24,
                'name' => 'Elīna Ozola',
                'description' => 'Sekmīga skolniece.',
                'image_path' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 24,
                'name' => 'Roberts Lapiņš',
                'description' => 'Bieži izmanto gatavus risinājumus.',
                'image_path' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 24,
                'name' => 'Kate Priede',
                'description' => 'Palīdz citiem mācībās.',
                'image_path' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];
        
        DB::table('suspects')->insert($suspects);
    }
}