@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4">

    {{-- タブ --}}
    <div class="flex gap-4 mb-6">
        <a href="{{ route('products.recommend') }}"
            class="{{ request()->routeIs('products.recommend') ? 'text-red-500 underline' : 'text-gray-600' }}">
            おすすめ
        </a>

        <a href="{{ route('products.mylist') }}"
            class="{{ request()->routeIs('products.mylist') ? 'text-red-500 underline' : 'text-gray-600' }}">
            マイリスト
        </a>
    </div>

    {{-- 商品カード一覧（商品一覧と同じデザイン） --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse ($products as $product)
        @include('components.product-card', ['product' => $product])
        @empty
        <p class="text-gray-500">まだいいねした商品がありません。</p>
        @endforelse
    </div>

</div>
@endsection