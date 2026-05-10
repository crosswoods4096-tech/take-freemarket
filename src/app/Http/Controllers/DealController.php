<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;

class DealController extends Controller
{
    /**
     * 購入処理
     */
    public function store(Product $product)
    {
        $user = auth()->user();

        // すでに購入済みなら何もしない（2重購入防止）
        if ($product->purchase) {
            return redirect('/products');
        }

        // 購入テーブルに登録
        Purchase::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        // is_sold は使わない（購入テーブルが存在するかで判定）

        return redirect('/products');
    }

    /**
     * 購入済み商品一覧（プロフィール画面）
     */
    public function purchased()
    {
        $user = auth()->user();

        $purchasedProducts = Product::whereHas('deal', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->get();

        return view('mypage', compact('purchasedProducts'));
    }
    /**
     * 支払方法選択画面を表示
     */
    public function buy(Product $product)
    {
        return view('deals.buy', [
            'product' => $product,
            'payment' => session('payment', '選択してください'),
        ]);
    }
    /**
     * 支払方法を更新
     */
    public function updatePayment(Request $request, Product $product)
    {
        $request->validate([
            'payment' => 'required|string',
        ]);

        // セッションに保存（DB 保存ではない）
        session(['payment' => $request->payment]);

        return redirect('/buy/' . $product->id);
    }
}
