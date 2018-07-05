<?php

namespace BeyondCode\Vouchers\Exceptions;

class VoucherExpired extends \Exception
{
    protected $message = 'The voucher is already expired.';
}