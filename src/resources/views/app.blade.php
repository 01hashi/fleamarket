<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('css')
</head>

<body>
    <header>
        <a class="header__link" href="/">
            <img class="header__logo" src="{{ asset('img/logo.svg') }}">
        </a>
        @if (!request()->is('register','login','email/verify','purchase/address/*','sell'))
            <form class="header__search" action="/search" method="get">
                @csrf
                <input class="search__item" type="text" name="searchText" placeholder="なにをお探しですか？">
            </form>
            <nav class="header__nav">
                <ul class="nav__list">
                    @if (Auth::check())
                        <form action="/logout" method="post">
                            @csrf
                            <li class="nav__item"><button type="submit" class="nav__item-button">ログアウト</button></li>
                        </form>
                        <li class="nav__item"><a href="/mypage" class="nav__item-link">マイページ</a></li>
                    @else
                        <li class="nav__item"><a href="/login" class="nav__item-link">ログイン</a></li>
                        <li class="nav__item"><a href="/register" class="nav__item-link">会員登録</a></li>
                    @endif
                    <li class="nav__item"><a href="/sell" class="nav__item-link nav__item-link-sell">出品</a></li>
                </ul>
            </nav>

            <a class="search-link">
                <img class="search-icon" src="{{ asset('img/search.svg') }}">
            </a>

            <input type="checkbox" class="menu-btn" id="menu-btn">
            <label for="menu-btn" class="menu-icon"><span class="navicon"></span></label>
            <ul class="menu__list">
                @if (Auth::check())
                    <form action="/logout" method="post">
                        @csrf
                        <li class="menu__item"><button type="submit" class="menu__item-button">ログアウト</button></li>
                    </form>
                    <li class="menu__item"><a href="/mypage" class="menu__item-link">マイページ</a></li>
                @else
                    <li class="menu__item"><a href="/login" class="menu__item-link">ログイン</a></li>
                    <li class="menu__item"><a href="/register" class="menu__item-link">会員登録</a></li>
                @endif
                <li class="menu__item"><a href="/sell" class="menu__item-link">出品</a></li>
            </ul>
        @endif
    </header>

    <main>
        <form class="search-form" id="search-form" action="/search" method="get" style="display: none;">
            @csrf
            <input class="search-input" type="text" name="searchText" placeholder="なにをお探しですか？">
        </form>

        <script>
            document.querySelector('.search-link').addEventListener('click', function() {
                var searchForm = document.getElementById('search-form');
                if (searchForm.style.display === 'none' || searchForm.style.display === '') {
                    searchForm.style.display = 'block';
                } else {
                    searchForm.style.display = 'none';
                }
            });
        </script>
        @yield('main')
    </main>
</body>
</html>