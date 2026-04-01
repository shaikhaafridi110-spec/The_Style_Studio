<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Contact;
use Carbon\Carbon;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'role',
        'google_id',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'postal_code',
          'birthdate',  
        'gender',     
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',

    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
             'birthdate' => 'date',
        ];
    }

     public function getAgeAttribute()
    {
        return $this->birthdate
            ? Carbon::parse($this->birthdate)->age
            : null;
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class, 'user_id', 'id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id', 'id');
    }
    public function contacts()
    {
        return $this->hasMany(Contact::class, 'user_id', 'id');
    }
    public function couponUsages()
    {
        return $this->hasMany(CouponUsage::class, 'user_id');
    }
}
