<?php

namespace Tests\Unit;

use App\Support\Num;
use PHPUnit\Framework\TestCase;

class NumFormatTest extends TestCase
{
    public function test_compact_format_for_mobile(): void
    {
        $this->assertSame('950', Num::compact(950));
        $this->assertSame('9.999', Num::compact(9999));
        $this->assertSame('12,5 rb', Num::compact(12500));
        $this->assertSame('Rp 5,66 jt', Num::compact(5663000, true));
        $this->assertSame('Rp 10 jt', Num::compact(10000000, true));
        $this->assertSame('1,25 M', Num::compact(1250000000));
        $this->assertSame('-2,5 jt', Num::compact(-2500000));
    }

    public function test_full_format(): void
    {
        $this->assertSame('Rp 5.663.000', Num::full(5663000, true));
        $this->assertSame('1.234', Num::full(1234));
    }
}
