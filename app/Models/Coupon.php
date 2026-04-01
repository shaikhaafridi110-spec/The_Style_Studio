<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = 'coupons';
    protected $primaryKey = 'coupon_id';

    protected $fillable = [
        'code',
        'discount',
        'type',
        'expiry_date',
        'usage_limit',
        'used_count',
        'status'
    ];
    public function couponUsages()
    {
        return $this->hasMany(CouponUsage::class, 'coupon_id');
    }


}
