<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';
    protected $primaryKey = 'review_id';

    protected $fillable = [
        'user_id',
        'proid',
        'rating',
        'review'
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    
    public function product()
    {
        return $this->belongsTo(Product::class, 'proid', 'proid');
    }
}
