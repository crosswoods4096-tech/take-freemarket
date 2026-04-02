<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * 商品一覧（トップページ）
     */
    public function index()
    {
        $products = Product::where('user_id', '!=', auth()->id())
            ->latest()
            ->get();

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
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // ① バリデーション
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|integer|min:1',
            'description' => 'required|string',
            'image'       => 'required|image|max:2048',
            'condition' => 'required|string',
            'brand'     => 'nullable|string|max:255',
            'categories'  => 'array',   // 多対多
            'seasons'     => 'array',   // 多対多
        ]);

        // ② 画像アップロード
        $path = $request->file('image')->store('products', 'public');

        // ③ 商品を作成（user_id を紐付け）
        $product = Product::create([
            'user_id'     => auth()->id(),
            'name'        => $validated['name'],
            'price'       => $validated['price'],
            'description' => $validated['description'],
            'image_path'       => $path,
            'condition' => $validated['condition'],
            'brand'     => $validated['brand'] ?? null,
        ]);

        // ④ カテゴリ（多対多）
        if ($request->has('categories')) {
            $product->categories()->sync($validated['categories']);
        }

        // ⑤ シーズン（多対多）
        if ($request->has('seasons')) {
            $product->seasons()->sync($validated['seasons']);
        }

        // ⑥ 完了後リダイレクト
        return redirect()->route('products.index')
            ->with('success', '商品を出品しました');
    }
    /**
     * 出品登録処理
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
