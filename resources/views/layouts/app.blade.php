<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>
        <link rel="stylesheet" href="{{ asset('css/prisim.css', 'vendor/settings') }}">
        <script src="{{ asset('/js/prisim.js') }}"></script>
        <!-- Styles -->
        <link href="{{ mix('css/app.css', 'vendor/settings') }}" rel="stylesheet">
    </head>
    <body>
        @stack('pre-vue')
        <div id="app">
            @yield('content')
        </div>
        <!-- Scripts -->
        <script src="{{ mix('js/app.js', 'vendor/settings') }}"></script>
        @stack('scripts')
    </body>
</html>
