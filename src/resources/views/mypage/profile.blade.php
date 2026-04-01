@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage/profile.css') }}">
@endsection

@section('content')


<div class="profile-container">

    {{-- タイトル --}}
    <h2 class="profile-title">プロフィール設定</h2>

    <form action="{{ route('mypage.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- プロフィール画像 + ボタン --}}
        <div class="profile-image-area">
            @if ($user->avatar)
            <img src="{{ asset('storage/' . $user->avatar) }}" alt="プロフィール画像" class="profile-image">
            @else
            <img src="{{ asset('storage/default-user.png') }}" alt="プロフィール画像" class="profile-image">
            @endif

            <label class="image-select-btn">
                画像を選択する
                <input type="file" name="avatar" class="image-input">
            </label>
        </div>

        <label>ユーザー名</label>
        <input type="text" name="name" value="{{ $user->name }}">

        <label>郵便番号</label>
        <input type="text" name="postcord" value="{{ $user->postcord }}">

        <label>住所</label>
        <input type="text" name="address" value="{{ $user->address }}">

        <label>建物名</label>
        <input type="text" name="building" value="{{ $user->building }}">

        <button type="submit" class="update-btn">更新</button>
    </form>
</div>

@endsection