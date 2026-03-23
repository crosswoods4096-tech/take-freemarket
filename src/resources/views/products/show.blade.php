@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">

    {{-- 上部ヘッダー（商品一覧と共通） --}}
    @include('components.header')

    <div class="flex mt-8">

        {{-- 左半分：商品画像 --}}
        <div class="w-1/2 pr-6">
            <img src="{{ asset('storage/' . $product->image_path) }}"
                alt="{{ $product->name }}"
                class="w-full h-auto rounded-lg shadow">
        </div>

        {{-- 右半分：商品情報 --}}
        <div class="w-1/2 pl-6">

            {{-- 商品名 --}}
            <h1 class="text-3xl font-bold mb-2">{{ $product->name }}</h1>

            {{-- ブランド名 --}}
            <p class="text-gray-500 text-sm mb-4">{{ $product->brand }}</p>

            {{-- 税込・税抜切替（ラジオボタン） --}}
            <div class="mb-4">
                <label class="mr-4">
                    <input type="radio" name="price_type" value="tax_in" checked>
                    税込：¥{{ number_format($product->price_tax_in) }}
                </label>
                <label>
                    <input type="radio" name="price_type" value="tax_out">
                    税抜：¥{{ number_format($product->price_tax_out) }}
                </label>
            </div>

            {{-- いいね & コメントアイコン --}}
            <div class="flex items-center mb-6">
                <button class="mr-4 text-red-500 text-2xl">❤️</button>
                <button class="text-blue-500 text-2xl">💬</button>
            </div>

            {{-- 購入ボタン（横幅いっぱい） --}}
            <a href="{{ route('purchase.index', $product->id) }}"
                class="block w-full bg-black text-white text-center py-3 rounded-lg mb-6">
                購入画面へ進む
            </a>

            {{-- 商品説明 --}}
            <h2 class="text-xl font-semibold mb-2">商品説明</h2>
            <p class="mb-6 whitespace-pre-line">{{ $product->description }}</p>

            {{-- 商品情報（カテゴリ・状態） --}}
            <h2 class="text-xl font-semibold mb-2">商品の情報</h2>
            <div class="mb-6">
                <p><span class="font-bold">カテゴリ：</span>{{ $product->category->name }}</p>
                <p><span class="font-bold">状態：</span>{{ $product->condition }}</p>
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
            <form action="{{ route('comments.store', $product->id) }}" method="POST">
                @csrf
                <textarea name="content" rows="3"
                    class="w-full border rounded-lg p-2 mb-3"
                    placeholder="コメントを入力してください"></textarea>
                <button class="bg-blue-500 text-white px-4 py-2 rounded-lg">
                    コメントを投稿する
                </button>
            </form>

        </div>
    </div>
</div>
@endsection