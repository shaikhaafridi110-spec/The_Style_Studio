<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'product_images';
    protected $primaryKey = 'proimg_id';
    protected $fillable = [
        'proid',
        'image',
        'sort_order'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'proid');
    }
}
