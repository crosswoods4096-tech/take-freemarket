<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Deal;
use Illuminate\Http\Request;
use App\Http\Requests\DealStoreRequest;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class DealController extends Controller
{
    /**
     * 購入確認画面を表示（buyに一本化したため index メソッドは削除）
     */
    public function buy(Product $product)
    {
        return view('deals.buy', [
            'product' => $product,
            'user'    => auth()->user(), // ユーザー情報も一緒に渡す
            'payment' => session('payment', '選択してください'),
        ]);
    }
    /**
     * 購入処理
     */
    public function store(DealStoreRequest $request, Product $product)
    {
        // 【重要】売切商品の二重購入を防ぐチェック
        if ($product->deal()->exists()) {
            return redirect()->back()->with('error', 'この商品はすでに売り切れです。');
        }
        // バリデーション済みの値
        $validated = $request->validated();
        //  支払い方法が「カード支払い（値が 2 ）」の場合のみStripeの処理を行う
        if ($request->payment == '2') {

            // Stripeのシークレットキーを設定
            Stripe::setApiKey(config('services.stripe.secret') ?? env('STRIPE_SECRET'));

            // Stripeの決済画面（セッション）を作成
            $checkoutSession = StripeSession::create([
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'jpy', // 日本円
                        'product_data' => [
                            'name' => $product->name, // 選択中商品の名前
                        ],
                        'unit_amount' => $product->price, // 選択中商品の価格
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                // 決済が成功した時にジャンプするURL（決済成功後にDB保存するための別ルート）
                'success_url' => route('deal.success', [
                    'product_id' => $product->id,
                    'postcode'   => $validated['postcode'],
                    'address'    => $validated['address'],
                    'building'   => $validated['building'] ?? '',
                ]),
                // 決済をキャンセルした時の戻り先（元の購入画面）
                'cancel_url' => route('deal.buy', $product->id),
            ]);

            // 作成されたStripeの決済画面へ自動で安全にジャンプさせます
            return redirect()->away($checkoutSession->url);
        }
        Deal::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'payment' => $request->payment,
            'postcode' => $validated['postcode'],
            'address' => $validated['address'],
            'building' => $validated['building'],
        ]);
        // 購入後、セッションの支払い情報をクリア
        session()->forget('payment');

        return redirect()->route('products.index');
    }
    /**
     * 【追加】Stripe決済成功後のデータ保存処理
     */
    public function success(Request $request)
    {
        $productId = $request->query('product_id');
        $product   = Product::findOrFail($productId);

        // 万が一、決済中に他の人に買われていた場合の最終チェック
        if ($product->deal()->exists()) {
            return redirect()->route('products.index')->with('error', '商品は売り切れました。');
        }

        // カード決済が完了したのでDBに「購入履歴」を登録する
        Deal::create([
            'product_id' => $productId,
            'user_id'    => auth()->id(),
            'payment'    => '2', // カード支払い
            'postcode'   => $request->query('postcode'),
            'address'    => $request->query('address'),
            'building'   => $request->query('building'),
        ]);

        session()->forget('payment');

        return redirect()->route('products.index')->with('success', '購入が完了しました！');
    }
    /**
     * 💡 追加：決済キャンセル時の処理
     */
    public function cancel(Request $request)
    {
        return redirect()->route('products.index')->with('error', '決済がキャンセルされました。');
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
     * 支払方法を更新
     */
    public function updatePayment(Request $request, Product $product)
    {
        $request->validate([
            'payment' => 'required|in:1,2',
        ]);


        // セッションに保存（DB 保存ではない）
        session(['payment' => $request->payment]);

        return redirect()->route('deal.buy', $product->id);
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
        return redirect()->route('deal.buy', $id)
            ->with('success', '住所を更新しました。');
    }
}
