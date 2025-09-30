<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fleamarket Application</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://kit.fontawesome.com/e04190822e.js" crossorigin="anonymous"></script>
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="{{ url('/') }}">
                <img src="{{ asset('images/logo.svg') }}" alt="COACHTECH" class="logo-img">
            </a>
            <form class="search-form" action="{{ route('home') }}" method="GET">
                <input type="hidden" name="tab" value="{{ request('tab', 'recommended') }}">
                <input type="text" name="keyword" placeholder="なにをお探しですか？" class="search-input" value="{{ request('keyword') }}">
            </form>
            <div class="header-utilities">
                <nav>
                    <ul class="header-nav">
                        <li class="header-nav__item">
                            <a class="header-nav__link" href="/mypage">マイページ</a>
                        </li>

                        @auth
                        <li class="header-nav__item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="logout-link">ログアウト</button>
                            </form>
                        </li>
                        @endauth

                        @guest
                        <li class="header-nav__item">
                            <a href="{{ route('login') }}" class="login-link">ログイン</a>
                        </li>
                        @endguest
                    </ul>
                </nav>
                <a href="{{ route('sell') }}" class="btn-sell">出品</a>
            </div>
        </div>
    </header>


    <main>
        @yield('content')
    </main>
</body>

</html>
