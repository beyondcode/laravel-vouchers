<?php

namespace BeyondCode\Vouchers\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use BeyondCode\Vouchers\Traits\HasVouchers;

class Item extends Model
{
    use HasVouchers;

    protected $fillable = ['name'];
}