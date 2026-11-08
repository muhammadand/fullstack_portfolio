<?php

namespace App\Support;

/** Format angka untuk tampilan admin, termasuk versi ringkas untuk layar HP. */
class Num
{
    public static function full($value, bool $rupiah = false): string
    {
        $n = number_format((float) $value, 0, ',', '.');

        return $rupiah ? "Rp {$n}" : $n;
    }

    /** 950 -> "950", 12.500 -> "12,5 rb", 5.663.000 -> "5,66 jt", 1.250.000.000 -> "1,25 M". */
    public static function compact($value, bool $rupiah = false): string
    {
        $v = (float) $value;
        $abs = abs($v);

        [$div, $suffix, $dec] = match (true) {
            $abs >= 1e12 => [1e12, ' T', 2],
            $abs >= 1e9  => [1e9, ' M', 2],
            $abs >= 1e6  => [1e6, ' jt', 2],
            $abs >= 1e4  => [1e3, ' rb', 1],
            default      => [1, '', 0],
        };

        $n = number_format($v / $div, $dec, ',', '.');
        if ($dec > 0) {
            $n = rtrim(rtrim($n, '0'), ',');
        }

        return ($rupiah ? 'Rp ' : '') . $n . $suffix;
    }
}
