<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $table = 'orders';
   


    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'discount_amount',
        'tax_amount',
        'shipping_charge',
        'final_amount',
        'payment_method',
        'payment_status',
        'status',
        'name',
        'phone',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'postal_code',
        'tracking_number',
        'order_date',
        'delivered_at',
        'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
    public function couponUsage()
    {
        return $this->hasOne(CouponUsage::class, 'order_id');
    }
}
