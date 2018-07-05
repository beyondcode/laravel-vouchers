<?php

namespace BeyondCode\Vouchers\Traits;

use Vouchers;
use BeyondCode\Vouchers\Models\Voucher;
use BeyondCode\Vouchers\Exceptions\VoucherExpired;
use BeyondCode\Vouchers\Exceptions\VoucherIsInvalid;
use BeyondCode\Vouchers\Exceptions\VoucherAlreadyRedeemed;

trait CanRedeemVouchers
{
    /**
     * @param string $code
     * @throws VoucherExpired
     * @throws VoucherIsInvalid
     * @throws VoucherAlreadyRedeemed
     * @return mixed
     */
    public function redeemCode(string $code)
    {
        $voucher = Vouchers::check($code);

        if ($voucher->users()->wherePivot('user_id', $this->id)->exists()) {
            throw new VoucherAlreadyRedeemed;
        }
        if ($voucher->isExpired()) {
            throw new VoucherExpired;
        }

        $this->vouchers()->attach($voucher, [
            'redeemed_at' => now()
        ]);

        return $voucher;
    }

    /**
     * @return mixed
     */
    public function vouchers()
    {
        return $this->belongsToMany(Voucher::class)->withPivot('redeemed_at');
    }
}