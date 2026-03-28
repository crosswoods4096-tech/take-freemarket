<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deal;
use App\Models\Product;

class MypageController extends Controller
{
    /**
     * マイページトップ
     * /mypage?page=buy /mypage?page=sell の分岐もここで可能
     */
    public function index(Request $request)
    {
        $user = auth()->user(); // ← ログイン中のユーザーを取得
        $tab = $request->tab ?? 'sell'; // ← タブ切り替え用（任意）

        // 出品 or 購入した商品を取得（仮）
        $products = []; // ← 後で実装

        return view('mypage.index', compact('user', 'tab', 'products'));
    }

    /**
     * プロフィール編集画面
     */
    public function editProfile()
    {
        return view('mypage.profile');
    }

    /**
     * プロフィール更新処理
     */
    public function updateProfile(Request $request)
    {
        // バリデーション → 更新処理
    }

    /**
     * 購入した商品一覧（分ける場合）
     */
    public function purchasedItems()
    {
        return view('mypage.purchased');
    }

    /**
     * 出品した商品一覧（分ける場合）
     */
    public function sellingItems()
    {
        return view('mypage.selling');
    }
}
