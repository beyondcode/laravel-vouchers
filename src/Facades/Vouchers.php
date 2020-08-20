<?php

namespace BeyondCode\Vouchers\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \BeyondCode\Vouchers\Vouchers
 */
class Vouchers extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'vouchers';
    }
}
