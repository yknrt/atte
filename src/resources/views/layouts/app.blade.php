<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atte</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css')}}">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="header-ttl">
                <a class="header__logo" href="/">
                    Atte
                </a>
            </div>
            <nav>
                <ul class="header-nav">
                    @yield('nav')
                </ul>
            </nav>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
    <footer class="footer">
        <div class="footer_inner">
            <small>Atte,inc.</small>
        </div>
    </footer>
</body>

</html>

