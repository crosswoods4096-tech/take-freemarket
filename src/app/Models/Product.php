<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    ];

    /**
     * 出品者
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 取引情報（1商品1取引）
     * deals テーブルの user_id が購入者
     */
    public function deal()
    {
        return $this->hasOne(Deal::class, 'product_id');
    }
    /*商品の状態アクセサ*/
    public function getConditionLabelAttribute()
    {
        return [
            1 => '良好',
            2 => '目立った傷や汚れなし',
            3 => 'やや傷や汚れあり',
            4 => '状態が悪い',
        ][$this->condition] ?? '';
    }

    /**
     * コメント
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * カテゴリ（多対多）
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }
    public function getCategoryNamesAttribute()
    {
        return $this->categories->pluck('name')->toArray();
    }


    /**
     * 画像URL
     */
    public function getImageUrlAttribute()
    {
        if (str_starts_with($this->image_path, 'http')) {
            return $this->image_path;
        }
        return asset('storage/' . $this->image_path);
    }

    /**
     * いいね（多対多）
     */
    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes')
            ->withTimestamps();
    }
    public function isLikedBy($user)
    {
        if (!$user) {
            return false;
        }

        return $this->likes()->where('user_id', $user->id)->exists();
    }


    /**
     * 商品が SOLD かどうか
     */
    public function getIsSoldAttribute()
    {
        return $this->deal()->exists();
    }
}
