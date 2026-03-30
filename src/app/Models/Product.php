<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Comment;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'price',
        'brand',
        'description',
        'image_path',
        'condition',
        'category_id',
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

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
