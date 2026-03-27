<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Productsize extends Model
{
    protected $table = 'product_sizes';
    protected $primaryKey = 'prosize_id';

    protected $fillable = [
        'proid',
        'size',
        'stock'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'proid');
    }
}
