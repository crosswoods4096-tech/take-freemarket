<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;

class ProductController extends Controller
{
    /**
     * 商品一覧（トップページ）
     */
    public function index(Request $request)
    {
        $userId = auth()->id();

        // ベースクエリ（自分の出品を除外）
        $query = Product::where('user_id', '!=', $userId)
            ->with('deal');

        // 🔍 商品名検索
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where('name', 'like', '%' . $keyword . '%');
        }

        // 🔖 おすすめタブ
        if ($request->tab === 'recommend') {
            $query->where('is_recommend', true);
        }

        // SOLD を除外したい場合
        // $query->doesntHave('deal');

        // 最終取得
        $products = $query->get();

        return view('products.index', compact('products'));
    }

    public function mylist()
    {
        $products = auth()->user()->likes()->latest()->get();

        return view('products.mylist', compact('products'));
    }


    public function recommend()
    {
        $products = Product::where('is_recommend', true)->get();
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
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {


        $validated = $request->validated();

        // カテゴリ（配列 or カンマ区切り文字列の両方に対応）
        $categoryIds = is_array($validated['categories'])
            ? $validated['categories']
            : explode(',', $validated['categories']);


        // 画像が送られていない場合はダミー画像を使用
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
        } else {
            $path = 'products/dummy.jpg';
        }


        // 商品保存
        $product = Product::create([
            'name' => $validated['name'],
            'brand' => $validated['brand'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'condition' => $validated['condition'],
            'image_path' => $path,
            'user_id' => auth()->id(),
        ]);

        // カテゴリ紐付け
        $product->categories()->sync($categoryIds);

        return redirect()->route('products.index');
    }


    /**
     * 出品登録処理
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $products = Product::where('name', 'like', "%{$keyword}%")->get();

        return view('products.search', compact('products', 'keyword'));
    }
}
