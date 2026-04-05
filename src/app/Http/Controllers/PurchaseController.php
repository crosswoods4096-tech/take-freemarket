<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Deal;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * 購入確認画面
     */
    public function index($id)
    {
        $product = Product::findOrFail($id);

        return view('purchase.index', compact('product'));
    }

    /**
     * 購入処理
     */
    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        // すでに売り切れなら弾く
        if ($product->is_sold) {
            return redirect()->back()->with('error', 'この商品はすでに売り切れています。');
        }

        // deals テーブルにレコード作成
        Deal::create([
            'buyer_id' => auth()->id(),
            'seller_id' => $product->user_id,
            'product_id' => $product->id,
        ]);

        // 商品を売り切れに更新
        $product->update(['is_sold' => true]);

        return redirect()->route('purchase.complete');
    }

    /**
     * 購入完了画面
     */
    public function complete()
    {
        return view('purchase.complete');
    }
}
