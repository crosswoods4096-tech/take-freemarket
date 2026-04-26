<?php

namespace App\Http\Controllers;

use App\Http\Requests\DealStoreRequest;
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
    public function store(DealStoreRequest $request)
    {
        // バリデーション済みのデータがここに入る
        $validated = $request->validated();
        $product = Product::findOrFail($request->product_id);

        // すでに購入されているかチェック
        if ($product->deal) {
            return back()->with('error', 'この商品はすでに購入されています。');
        }


        // 取引レコード作成
        Deal::create([
            'buyer_id' => auth()->id(),   // ★ 正しいカラム名
            'product_id' => $validated['product_id'],
            'payment' => $validated['payment'],
        ]);

        // 完了画面なし → 商品一覧へ戻す
        return redirect()->route('products.index')
            ->with('success', '購入が完了しました。');
    }
    public function editAddress($id)
    {
        $product = Product::findOrFail($id);
        $user = auth()->user();

        return view('deals.address_update', compact('product', 'user'));
    }

    public function updateAddress(Request $request, $id)
    {
        // バリデーション
        $request->validate([
            'postcode' => 'required|string|max:10',
            'address'     => 'required|string|max:255',
            'building'    => 'nullable|string|max:255',
        ]);

        // ログイン中のユーザーを取得
        $user = auth()->user();

        // ユーザー情報を更新
        $user->postcode = $request->postcode;
        $user->address     = $request->address;
        $user->building    = $request->building;
        $user->save();

        // 商品情報を取得（購入確認画面に戻るため）
        $product = Product::findOrFail($id);

        // 購入確認画面に戻す
        return redirect()->route('deal.index', $product->id)
            ->with('success', '住所を更新しました。');
    }
}
