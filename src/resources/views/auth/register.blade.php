@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="w-100" style="max-width: 420px;">

        {{-- タイトル --}}
        <h2 class="text-center mb-4">会員登録</h2>

        {{-- 入力フォーム --}}
        <form action="{{ route('register.post') }}" method="POST">
            @csrf

            {{-- ユーザー名 --}}
            <div class="mb-3">
                <label for="name" class="form-label">ユーザー名</label>
                <input type="text" name="name" id="name" class="form-control">
                @error('name')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            {{-- メールアドレス --}}
            <div class="mb-3">
                <label for="email" class="form-label">メールアドレス</label>
                <input type="text" name="email" id="email" class="form-control">
                @error('email')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            {{-- パスワード --}}
            <div class="mb-3">
                <label for="password" class="form-label">パスワード</label>
                <input type="password" name="password" id="password" class="form-control">
                @error('password')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            {{-- 確認用パスワード --}}
            <div class="mb-4">
                <label for="password_confirmation" class="form-label">確認用パスワード</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                @error('password_confirmation')
                <div class="text-danger small">{{ $message }}</div>
                @enderror

            </div>

            {{-- 会員登録ボタン --}}
            <div class="d-grid mb-3">
                <button class="btn btn-primary py-2">会員登録</button>
            </div>

            {{-- ログイン画面へのリンク --}}
            <div class="text-center">
                <a href="{{ route('login') }}" class="text-muted" style="font-size: 0.9rem;">
                    ログインはこちら
                </a>
            </div>

        </form>
    </div>
</div>
@endsection