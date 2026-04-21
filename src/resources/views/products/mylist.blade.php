@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/products/index.css') }}">
@endsection

@section('content')
<div class="max-w-6xl mx-auto px-4">

    {{-- タブ --}}
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

    {{-- 商品カード一覧（一覧ページと同じ構造） --}}
    <div class="product-container">
        @forelse ($products as $product)
        <div class="product-card">
            @include('components.product-card', ['product' => $product])
        </div>
        @empty
        <p class="text-gray-500">まだいいねした商品がありません。</p>
        @endforelse
    </div>



</div>
@endsection