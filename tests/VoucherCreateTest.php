<?php

namespace BeyondCode\Vouchers\Tests;

use Vouchers;
use BeyondCode\Vouchers\Models\Voucher;
use BeyondCode\Vouchers\Tests\Models\Item;

class VoucherCreateTest extends TestCase
{
    /** @test */
    public function it_creates_vouchers_in_the_database_and_associates_them_with_the_model()
    {
        $item = Item::create(['name' => 'Foo']);

        $vouchers = Vouchers::create($item);

        $this->assertCount(1, $vouchers);

        $voucher = $vouchers[0];
        $this->assertInstanceOf(Voucher::class, $voucher);
        $this->assertSame($item->id, $voucher->model->id);
        $this->assertSame($item->name, $voucher->model->name);
    }

    /** @test */
    public function it_can_add_additional_data_to_a_voucher()
    {
        $item = Item::create(['name' => 'Foo']);

        $vouchers = Vouchers::create($item, 1, ['custom_information' => 'possible']);

        $voucher = $vouchers[0];
        $this->assertSame('possible', $voucher->data->get('custom_information'));
    }
}
