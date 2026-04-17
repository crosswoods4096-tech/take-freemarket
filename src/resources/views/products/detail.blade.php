@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/products/detail.css') }}">
@endsection

@section('content')
<div class="container mx-auto px-4 py-6">

    <div class="detail-container mt-8">

        {{-- 左半分：商品画像 --}}
        <div class="detail-left">
            <img src="{{ $product->image_url }}"
                alt="{{ $product->name }}"
                class="detail-image shadow">
        </div>

        {{-- 右半分：商品情報 --}}
        <div class="detail-right">

            <h1 class="text-3xl font-bold mb-2">{{ $product->name }}</h1>

            <p class="text-gray-500 text-sm mb-4">{{ $product->brand }}</p>

            <div class="mb-4">
                <span class="fw-bold">価格：</span>
                <span class="fs-4 text-black">
                    ¥{{ number_format($product->price) }}
                </span>
                <span class="text-muted">(税込)</span>
            </div>
            <div class="flex items-center gap-4 mt-2">

                {{-- いいねボタン --}}
                <button id="like-btn" data-product-id="{{ $product->id }}">
                    @if(auth()->user()?->likes->contains($product->id))
                    ❤️
                    @else
                    🤍
                    @endif
                </button>

                {{-- コメント閲覧ボタン --}}
                <a href="#comments-section" class="text-gray-600 hover:text-red-500">
                    💬 コメントを見る
                </a>

            </div>


            @if(!$product->is_sold)
            <a href="{{ route('deal.index', $product->id) }}"
                class="detail-buy-button">
                購入手続きへ
            </a>
            @endif



            {{-- 商品説明 --}}
            <h2 class="text-xl font-semibold mb-2">商品説明</h2>
            <p class="mb-6 whitespace-pre-line">{{ $product->description }}</p>

            {{-- 商品情報（カテゴリ・状態） --}}
            <h2 class="text-xl font-semibold mb-2">商品の情報</h2>
            <div class="mb-6">
                <p>カテゴリ：
                    @foreach ($product->category_names as $name)
                    <span class="category-tag">{{ $name }}</span>
                    @endforeach
                </p>


                <p>状態：{{ $product->condition_label }}</p>

            </div>

            {{-- コメント一覧 --}}
            <h2 class="text-xl font-semibold mb-2">コメント</h2>
            <div class="mb-6">
                @forelse ($product->comments as $comment)
                <div class="border-b py-2">
                    <p class="text-sm text-gray-600">{{ $comment->user->name }}</p>
                    <p>{{ $comment->content }}</p>
                </div>
                @empty
                <p class="text-gray-500">まだコメントはありません。</p>
                @endforelse
            </div>

            {{-- コメント投稿フォーム --}}
            <form action="{{ route('comments.store', $product->id) }}" method="POST" class="mt-4">
                @csrf
                <textarea name="content" class="w-full border rounded p-2" rows="3" placeholder="コメントを入力"></textarea>

                <button type="submit"
                    class="comment-submit-button mt-2">
                    コメントする
                </button>
            </form>
            {{-- コメント一覧（アンカー付き） --}}
            <h2 id="comments-section" class="text-xl font-semibold mb-2 mt-6">コメント</h2>
            <div class="mb-6">
                @forelse ($product->comments as $comment)
                <div class="border-b py-2">
                    <p class="text-sm text-gray-600">{{ $comment->user->name }}</p>
                    <p>{{ $comment->content }}</p>
                </div>
                @empty
                <p class="text-gray-500">まだコメントはありません。</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('like-btn').addEventListener('click', function() {
        const productId = this.dataset.productId;

        fetch(`/products/${productId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                this.textContent = data.liked ? '❤️ いいね済み' : '🤍 いいね';
            });
    });
</script>
@endsection