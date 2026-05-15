<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Deal;
use Illuminate\Http\Request;
use App\Http\Requests\DealStoreRequest;


class DealController extends Controller
{
    public function index($id)
    {
        $product = Product::findOrFail($id);
        $user = auth()->user();

        return view('deals.buy', compact('product', 'user'));
    }

    /**
     * 購入処理
     */




    public function store(DealStoreRequest $request, Product $product)
    {
        // バリデーション済みの値
        dd($request->all());

        $validated = $request->validated();

        Deal::create([
            'product_id' => $validated['product_id'],
            'user_id' => auth()->id(),
            'payment' => $validated['payment'],
        ]);

        return redirect()->route('deal.complete');
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
            'payment' => 'required|in:1,2',
        ]);


        // セッションに保存（DB 保存ではない）
        session(['payment' => $request->payment]);

        return redirect('/buy/' . $product->id);
    }
    public function editAddress($id)
    {
        $product = Product::findOrFail($id);
        $user = auth()->user();

        return view('deals.address_update', compact('product', 'user'));
    }

    public function updateAddress(Request $request, $id)
    {
        $user = auth()->user();

        // バリデーション
        $request->validate([
            'postal_code' => 'required',
            'address' => 'required',
            'building' => 'nullable',
        ], [
            'postal_code.required' => '郵便番号を入力してください。',
            'address.required' => '住所を入力してください。',
        ]);

        // ユーザー情報を更新
        $user->update([
            'postcode' => $request->postal_code,
            'address' => $request->address,
            'building' => $request->building,
        ]);

        // 購入確認画面に戻る
        return redirect()->route('deal.index', $id)
            ->with('success', '住所を更新しました。');
    }
}
