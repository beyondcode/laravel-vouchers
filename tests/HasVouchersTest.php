<?php

namespace BeyondCode\Vouchers\Tests;

use Vouchers;
use BeyondCode\Vouchers\Models\Voucher;
use BeyondCode\Vouchers\Tests\Models\Item;

class HasVouchersTest extends TestCase
{
    /** @test */
    public function models_with_vouchers_can_access_them()
    {
        $item = Item::create(['name' => 'Foo']);

        $this->assertCount(0, $item->vouchers()->get());

        $vouchers = Vouchers::create($item, 10);

        $this->assertCount(10, $item->vouchers()->get());
    }
}
