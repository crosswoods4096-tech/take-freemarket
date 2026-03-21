@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/products/index.css') }}">
@endsection

@section('content')

{{-- ===========================
      ヘッダー
=========================== --}}
<div class="header-bar">

    {{-- 左：ロゴ --}}
    <div class="header-left">
        <a href="/">
            <img src="{{ asset('storage/app/public/COACHTECHヘッダーロゴ.png') }}" alt="COACHTECH" class="header-logo">
        </a>
    </div>

    {{-- 中央：検索フォーム --}}
    <div class="header-center">
        <form action="{{ route('products.index') }}" method="GET" class="search-form">
            <input type="text" name="keyword" class="search-input" placeholder="何をお探しですか？">
            <!-- <button class="search-btn">検索</button> -->
        </form>
    </div>

    {{-- 右：ログイン/ログアウト・マイページ・出品 --}}
    <div class="header-right">

        @guest
        <a href="/login">ログイン</a>
        <a href="/register">マイページ</a>
        @else
        <a href="/logout">ログアウト</a>
        <a href="/mypage">マイページ</a>
        @endguest

        <a href="/sell" class="sell-btn">出品</a>
    </div>
</div>


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
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}">
        </a>

        {{-- 商品名 --}}
        <div class="product-name">
            {{ $product->title }}
        </div>

    </div>
    @endforeach

</div>

@endsection