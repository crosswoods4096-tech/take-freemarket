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
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($listedProducts as $product)
        <div class="border rounded-lg p-4 flex flex-col items-center">
            <img src="{{ asset('storage/' . $product->image_path) }}" class="mypage-product-image object-cover rounded mb-3">
            <p class="font-bold text-left">{{ $product->name }}</p>
        </div>
        @endforeach
    </div>
    @endif


    {{-- 購入した商品 --}}
    @if ($tab === 'purchased')
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($purchasedProducts as $deal)
        <div class="border rounded-lg p-4 flex flex-col items-center">
            <img src="{{ asset('storage/' . $deal->product->image_path) }}"
                class="mypage-purchased-image object-cover rounded mb-3">

            <p class="font-bold text-left">{{ $deal->product->name }}</p>

        </div>
        @endforeach
    </div>

    @endif
</div>

</div>

@endsection