<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class MypageController extends Controller
{
    /**
     * マイページトップ
     * /mypage?page=buy /mypage?page=sell の分岐もここで可能
     */
    public function index(Request $request)
    {
        $user = auth()->user();   // ← これが必須
        $tab = $request->tab ?? 'sell';

        // 出品した商品
        if ($tab === 'sell') {
            $products = Product::where('user_id', $user->id)->get();
        } else {
            // 購入した商品（仮）
            $products = [];
        }

        return view('mypage.index', compact('user', 'products', 'tab'));
    }


    public function update(Request $request)
    {
        $user = auth()->user();

        $user->name = $request->name;
        $user->postcord = $request->postcord;
        $user->address = $request->address;
        $user->building = $request->building;

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        return redirect()->route('mypage')->with('success', 'プロフィールを更新しました');
    }
    /**
     * プロフィール編集画面
     */
    public function editProfile()
    {
        $user = auth()->user();   // ← ログイン中のユーザーを取得

        return view('mypage.profile', compact('user'));
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
