<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class QuestionsSeeder extends Seeder
{
    public function run()
    {
        $questions = [
            // Case 9 questions
            [
                'case_id' => 9,
                'suspect_id' => 18,
                'question_text' => 'Почему вы не были на своем рабочем месте в нужное время?',
                'answer_text' => 'Я отдавала заявление на увольнение по собственному желанию. Потом ушла домой.',
                'is_locked' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 9,
                'suspect_id' => 19,
                'question_text' => 'Вы можете прокомментировать слухи о вашем неподобающем поведении?',
                'answer_text' => 'Я прошу адвоката.',
                'is_locked' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 9,
                'suspect_id' => 19,
                'question_text' => 'Зачем вы шли в туалет для учеников, если у вас есть свой?',
                'answer_text' => 'Я прошу адвоката.',
                'is_locked' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            // Case 10 questions
            [
                'case_id' => 10,
                'suspect_id' => 21,
                'question_text' => 'Kur jūs bijāt tajā naktī?',
                'answer_text' => 'Es biju mājās. Skatījos televīziju. Es tur sen vairs neeju… tas lidlauks nes tikai problēmas.',
                'is_locked' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 10,
                'suspect_id' => 21,
                'question_text' => 'Kāpēc jūs tiesājāties par šo teritoriju?',
                'answer_text' => 'Tā vieta kādreiz bija mana dzīve. Viņi visu aizvēra un atstāja sapūt. Protams, es biju dusmīgs.',
                'is_locked' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 10,
                'suspect_id' => 21,
                'question_text' => 'Vai jūs ticat "spoku astronautam"?',
                'answer_text' => 'Nē. Bet es zinu vienu... kāds ļoti grib, lai cilvēki baidītos.',
                'is_locked' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 10,
                'suspect_id' => 22,
                'question_text' => 'Ko tieši jūs redzējāt?',
                'answer_text' => 'Tas… tas stāvēja pie angāra. Garš, spīdošs un tās briesmīgās smieklu skaņas…',
                'is_locked' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 10,
                'suspect_id' => 22,
                'question_text' => 'Kāpēc jūsu liecības mainās?',
                'answer_text' => 'Es biju nobijies, labi?! Tur bija tumšs, es nevarēju visu skaidri redzēt.',
                'is_locked' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 10,
                'suspect_id' => 22,
                'question_text' => 'Vai jūs tajā naktī pametāt savu posteni?',
                'answer_text' => 'Tikai uz pāris minūtēm. Radio pēkšņi pārstāja darboties, es gāju pārbaudīt elektrību.',
                'is_locked' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 10,
                'suspect_id' => 23,
                'question_text' => 'Kāpēc darbinieki pamet darbu?',
                'answer_text' => 'Tāpēc ka viņi tic visādām muļķībām internetā. Es zaudēju naudu šī stulbā "spoka" dēļ.',
                'is_locked' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 10,
                'suspect_id' => 23,
                'question_text' => 'Vai jums ir finansiālas problēmas?',
                'answer_text' => 'Katram biznesam ir grūti laiki. Tas nenozīmē, ka es skraidu apkārt spoku kostīmā.',
                'is_locked' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 10,
                'suspect_id' => 23,
                'question_text' => 'Kāpēc jūs bieži redzēja pie lidlauka naktīs?',
                'answer_text' => 'Noliktava atrodas blakus. Dažreiz es pārbaudu teritoriju pats. Kas tur tik dīvains?',
                'is_locked' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 10,
                'suspect_id' => 24,
                'question_text' => 'Kāpēc jūs bijāt vadības tornī?',
                'answer_text' => 'Tur vēl darbojas vecās radio sistēmas. Mani interesē veca tehnika.',
                'is_locked' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 10,
                'suspect_id' => 24,
                'question_text' => 'Vai jūs atpazīstat šo smieklu ierakstu?',
                'answer_text' => '…Nē. Bet tas izklausās pēc modificēta radiosignāla.',
                'is_locked' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 10,
                'suspect_id' => 24,
                'question_text' => 'Vai kāds varēja izmantot radio, lai biedētu cilvēkus?',
                'answer_text' => 'Protams. Ar pareizo aprīkojumu var radīt gandrīz jebkuru skaņu.',
                'is_locked' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            // Case 15 questions
            [
                'case_id' => 15,
                'suspect_id' => 37,
                'question_text' => 'Vai jūs redzējāt Artūru pēc lekcijas?',
                'answer_text' => 'Nē, es aizgāju uz kabinetu.',
                'is_locked' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 15,
                'suspect_id' => 37,
                'question_text' => 'Vai viņam bija problēmas?',
                'answer_text' => 'Viņš bija saspringts, bet nekas nopietns.',
                'is_locked' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 15,
                'suspect_id' => 38,
                'question_text' => 'Kur jūs bijāt pēc lekcijas?',
                'answer_text' => 'Bibliotēkā… vai vismaz tā es teicu.',
                'is_locked' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 15,
                'suspect_id' => 38,
                'question_text' => 'Vai jūs tikāties ar Artūru 204. telpā?',
                'answer_text' => '...jā. Bet tas nebija tas, ko jūs domājat.',
                'is_locked' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 15,
                'suspect_id' => 39,
                'question_text' => 'Vai jums bija konflikts ar Artūru?',
                'answer_text' => 'Viņš mani kaitināja, bet es neko nedarīju.',
                'is_locked' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 15,
                'suspect_id' => 39,
                'question_text' => 'Kur viņš devās pēc lekcijas?',
                'answer_text' => 'Nezinu. Viņš vienkārši pazuda.',
                'is_locked' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];
        
        DB::table('questions')->insert($questions);
    }
}