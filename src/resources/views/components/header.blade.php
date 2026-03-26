<header>
    <div class="header-bar">

        {{-- 左：ロゴ --}}
        <div class="header-left">
            <a href="/">
                <img src="{{ asset('storage/coachtech-logo.png') }}" alt="COACHTECH" class="header-logo">
            </a>
        </div>

        {{-- 中央：検索フォーム --}}
        <div class="header-center">
            <form action="{{ route('products.index') }}" method="GET" class="search-form">
                <input type="text" name="keyword" class="search-input" placeholder="何をお探しですか？">
            </form>
        </div>

        {{-- 右：ログイン/ログアウト・マイページ・出品 --}}
        <div class="header-right">

            @guest
            <a href="{{ route('login') }}">ログイン</a>
            <a href="{{ route('register') }}">会員登録</a>
            @else
            {{-- ログアウトは POST で送る --}}
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="logout-btn" style="background:none;border:none;color:#fff;cursor:pointer;">
                    ログアウト
                </button>
            </form>

            <a href="/mypage">マイページ</a>
            @endguest

            <a href="/sell" class="sell-btn">出品</a>
        </div>
    </div>
</header>