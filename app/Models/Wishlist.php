<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $table = 'wishlists';
    protected $primaryKey = 'wish_id';

    protected $fillable = [
        'user_id',
        'proid'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }

   
    public function product()
    {
        return $this->belongsTo(Product::class, 'proid');
    }
}
