<?php

namespace BeyondCode\Vouchers\Tests;

use Vouchers;
use BeyondCode\Vouchers\Tests\Models\Item;

class HasVouchersTest extends TestCase
{
    /** @test */
    public function models_with_vouchers_can_access_them()
    {
        $item = Item::create(['name' => 'Foo']);

        $this->assertCount(0, $item->vouchers()->get());

        Vouchers::create($item, 10);

        $this->assertCount(10, $item->vouchers()->get());
    }

    /** @test */
    public function models_can_create_vouchers_associated_to_them()
    {
        $item = Item::create(['name' => 'Foo']);
        $voucher = $item->createVoucher();

        $this->assertCount(1, $item->vouchers()->get());

        $this->assertSame($voucher->model->id, $item->id);
    }

    /** @test */
    public function models_can_create_multiple_vouchers_associated_to_them()
    {
        $item = Item::create(['name' => 'Foo']);
        $vouchers = $item->createVouchers(2);

        $this->assertCount(2, $item->vouchers()->get());

        $this->assertSame($vouchers[0]->model->id, $item->id);
        $this->assertSame($vouchers[1]->model->id, $item->id);
    }
}
