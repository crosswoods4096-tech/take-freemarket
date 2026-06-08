@php
$purchasedProducts = $purchasedProducts ?? collect();
@endphp
@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/products/index.css') }}">
@endsection

@section('content')
<div class="max-w-6xl mx-auto px-4">

    {{-- タブ --}}
    <div class="d-flex gap-4 mb-3">

        {{-- おすすめタブ --}}
        <a href="{{ route('products.index', ['tab' => 'recommend']) }}"
            class="tab-link {{ request('tab') === 'recommend' ? 'active' : '' }}">
            おすすめ
        </a>

        {{-- マイリストタブ --}}
        <a href="{{ route('products.mylist') }}"
            class="tab-link {{ request()->routeIs('products.mylist') ? 'active' : '' }}">
            マイリスト
        </a>
    </div>


    {{-- いいねした商品 --}}
    <h2>いいねした商品</h2>
    <div class="product-container">
        @forelse ($products as $product)
        <div class="product-card">
            @include('components.product-card', ['product' => $product])

            {{-- 購入済みなら SOLD --}}
            @if ($product->deal)
            <span class="sold-badge">SOLD</span>
            @endif
        </div>
        @empty
        <p class="text-gray-500">まだいいねした商品がありません。</p>
        @endforelse
    </div>

    {{-- 購入済み商品 --}}
    <h2 class="mt-4">購入済み商品</h2>
    <div class="product-container">
        @forelse ($purchasedProducts as $product)
        <div class="product-card">
            @include('components.product-card', ['product' => $product])
            <span class="sold-badge">SOLD</span>
        </div>
        @empty
        <p class="text-gray-500">まだ購入した商品がありません。</p>
        @endforelse
    </div>

</div>
@endsection