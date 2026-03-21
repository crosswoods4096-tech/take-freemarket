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
        // page=buy → 購入履歴
        // page=sell → 出品履歴
        return view('mypage.index');
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
