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
        $query = Product::where('user_id', '!=', auth()->id());

        // 🔍 商品名検索
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where('name', 'like', '%' . $keyword . '%');
        }

        $products = Product::doesntHave('deal')
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

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        // カテゴリを配列に変換
        $categoryIds = explode(',', $validated['categories']);

        // 画像保存
        $path = $request->file('image')->store('products', 'public');

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

        // 中間テーブルにカテゴリを保存（多対多の場合）
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
}
