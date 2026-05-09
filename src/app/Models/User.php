<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'postcode',
        'address',
        'building',
        'avatar',
    ];

    /**
     * 出品した商品
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * 購入した取引
     */
    public function boughtDeals()
    {
        return $this->hasMany(Deal::class, 'buyer_id');
    }

    /**
     * 販売した取引
     */
    public function soldDeals()
    {
        return $this->hasMany(Deal::class, 'seller_id');
    }

    public function likes()
    {
        return $this->belongsToMany(Product::class, 'likes')->withTimestamps();
    }
}
