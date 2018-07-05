<?php

namespace BeyondCode\Vouchers\Tests;

use Vouchers;

class VoucherGenerateTest extends TestCase
{
    /** @test */
    public function it_returns_an_array_with_one_code()
    {
        $codes = Vouchers::generate();

        $this->assertCount(1, $codes);
    }

    /** @test */
    public function it_can_generate_multiple_vouchers_at_once()
    {
        $codes = Vouchers::generate(5);

        $this->assertCount(5, $codes);
    }
}
