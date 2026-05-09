<?php

namespace App\Http\Controllers;

use App\Models\Product;

class LikeController extends Controller
{
    public function toggle(Product $product)
    {
        $user = auth()->user();

        if ($user->likes()->where('product_id', $product->id)->exists()) {
            $user->likes()->detach($product->id);
        } else {
            $user->likes()->attach($product->id);
        }

        return redirect('/products/' . $product->id);
    }

    public function destroy(Product $product)
    {
        $user = auth()->user();
        $user->likes()->detach($product->id);

        return redirect('/products/' . $product->id);
    }
}
