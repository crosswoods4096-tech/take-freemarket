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
        @method('PUT')



        {{-- プロフィール画像 + ボタン --}}
        <div class="profile-image-area">
            @if ($user->avatar)
            <img src="{{ asset('storage/' . $user->avatar) }}" alt="プロフィール画像" class="profile-image">
            @else
            <img src="{{ asset('storage/default-user.png') }}" class="profile-placeholder">
            @endif

            <label class="image-select-btn">
                画像を選択する
                <input type="file" name="avatar" class="image-input">
            </label>
        </div>

        <label>ユーザー名</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}">
        @error('name')
        <div class="text-danger">{{ $message }}</div>
        @enderror

        <label>郵便番号</label>
        <input type="text" name="postcode" value="{{ old('postcode', $user->postcode) }}">
        @error('postcode')
        <div class="text-danger">{{ $message }}</div>
        @enderror

        <label>住所</label>
        <input type="text" name="address" value="{{ old('address', $user->address) }}">
        @error('address')
        <div class="text-danger">{{ $message }}</div>
        @enderror

        <label>建物名</label>
        <input type="text" name="building" value="{{ old('building', $user->building) }}">

        <button type="submit" class="update-btn">更新する</button>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const avatarInput = document.querySelector('.image-input');
        const avatarPreview = document.querySelector('.profile-image, .profile-placeholder');


        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(event) {
                avatarPreview.src = event.target.result;
            };
            reader.readAsDataURL(file);
        });

    });
</script>

@endsection