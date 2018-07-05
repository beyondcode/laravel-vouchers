<?php

namespace BeyondCode\Vouchers\Tests;

use Vouchers;
use BeyondCode\Vouchers\Tests\Models\Item;
use BeyondCode\Vouchers\Tests\Models\User;
use BeyondCode\Vouchers\Exceptions\VoucherExpired;
use BeyondCode\Vouchers\Exceptions\VoucherIsInvalid;
use BeyondCode\Vouchers\Exceptions\VoucherAlreadyRedeemed;

class CanRedeemVouchersTest extends TestCase
{
    /** @test */
    public function it_throws_an_invalid_voucher_exception_for_invalid_codes()
    {
        $this->expectException(VoucherIsInvalid::class);

        $user = User::first();

        $user->redeemCode('invalid');
    }

    /** @test */
    public function it_attaches_users_when_they_redeem_a_code()
    {
        $user = User::find(1);
        $item = Item::create(['name' => 'Foo']);

        $vouchers = Vouchers::create($item);
        $voucher = $vouchers[0];

        $user->redeemCode($voucher->code);

        $this->assertCount(1, $user->vouchers);

        $userVouchers = $user->vouchers()->first();
        $this->assertNotNull($userVouchers->pivot->redeemed_at);
    }

    /** @test */
    public function users_can_not_redeem_the_same_voucher_twice()
    {
        $this->expectException(VoucherAlreadyRedeemed::class);

        $user = User::find(1);
        $item = Item::create(['name' => 'Foo']);

        $vouchers = Vouchers::create($item);
        $voucher = $vouchers[0];

        $user->redeemCode($voucher->code);
        $user->redeemCode($voucher->code);
    }

    /** @test */
    public function users_can_not_redeem_expired_vouchers()
    {
        $this->expectException(VoucherExpired::class);

        $user = User::find(1);
        $item = Item::create(['name' => 'Foo']);

        $vouchers = Vouchers::create($item, 1, [], today()->subDay());
        $voucher = $vouchers[0];

        $user->redeemCode($voucher->code);
    }
}