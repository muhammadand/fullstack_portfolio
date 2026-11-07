<?php

/*
|--------------------------------------------------------------------------
| Katalog PPOB (Pulsa, Paket Data, PLN) untuk halaman partner
|--------------------------------------------------------------------------
|
| `categories`: slug kategori hasil sync Digiflazz (Str::slug dari nama kategori Digiflazz).
| `operators`: dicocokkan ke nama brand (huruf kecil, str_contains) dari atas ke bawah.
|   - prefixes: 4 digit awal nomor HP (format 08xx) untuk deteksi operator otomatis.
|   - color: class aksen chip operator (ditulis lengkap agar ter-scan Tailwind).
| Brand yang tidak cocok tetap tampil, hanya tanpa deteksi nomor.
|
*/

return [
    'categories' => [
        'pulsa' => 'pulsa',
    ],

    'operators' => [
        ['key' => 'byu', 'match' => ['by.u', 'byu'], 'prefixes' => [], 'color' => 'text-sky-300'],
        ['key' => 'telkomsel', 'match' => ['telkomsel'], 'prefixes' => ['0811', '0812', '0813', '0821', '0822', '0823', '0851', '0852', '0853'], 'color' => 'text-red-400'],
        ['key' => 'indosat', 'match' => ['indosat', 'im3'], 'prefixes' => ['0814', '0815', '0816', '0855', '0856', '0857', '0858'], 'color' => 'text-yellow-400'],
        ['key' => 'axis', 'match' => ['axis'], 'prefixes' => ['0831', '0832', '0833', '0838'], 'color' => 'text-purple-400'],
        ['key' => 'xl', 'match' => ['xl'], 'prefixes' => ['0817', '0818', '0819', '0859', '0877', '0878'], 'color' => 'text-blue-400'],
        ['key' => 'tri', 'match' => ['tri', 'three'], 'prefixes' => ['0895', '0896', '0897', '0898', '0899'], 'color' => 'text-pink-400'],
        ['key' => 'smartfren', 'match' => ['smartfren'], 'prefixes' => ['0881', '0882', '0883', '0884', '0885', '0886', '0887', '0888', '0889'], 'color' => 'text-rose-400'],
    ],
];
