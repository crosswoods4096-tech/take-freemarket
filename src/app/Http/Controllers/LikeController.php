<?php

namespace App\Http\Controllers;

use App\Models\Product;




class LikeController extends Controller
{
    public function toggle(Product $product)
    {
        $user = auth()->user();

        if ($user->likes()->where('product_id', $product->id)->exists()) {
            // すでにいいね → 削除
            $user->likes()->detach($product->id);
        } else {
            // いいねしてない → 追加
            $user->likes()->attach($product->id);
        }

        return back();
    }
}
