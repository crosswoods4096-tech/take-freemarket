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
        <a href="{{ route('products.show', $product->id) }}">
            <img src="{{ $product->image_path }}" alt="{{ $product->name }}">
        </a>

        {{-- 商品名 --}}
        <div class="product-name">
            {{ $product->name }}
        </div>

    </div>
    @endforeach

</div>

@endsection