<!-- resources/views/layouts/simple.blade.php -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/simple.css') }}">
</head>
<body>
    <header>
        <h1>@yield('header')</h1>
    </header>

    <main>
        @yield('content')
    </main>
</body>
</html>


