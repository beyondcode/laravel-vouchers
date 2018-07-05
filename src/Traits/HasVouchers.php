<?php

namespace BeyondCode\Vouchers\Traits;

use BeyondCode\Vouchers\Models\Voucher;

trait HasVouchers
{
    /**
     * Set the polymorphic relation.
     *
     * @return mixed
     */
    public function vouchers()
    {
        return $this->morphMany(Voucher::class, 'model');
    }
}