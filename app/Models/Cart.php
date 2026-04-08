<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $primaryKey = 'cart_id';

    protected $fillable = [
        'user_id',
        'proid',
        'qty',
        'size',
    ];

    // ── Relationship: belongs to Product ─────────────────────────
    public function product()
    {
        return $this->belongsTo(Product::class, 'proid', 'proid');
    }




    // ── Relationship: belongs to User ────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}