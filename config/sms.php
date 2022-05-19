<?php

return [

    'default' => 'melipayamak',

    'providers' => [
        'melipayamak' => [
            'service' => \App\Services\MeliPayamak::class,
            'username' => env('MELI_PAYAMAK_USERNAME', null),
            'password' => env('MELI_PAYAMAK_PASSWORD', null),
            'from' => env('MELI_PAYAMAK_FROM', null)
        ]
    ]


];
