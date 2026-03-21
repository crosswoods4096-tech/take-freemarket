<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'price',
        'image',
        'is_sold',
    ];

    /**
     * 出品者
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * 取引情報（1商品1取引）
     */
    public function deal()
    {
        return $this->hasOne(Deal::class, 'product_id');
    }
}
