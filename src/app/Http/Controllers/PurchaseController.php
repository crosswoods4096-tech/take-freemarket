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
    public function showPurchaseForm($id)
    {
        return view('purchase.confirm');
    }

    /**
     * 住所変更画面
     */
    public function editAddress($id)
    {
        return view('purchase.address');
    }

    /**
     * 住所更新処理
     */
    public function updateAddress(Request $request, $id)
    {
        // ユーザー住所更新処理
    }

    /**
     * 購入確定処理（deal 作成）
     */
    public function complete($id)
    {
        // deals テーブルにレコード作成
        // products.is_sold = true に更新
    }
}
