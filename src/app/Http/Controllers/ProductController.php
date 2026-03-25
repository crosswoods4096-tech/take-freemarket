<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * 商品一覧（トップページ）
     */
    public function index(Request $request)
    {
        // 商品一覧を取得（例：新着順）
        $products = Product::orderBy('created_at', 'desc')->get();

        return view('products.index', compact('products'));
    }

    public function recommend()
    {
        $products = Product::where('is_recommend', true)->get();
        return view('products.index', compact('products'));
    }

    public function mylist()
    {
        $products = auth()->user()->mylistProducts;
        return view('products.index', compact('products'));
    }
    /**
     * マイリスト（自分の出品一覧）
     */
    public function indexMyList()
    {
        $products = Product::where('user_id', auth()->id())->get();

        return view('products.index', compact('products'));
    }

    /**
     * 商品詳細
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.detail', compact('product'));
    }

    /**
     * 出品フォーム
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * 出品登録処理
     */
    public function store(Request $request)
    {
        // バリデーション → 保存 → リダイレクト
    }
}
