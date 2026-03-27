<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'proid';
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
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'proid');
    }
    public function size()
    {
        return $this->hasMany(Productsize::class, 'proid');
    }
}
