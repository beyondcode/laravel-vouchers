<?php

namespace BeyondCode\Vouchers\Exceptions;

class VoucherAlreadyRedeemed extends \Exception
{
    protected $message = 'The voucher was already redeemed.';
}