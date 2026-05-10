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
            <div class="search-form">
                <input type="text"
                    name="keyword"
                    form="searchForm"
                    class="search-input"
                    value="{{ request('keyword') }}"
                    placeholder="何をお探しですか？">
            </div>
        </div>

        <form id="searchForm" action="{{ route('products.index') }}" method="GET"></form>





        {{-- 右：ログイン/ログアウト・マイページ・出品 --}}
        <div class="header-right">

            @guest
            <a href="{{ route('login') }}">ログイン</a>
            <a href="{{ route('mypage') }}">マイページ</a>
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