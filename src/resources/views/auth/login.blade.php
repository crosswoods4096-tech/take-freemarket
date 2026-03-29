@extends('layouts.easyapp')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="w-100" style="max-width: 420px;">

        {{-- タイトル --}}
        <h2 style="margin-top: 20px; text-align:center; font-weight:bold;">
            ログイン
        </h2>

        {{-- 入力フォーム --}}
        <form action="{{ route('login.post') }}" method="POST">
            @csrf

            {{-- メールアドレス --}}
            <div class="mb-3">
                <label for="email" class="form-label">メールアドレス</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            {{-- パスワード --}}
            <div class="mb-4">
                <label for="password" class="form-label">パスワード</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            {{-- ログインボタン --}}
            <div class="d-grid mb-3">
                <button class="btn px-4"
                    style="background-color: #ff5555; color: #fff; font-weight: bold;">
                    ログイン
                </button>
            </div>

            {{-- 会員登録へのリンク --}}
            <div class="text-center">
                <a href="{{ route('register') }}" class="text-muted" style="font-size: 0.9rem;">
                    会員登録はこちら
                </a>
            </div>

        </form>
    </div>
</div>
@endsection