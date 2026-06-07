<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class EvidenceSeeder extends Seeder
{
    public function run()
    {
        $evidence = [
            // Case 9 evidence
            [
                'case_id' => 9,
                'description' => 'Флешка, фигурирующая в деле. Изобращение восстановлено со слов пострадавшего',
                'image_path' => 'storage/cases/evidence/lWqnU2To8AXu8ZxtBTpxtkJcGugPDABqd8Qr95R3.jpg',
                'key_object_area' => '{"x":0.3989864864864865,"y":0.1899070945945946,"width":0.197972972972973,"height":0.5993243243243243}',
                'type' => 'image',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 9,
                'description' => 'Последнее сообщение в телеграмм канале пострадавшего',
                'image_path' => 'storage/cases/evidence/AG7evO45JbxAXhYwqWeeIrQTfZN5YOjjJiVFDjO6.png',
                'key_object_area' => null,
                'type' => 'image',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 9,
                'description' => 'Записка, найденная под столом пострадавшего "А ... сосёт Мартыньшу!"',
                'image_path' => 'storage/cases/evidence/JVpwEWiMxkhWTvfkpTPRcGmxRnYBB7gz0StXqbxX.jpg',
                'key_object_area' => null,
                'type' => 'image',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            // Case 10 evidence
            [
                'case_id' => 10,
                'description' => 'Luminiscējoša krāsa',
                'image_path' => 'storage/cases/evidence/y3glCPYR6BggSLnGhSLevyCgwDsriSPA2MKLTy5Q.jpg',
                'key_object_area' => null,
                'type' => 'image',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 10,
                'description' => 'Naudas plūsmas problēmu ziņojums',
                'image_path' => 'storage/cases/evidence/YVJ7xetzssSJeoK2FBVB15CLekNPm1Q0gWhZ4SHF.docx',
                'key_object_area' => null,
                'type' => 'image',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 10,
                'description' => 'PIRKUMA ČEKS',
                'image_path' => 'storage/cases/evidence/dYTZrqk11rXBNijPKnCHn1qxtBL6itkund2Q26ay.pdf',
                'key_object_area' => null,
                'type' => 'image',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            // Case 15 evidence
            [
                'case_id' => 15,
                'description' => 'Foto no auditorijas pēc lekcijas.',
                'image_path' => 'storage/cases/evidence/CGXuDmUWyLVC7gwl2Tyxoq4JVc2fbUfsqLsg0Ipf.png',
                'key_object_area' => '{"x":0.47466216216216217,"y":0.4279209952545851,"width":0.2466216216216216,"height":0.1026035654739002}',
                'type' => 'image',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 15,
                'description' => 'Universitātes apmeklējumu žurnāls.',
                'image_path' => 'storage/cases/evidence/y96EYiniqBZzVEhJ0DnFRgz5s9jBFN8Ui04B8lfq.pdf',
                'key_object_area' => null,
                'type' => 'image',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 15,
                'description' => 'Drošības sistēmas ieraksti',
                'image_path' => null,
                'key_object_area' => null,
                'type' => 'image',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 15,
                'description' => 'Artūrs Bērziņš rūna ar Elzu Liepu',
                'image_path' => 'storage/cases/evidence/flVWtoXOQkaI4ZRlJNa6JKDUYDtgemx6SOZ8tczM.docx',
                'key_object_area' => null,
                'type' => 'image',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            // Case 20 evidence
            [
                'case_id' => 20,
                'description' => 'Liecinieks redzēja cilvēku melnā jakā aizbraucam ar velosipēdu.',
                'image_path' => null,
                'key_object_area' => null,
                'type' => 'image',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 20,
                'description' => 'Velosipēda īpašnieks apstiprina, ka velosipēds bija pieslēgts.',
                'image_path' => null,
                'key_object_area' => null,
                'type' => 'image',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 20,
                'description' => 'Netālu tika atrasts pārgriezts drošības trose.',
                'image_path' => null,
                'key_object_area' => null,
                'type' => 'image',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            // Case 21 evidence
            [
                'case_id' => 21,
                'description' => 'Pēdējais ieraksts sistēmā rāda, ka grāmatu paņēma students.',
                'image_path' => null,
                'key_object_area' => null,
                'type' => 'image',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 21,
                'description' => 'Grāmata netika atgriezta noteiktajā laikā.',
                'image_path' => null,
                'key_object_area' => null,
                'type' => 'image',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 21,
                'description' => 'Bibliotekāre redzēja kādu steidzīgi atstājot lasītavu.',
                'image_path' => null,
                'key_object_area' => null,
                'type' => 'image',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            // Case 22 evidence
            [
                'case_id' => 22,
                'description' => 'Bojājums tika konstatēts pēc mācību stundas.',
                'image_path' => null,
                'key_object_area' => null,
                'type' => 'image',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 22,
                'description' => 'Žurnālā redzams, ka datoru izmantoja tikai trīs skolēni.',
                'image_path' => null,
                'key_object_area' => null,
                'type' => 'image',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 22,
                'description' => 'Uz galda atrasta salauzta USB atmiņa.',
                'image_path' => null,
                'key_object_area' => null,
                'type' => 'image',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            // Case 23 evidence
            [
                'case_id' => 23,
                'description' => 'Kases aparāts strādāja pareizi.',
                'image_path' => null,
                'key_object_area' => null,
                'type' => 'image',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 23,
                'description' => 'Nauda pazuda maiņas laikā.',
                'image_path' => null,
                'key_object_area' => null,
                'type' => 'image',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 23,
                'description' => 'Pie kases drīkstēja atrasties tikai darbinieki.',
                'image_path' => null,
                'key_object_area' => null,
                'type' => 'image',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            // Case 24 evidence
            [
                'case_id' => 24,
                'description' => 'Atbildes pilnībā sakrīt ar internetā publicētu materiālu.',
                'image_path' => null,
                'key_object_area' => null,
                'type' => 'image',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 24,
                'description' => 'Darbā atkārtotas identiskas kļūdas.',
                'image_path' => null,
                'key_object_area' => null,
                'type' => 'image',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'case_id' => 24,
                'description' => 'Students nevarēja izskaidrot risinājuma gaitu.',
                'image_path' => null,
                'key_object_area' => null,
                'type' => 'image',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];
        
        DB::table('evidence')->insert($evidence);
    }
}