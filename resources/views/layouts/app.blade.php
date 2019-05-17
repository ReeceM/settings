<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        {{-- Page title --}}
        <title>@yield('title')</title>

        <link rel="stylesheet" href="{{ mix('css/prisim.css', 'vendor/settings') }}">
        <script src="{{ mix('js/prisim.js', 'vendor/settings') }}"></script>
        <!-- Styles -->
        <link href="{{ mix('css/app.css', 'vendor/settings') }}" rel="stylesheet">
                <!-- vue-prism-editor JavaScript -->
        <script src="https://unpkg.com/vue-prism-editor"></script>
        <!-- vue-prism-editor CSS -->
        <link rel="stylesheet" href="https://unpkg.com/vue-prism-editor/dist/VuePrismEditor.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    </head>
    <body class="w-full h-full bg-gray-200 shadow-inner">
        
        @includeWhen(session('settings.flash'), 'settings::partials.flash')

        @stack('pre-vue')
        <div id="app" class="container mx-auto">
            @yield('content')
        </div>
        
        <!-- Scripts -->
        <script src="{{ mix('js/app.js', 'vendor/settings') }}"></script>
        @stack('scripts')
    </body>
</html>
