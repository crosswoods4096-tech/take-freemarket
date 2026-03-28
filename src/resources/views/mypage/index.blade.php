@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage/index.css') }}">
@endsection

@section('content')

<div class="mypage-container">

    {{-- 上部：プロフィール画像・ユーザー名・編集ボタン --}}
    <div class="profile-top">
        <img src="{{ asset('storage/default-user.png') }}" class="profile-icon" alt="プロフィール画像">

        <div class="profile-info">
            <h2 class="profile-name">{{ $user->name }}</h2>
        </div>

        <a href="{{ route('mypage.edit') }}" class="edit-btn">プロフィールを編集</a>
    </div>

    {{-- タブ切り替え --}}
    <div class="tab-menu">
        <a href="{{ route('mypage.index', ['tab' => 'sell']) }}"
            class="tab {{ $tab === 'sell' ? 'active' : '' }}">
            出品した商品
        </a>

        <a href="{{ route('mypage.index', ['tab' => 'buy']) }}"
            class="tab {{ $tab === 'buy' ? 'active' : '' }}">
            購入した商品
        </a>
    </div>

    {{-- 黒い横線 --}}
    <hr class="divider">

    {{-- 商品一覧 --}}
    <div class="product-list">
        @foreach ($products as $product)
        <div class="product-card">
            <img src="{{ asset('storage/' . $product->image_path) }}" class="product-image">
            <p class="product-name">{{ $product->name }}</p>
        </div>
        @endforeach
    </div>

</div>

@endsection