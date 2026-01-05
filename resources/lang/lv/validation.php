<?php

return [

    'required' => 'Lauks :attribute ir obligāts.',
    'email' => 'Lauks :attribute jābūt derīgai e-pasta adresei.',
    'min' => [
        'string' => 'Lauks :attribute jābūt vismaz :min rakstzīmju garam.',
    ],
    'confirmed' => 'Lauks :attribute apstiprinājums nesakrīt.',
    'unique' => 'Šāds :attribute jau ir aizņemts.',
    'password_upper_lower' => 'Lauks :attribute jāietver vismaz viena lielā un viena maza burta.',

    'attributes' => [
        'name' => 'vārds',
        'username' => 'lietotājvārds',
        'email' => 'e-pasts',
        'password' => 'parole',
    ],

    'password' => [
        'letters' => 'Parolei jāietver vismaz viena burta.',
        'mixed' => 'Parolei jāietver vismaz viena lielā un viena maza burta.',
        'numbers' => 'Parolei jāietver vismaz viens cipars.',
        'symbols' => 'Parolei jāietver vismaz viens simbols.',
        'uncompromised' => 'Šī parole ir pārāk vāja, izvēlies citu.',
    ],

];
