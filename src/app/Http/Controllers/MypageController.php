<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Deal;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateProfileRequest;

class MypageController extends Controller
{
    /**
     * マイページトップ
     * /mypage?page=buy /mypage?page=sell の分岐もここで可能
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $tab = $request->get('tab', 'listed');

        $listedProducts = Product::where('user_id', $user->id)->get();

        $purchasedProducts = Product::whereHas('deal', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->get();

        return view('mypage.index', compact(
            'user',
            'tab',
            'listedProducts',
            'purchasedProducts'
        ));
    }


    public function registerProfile()
    {
        $user = auth()->user();
        return view('mypage.register_profile', compact('user'));
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
    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();

        $user->name = $request->name;
        $user->postcode = $request->postcode;
        $user->address = $request->address;
        $user->building = $request->building;

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        return redirect()->route('mypage');
    }


    /**
     * 購入した商品一覧（分ける場合）
     */
    public function purchased()
    {
        $deals = Deal::where('buyer_id', auth()->id())
            ->with('product')
            ->latest()
            ->get();

        return view('mypage.purchased', compact('deals'));
    }

    /**
     * 出品した商品一覧（分ける場合）
     */
    public function sellingItems()
    {
        return view('mypage.selling');
    }
}
