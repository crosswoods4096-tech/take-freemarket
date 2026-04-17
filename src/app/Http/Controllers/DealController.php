<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Deal;
use Illuminate\Http\Request;

class DealController extends Controller
{
    // 購入確認画面
    public function index($id)
    {
        $product = Product::findOrFail($id);
        $user = auth()->user();

        return view('deals.buy', compact('product', 'user'));
    }
    // 購入処理（完了画面なし）
    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        // すでに購入されているかチェック
        if ($product->deal) {
            return back()->with('error', 'この商品はすでに購入されています。');
        }


        // 取引レコード作成
        Deal::create([
            'buyer_id' => auth()->id(),
            'product_id' => $product->id,
            'payment' => $request->payment,
        ]);



        // 完了画面なし → 商品一覧へ戻す
        return redirect()->route('products.recommend')
            ->with('success', '購入が完了しました。');
    }
}
