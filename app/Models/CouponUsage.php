<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponUsage extends Model
{
    protected $table = 'coupon_usages';
    protected $primaryKey = 'coupon_usage_id';


    protected $fillable = [
        'coupon_id',
        'user_id',
        'order_id'
    ];
    // Coupon
    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id', 'coupon_id');
    }

    // User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    // Order
    public function order()
{
    return $this->belongsTo(Order::class, 'order_id', 'id');
}
   

}
