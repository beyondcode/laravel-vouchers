<?php

namespace BeyondCode\Vouchers\Rules;

use Vouchers;
use Illuminate\Contracts\Validation\Rule;
use BeyondCode\Vouchers\Exceptions\VoucherExpired;
use BeyondCode\Vouchers\Exceptions\VoucherIsInvalid;
use BeyondCode\Vouchers\Exceptions\VoucherAlreadyRedeemed;

class Voucher implements Rule
{
    protected $isInvalid = false;
    protected $isExpired = false;
    protected $wasRedeemed = false;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            $voucher = Vouchers::check($value);

            // Check if the voucher was already redeemed
            if (auth()->check() && $voucher->users()->wherePivot('user_id', auth()->id())->exists()) {
                throw VoucherAlreadyRedeemed::create($voucher);
            }
        } catch (VoucherIsInvalid $exception) {
            $this->isInvalid = true;
            return false;
        } catch (VoucherExpired $exception) {
            $this->isExpired = true;
            return false;
        } catch (VoucherAlreadyRedeemed $exception) {
            $this->wasRedeemed = true;
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if ($this->wasRedeemed) {
            return trans('vouchers::validation.code_redeemed');
        }
        if ($this->isExpired) {
            return trans('vouchers::validation.code_expired');
        }
        return trans('vouchers::validation.code_invalid');
    }
}
