<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'image',
        'status'
    ];



    public function product()
    {
        return $this->hasMany(Product::class, 'catid', 'id');

    }
}
