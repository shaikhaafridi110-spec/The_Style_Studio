<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';
    protected $primaryKey = 'order_item_id';
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_image',
        'original_price',
        'discount_amount',
        'tax_amount',
        'final_price',
        'qty',
        'size',
        'subtotal',
        'status',
        'cancelled_at',
        'cancel_reason'
    ];


    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'proid');
    }
}
