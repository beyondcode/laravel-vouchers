<?php

namespace BeyondCode\Vouchers\Events;

use Illuminate\Queue\SerializesModels;
use BeyondCode\Vouchers\Models\Voucher;

class VoucherRedeemed
{
    use SerializesModels;

    public $user;

    /** @var Voucher */
    public $voucher;

    public function __construct($user, Voucher $voucher)
    {
        $this->user = $user;
        $this->voucher = $voucher;
    }
}