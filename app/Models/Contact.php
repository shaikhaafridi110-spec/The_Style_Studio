<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Contact extends Model
{
    protected $table = 'contacts';
    protected $primaryKey = 'contact_id';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'admin_reply',
        'replied_at'
    ];

    // relation
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}