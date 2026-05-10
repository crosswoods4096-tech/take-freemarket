<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class MyListController extends Controller
{
    public function mylist()
    {
        $user = auth()->user();

        // いいねした商品
        $products = $user->likes()->with('deal')->get();

        // 購入済み商品
        $purchasedProducts = Product::whereHas('deal', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->get();

        return view('products.mylist', compact('products', 'purchasedProducts'));
    }
}
