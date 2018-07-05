<?php

namespace BeyondCode\Vouchers\Exceptions;

class VoucherIsInvalid extends \Exception
{
    public static function withCode(string $code)
    {
        return new static('The provided code '.$code.' is invalid.');
    }
}