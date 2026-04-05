@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage/index.css') }}">
@endsection

@section('content')

<div class="mypage-container">

    {{-- 上部：プロフィール画像・ユーザー名・編集ボタン --}}
    <div class="profile-top">
        @if ($user->avatar)
        <img src="{{ asset('storage/' . $user->avatar) }}" class="profile-icon">
        @else
        <img src="{{ asset('storage/default-user.png') }}" class="profile-icon">
        @endif

        <div class="profile-info">
            <h2 class="profile-name">{{ $user->name }}</h2>
        </div>

        <a href="{{ route('mypage.edit') }}" class="edit-btn">プロフィールを編集</a>
    </div>

    {{-- タブ切り替えボタン --}}
    <div class="mypage-tabs flex gap-4 mb-6">
        <a href="{{ route('mypage', ['tab' => 'listed']) }}"
            class="mypage-tab {{ $tab === 'listed' ? 'active' : '' }}">
            出品した商品
        </a>

        <a href="{{ route('mypage', ['tab' => 'purchased']) }}"
            class="mypage-tab {{ $tab === 'purchased' ? 'active' : '' }}">
            購入した商品
        </a>
    </div>


    {{-- 出品した商品 --}}
    @if ($tab === 'listed')
    @foreach ($listedProducts as $product)
    <div class="product-card">
        <img src="{{ asset('storage/' . $product->image_path) }}" class="mypage-product-image">
        <p class="product-name">{{ $product->name }}</p>
    </div>
    @endforeach
    @endif


    {{-- 購入した商品 --}}
    @if ($tab === 'purchased')
    @foreach($purchasedProducts as $deal)
    <div class="border rounded-lg p-4 flex gap-4 items-center">
        <img src="{{ asset('storage/' . $deal->product->image_path) }}"
            class="w-24 h-24 object-cover rounded">
        <div>
            <p class="font-bold">{{ $deal->product->name }}</p>
            <p class="text-gray-600">¥{{ number_format($deal->product->price) }}</p>
        </div>
    </div>
    @endforeach
    @endif
</div>

</div>

@endsection