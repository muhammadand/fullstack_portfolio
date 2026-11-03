<?php

/*
|--------------------------------------------------------------------------
| Form input per game (halaman detail top up)
|--------------------------------------------------------------------------
|
| Dicocokkan dengan nama brand (huruf kecil, memakai str_contains) dari atas ke bawah;
| aturan pertama yang cocok dipakai. `fields` kosong = voucher/gift card tanpa ID akun.
| Brand yang tidak cocok memakai 'default'.
|
*/

return [
    'rules' => [
        [
            'match' => ['mobile legends'],
            'fields' => [
                ['key' => 'user_id', 'label' => 'User ID', 'placeholder' => 'Contoh: 12345678', 'inputmode' => 'numeric', 'pattern' => '^\d{5,15}$'],
                ['key' => 'zone_id', 'label' => 'Zone ID', 'placeholder' => 'Contoh: 1234', 'inputmode' => 'numeric', 'pattern' => '^\d{3,6}$'],
            ],
            'hint' => 'Buka profil di game, User ID dan Zone ID tertulis di bawah nama, misalnya 12345678 (1234).',
        ],
        [
            'match' => ['free fire'],
            'fields' => [
                ['key' => 'player_id', 'label' => 'Player ID', 'placeholder' => 'Contoh: 1234567890', 'inputmode' => 'numeric', 'pattern' => '^\d{6,15}$'],
            ],
            'hint' => 'Buka profil di game, Player ID tertulis di bawah nama karakter.',
        ],
        [
            'match' => ['steam', 'roblox', 'google play', 'itunes', 'gift card', 'wallet code', 'voucher'],
            'fields' => [],
            'hint' => null,
        ],
    ],

    'default' => [
        'fields' => [
            ['key' => 'user_id', 'label' => 'User ID', 'placeholder' => 'Masukkan ID akun game', 'inputmode' => 'text', 'pattern' => '^.{3,50}$'],
        ],
        'hint' => 'Pastikan ID akun benar. Salah ID bisa membuat item masuk ke akun lain.',
    ],
];
