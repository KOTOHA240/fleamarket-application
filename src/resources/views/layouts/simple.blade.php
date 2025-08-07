<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'FashionablyLate')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- 必要なCSS -->
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>
<body>
    <header class="simple-header">
        <h1 class="logo">FashionablyLate</h1>
    </header>

    <main>
        @yield('content')
    </main>
</body>
</html>
