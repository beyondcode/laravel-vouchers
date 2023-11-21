<?php

namespace BeyondCode\Vouchers\Tests;

use BeyondCode\Vouchers\VoucherGenerator;

class GeneratorTest extends \PHPUnit\Framework\TestCase
{
    /** @test */
    public function it_uses_specified_characters_only()
    {
        $generator = new VoucherGenerator('1234567890', '********');
        $voucher = $generator->generate();

        $this->assertMatchesRegularExpression('/^[0-9]/', $voucher);
    }

    /** @test */
    public function it_uses_the_prefix()
    {
        $generator = new VoucherGenerator('1234567890', '********');
        $generator->setPrefix('beyondcode');

        $voucher = $generator->generate();

        $this->assertStringStartsWith('beyondcode-', $voucher);
    }

    /** @test */
    public function it_uses_the_suffix()
    {
        $generator = new VoucherGenerator('1234567890', '********');
        $generator->setSuffix('beyondcode');

        $voucher = $generator->generate();

        $this->assertStringEndsWith('-beyondcode', $voucher);
    }

    /** @test */
    public function it_uses_custom_separators()
    {
        $generator = new VoucherGenerator('1234567890', '********');
        $generator->setSeparator('%');
        $generator->setPrefix('beyondcode');
        $generator->setSuffix('beyondcode');

        $voucher = $generator->generate();

        $this->assertStringStartsWith('beyondcode%', $voucher);
        $this->assertStringEndsWith('%beyondcode', $voucher);
    }

    /** @test */
    public function it_generates_code_with_mask()
    {
        $generator = new VoucherGenerator('ABCDEFGH', '* * * *');
        $voucher = $generator->generate();

        $this->assertMatchesRegularExpression('/(.*)\s(.*)\s(.*)\s(.*)/', $voucher);
    }
}
