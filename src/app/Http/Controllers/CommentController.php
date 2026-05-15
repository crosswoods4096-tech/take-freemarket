<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate(
            [
                'content' => 'required|string|max:255',
            ],
            [
                'content.required' => 'コメントを入力してください',
                'content.max' => 'コメントは255文字以内で入力してください',
            ]
        );

        Comment::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'content' => $validated['content'],
        ]);

        return redirect('/products/' . $product->id);
    }
}
