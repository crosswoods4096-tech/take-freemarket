@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/products/index.css') }}">
@endsection

@section('content')

{{-- ===========================
      タブ切り替え（おすすめ / マイリスト）
=========================== --}}
<div class="d-flex gap-4 mb-3">
    <a href="{{ route('products.recommend') }}"
        class="tab-link {{ request()->routeIs('products.recommend') ? 'active' : '' }}">
        おすすめ
    </a>

    <a href="{{ route('products.mylist') }}"
        class="tab-link {{ request()->routeIs('products.mylist') ? 'active' : '' }}">
        マイリスト
    </a>
</div>


{{-- ===========================
      商品一覧
=========================== --}}
<div class="product-container">

    @foreach ($products as $product)
    <div class="product-card">

        {{-- 商品画像 --}}
        <a href="{{ route('products.show', $product->id) }}" class="relative block">
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-image">

            @if($product->is_sold)
            <div class="absolute top-2 left-2 bg-black bg-opacity-70 text-white px-3 py-1 rounded">
                SOLD
            </div>
            @endif
        </a>

        {{-- 商品名 --}}
        <div class="product-name">
            {{ $product->name }}
        </div>

    </div>
    @endforeach

</div>

@endsection