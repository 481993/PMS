<!doctype html>
<html lang="{{ App::getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="{{ asset('public/img/favicon.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('public/img/favicon.png') }}">
    <meta name="keyword" content="{{ setting('meta_keyword') }}">
    <meta name="description" content="{{ setting('meta_description') }}">

    <!-- Shortcut Icon -->
    <link rel="shortcut icon" href="{{ asset('public/img/favicon.png') }}">
    <link rel="icon" type="image/ico" href="{{ asset('public/img/favicon.png') }}" />


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type = "image/x-icon" href="{{ asset('img/iWork_icons.svg') }}" /><title>@yield('title') | {{ config('app.name') }}</title>

    @stack('before-styles')

    <link rel="stylesheet" href="{{ mix('css/backend.css') }}">

    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+Bengali+UI&display=swap" rel="stylesheet" />

    <style>
        body {
            font-family: Ubuntu, "Noto Sans Bengali UI", Arial, Helvetica, sans-serif
        }

    </style>

    @stack('after-styles')

    <x-google-analytics />

    @livewireStyles

</head>

<body class="c-app">

    <!-- Sidebar -->
    @include('backend.includes.sidebar')
    <!-- /Sidebar -->

    <div class="c-wrapper">

        <!-- Header Block -->
        @include('backend.includes.header')
        <!-- / Header Block -->

        <div class="c-body">
            <main class="c-main">
                <div class="container-fluid">

                    <div class="animated fadeIn">

                        @include('flash::message')

                        <!-- Errors block -->
                        @include('backend.includes.errors')
                        <!-- / Errors block -->

                        <!-- Main content block -->
                        @yield('content')
                        <!-- / Main content block -->

                    </div>
                </div>
            </main>
        </div>

        <!-- Footer block -->
        @include('backend.includes.footer')
        <!-- / Footer block -->

        <!-- Scripts -->
        @stack('before-scripts')

        <script src="{{ mix('js/backend.js') }}"></script>

        @livewireScripts

        @stack('after-scripts')
        <!-- / Scripts -->
        <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
       
</body>

</html>
