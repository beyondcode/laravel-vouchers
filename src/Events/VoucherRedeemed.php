<?php

namespace BeyondCode\Vouchers\Events;

use BeyondCode\Vouchers\Models\Voucher;
use BeyondCode\Vouchers\Tests\Models\User;
use Illuminate\Queue\SerializesModels;

class VoucherRedeemed
{
    use SerializesModels;

    /** @var User */
    public $user;

    /** @var Voucher */
    public $voucher;

    public function __construct(User $user, Voucher $voucher)
    {
        $this->user = $user;
        $this->voucher = $voucher;
    }
}