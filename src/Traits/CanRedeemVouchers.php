<?php

namespace BeyondCode\Vouchers\Traits;

use BeyondCode\Vouchers\Facades\Vouchers;
use BeyondCode\Vouchers\Models\Voucher;
use BeyondCode\Vouchers\Events\VoucherRedeemed;
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
            throw VoucherAlreadyRedeemed::create($voucher);
        }
        if ($voucher->isExpired()) {
            throw VoucherExpired::create($voucher);
        }

        $this->vouchers()->attach($voucher, [
            'redeemed_at' => now()
        ]);

        event(new VoucherRedeemed($this, $voucher));

        return $voucher;
    }

    /**
     * @param Voucher $voucher
     * @throws VoucherExpired
     * @throws VoucherIsInvalid
     * @throws VoucherAlreadyRedeemed
     * @return mixed
     */
    public function redeemVoucher(Voucher $voucher)
    {
        return $this->redeemCode($voucher->code);
    }

    /**
     * @return mixed
     */
    public function vouchers()
    {
        return $this->belongsToMany(Voucher::class)->withPivot('redeemed_at');
    }
}
