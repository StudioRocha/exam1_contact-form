<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>@yield('title', 'お問い合わせフォーム')</title>

        <!-- Reset CSS -->
        <link rel="stylesheet" href="https://unpkg.com/sanitize.css" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&display=swap"
            rel="stylesheet"
        />
        <link
            href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&display=swap"
            rel="stylesheet"
        />

        <!-- Styles -->
        <link href="{{ asset('css/common.css') }}" rel="stylesheet" />

        @stack('styles')
    </head>
    <body class="layout">
        <!-- Header -->
        <header class="layout__header">
            <div class="layout__header-container">
                <h1 class="layout__header-title">
                    <a href="{{ route('home') }}" class="layout__header-link">
                        FashionablyLate
                    </a>
                </h1>
            </div>
            <nav class="layout__header-login">
                @if(Route::currentRouteName() === 'login')
                <a
                    href="{{ route('register') }}"
                    class="layout__header-nav-link"
                    >register</a
                >
                @elseif(Route::currentRouteName() === 'register')
                <a href="{{ route('login') }}" class="layout__header-nav-link"
                    >login</a
                >
                @elseif(in_array(Route::currentRouteName(), ['home',
                'contact.confirm', 'contact.thanks']))
                {{-- 認証ページ以外では何も表示しない --}}
                @else @auth
                <form
                    method="POST"
                    action="{{ route('logout') }}"
                    style="display: inline"
                >
                    @csrf
                    <button type="submit" class="layout__header-nav-link">
                        logout
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}" class="layout__header-nav-link"
                    >login</a
                >
                @endauth @endif
            </nav>
        </header>

        <!-- Main Content -->
        <div class="viewport-fit">
            <main class="layout__main">@yield('content')</main>
        </div>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
        @stack('scripts')
    </body>
</html>
