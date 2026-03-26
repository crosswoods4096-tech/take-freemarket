<header>
    {{-- ===========================
      ヘッダー
    =========================== --}}
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
</header>