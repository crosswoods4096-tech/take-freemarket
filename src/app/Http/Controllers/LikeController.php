<?php

namespace App\Http\Controllers;




class LikeController extends Controller
{
    public function toggle(Product $product)
    {
        $user = auth()->user();

        if ($user->likes()->where('product_id', $product->id)->exists()) {
            // いいね解除
            $user->likes()->detach($product->id);
            $liked = false;
        } else {
            // いいね追加
            $user->likes()->attach($product->id);
            $liked = true;
        }

        return response()->json(['liked' => $liked]);
    }
}
