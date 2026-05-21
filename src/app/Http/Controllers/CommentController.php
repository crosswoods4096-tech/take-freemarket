<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'comment' => 'required|max:255',
        ], [
            'comment.required' => 'コメントを入力してください',
            'comment.max' => 'コメントは255文字以内で入力してください',
        ]);

        Comment::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'content' => $request->comment, // ← テスト仕様に合わせる
        ]);

        return redirect('/products/' . $product->id);
    }
}
