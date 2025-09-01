<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>@yield('title', 'お問い合わせフォーム')</title>

        <!-- Fonts -->
        <link
            href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&display=swap"
            rel="stylesheet"
        />

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" />

        @stack('styles')
    </head>
    <body class="layout">
        <!-- Header -->
        <header class="layout__header">
            <div class="layout__header-container">
                <h1 class="layout__header-title">
                    <a href="{{ route('home') }}" class="layout__header-link">
                        お問い合わせフォーム
                    </a>
                </h1>
                <nav class="layout__header-nav">
                    <ul class="layout__header-nav-list">
                        <li class="layout__header-nav-item">
                            <a
                                href="{{ route('home') }}"
                                class="layout__header-nav-link"
                                >ホーム</a
                            >
                        </li>
                        <li class="layout__header-nav-item">
                            <a
                                href="{{ route('contact') }}"
                                class="layout__header-nav-link"
                                >お問い合わせ</a
                            >
                        </li>
                    </ul>
                </nav>
            </div>
        </header>

        <!-- Main Content -->
        <main class="layout__main">@yield('content')</main>

        <!-- Footer -->
        <footer class="layout__footer">
            <div class="layout__footer-container">
                <p class="layout__footer-text">
                    &copy; {{ date("Y") }} お問い合わせフォーム. All rights
                    reserved.
                </p>
            </div>
        </footer>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
        @stack('scripts')
    </body>
</html>
