<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products'; 

    protected $fillable = [
        'catid',
        'proname',
        'description',
        'price',
        'discount_price',
        'status',
        'proimage'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'catid', 'id');
    }
}
