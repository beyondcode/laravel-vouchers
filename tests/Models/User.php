<?php

namespace BeyondCode\Vouchers\Tests\Models;

use BeyondCode\Vouchers\Traits\CanRedeemVouchers;

class User extends \Illuminate\Foundation\Auth\User
{
    use CanRedeemVouchers;
}