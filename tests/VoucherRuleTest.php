<?php

namespace BeyondCode\Vouchers\Tests;

use Vouchers;
use Validator;
use BeyondCode\Vouchers\Rules\Voucher;
use BeyondCode\Vouchers\Tests\Models\User;
use BeyondCode\Vouchers\Tests\Models\Item;

class VoucherRuleTest extends TestCase
{

    /**
     * @return \Illuminate\Validation\Validator
     */
    protected function validator($code)
    {
        return Validator::make(['code' => $code], ['code' => new Voucher()]);
    }

    /** @test */
    public function it_validated_voucher_codes()
    {
        $item = Item::create(['name' => 'Foo']);

        $vouchers = Vouchers::create($item);

        $this->assertTrue($this->validator($vouchers[0]->code)->passes());
        $this->assertTrue($this->validator('invalid')->fails());
    }

    /** @test */
    public function it_returns_correct_error_messages_for_invalid_vouchers()
    {
        $validator = $this->validator('invalid');
        $validator->passes();

        $message = $validator->messages()->first('code');

        $this->assertSame('The voucher code is invalid.', $message);
    }

    /** @test */
    public function it_returns_correct_error_messages_for_redeemed_vouchers()
    {
        $item = Item::create(['name' => 'Foo']);
        $vouchers = Vouchers::create($item);

        $user = User::first();
        $user->redeemCode($vouchers[0]->code);

        auth()->login($user);

        $validator = $this->validator($vouchers[0]->code);

        $this->assertTrue($validator->fails());

        $message = $validator->messages()->first('code');

        $this->assertSame('The voucher code was already redeemed.', $message);
    }

    /** @test */
    public function it_returns_correct_error_messages_for_expired_vouchers()
    {
        $item = Item::create(['name' => 'Foo']);
        $vouchers = Vouchers::create($item, 1, [], now()->subDay(1));

        $validator = $this->validator($vouchers[0]->code);

        $this->assertTrue($validator->fails());

        $message = $validator->messages()->first('code');

        $this->assertSame('The voucher code is already expired.', $message);
    }

}