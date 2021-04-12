<?php

namespace BeyondCode\Vouchers\Traits;

use BeyondCode\Vouchers\Models\Voucher;
use BeyondCode\Vouchers\Facades\Vouchers;

trait HasVouchers
{
    /**
     * Set the polymorphic relation.
     *
     * @return mixed
     */
    public function vouchers()
    {
        return $this->morphMany(config('vouchers.model', Voucher::class), 'model');
    }

    /**
     * @param int $amount
     * @param array $data
     * @param null $expires_at
     * @return Voucher[]
     */
    public function createVouchers(int $amount, array $data = [], $expires_at = null)
    {
        return Vouchers::create($this, $amount, $data, $expires_at);
    }

    /**
     * @param array $data
     * @param null $expires_at
     * @return Voucher
     */
    public function createVoucher(array $data = [], $expires_at = null)
    {
        return $this->createVouchers(1, $data, $expires_at)[0];
    }
}
