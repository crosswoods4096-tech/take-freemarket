<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Deal extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'seller_id',
        'buyer_id',
        'price',
        'status',
    ];

    /**
     * 対象の商品
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * 購入者
     */
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    /**
     * 出品者
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
