<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>@yield('title') | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="title" content="@yield('title') | {{ config('app.name') }}" />
    <meta name="site_name" content="{{setting('meta_site_name')}}" />
    <meta name="url" content="{{url()->full()}}" />
    <meta name="description" content="{{ setting('meta_description') }}">
    <meta name="keyword" content="{{ setting('meta_keyword') }}">
    <meta name="image" content="{{ asset(setting('meta_image')) }}" />
    @include('frontend.includes.meta')

    <!-- Shortcut Icon -->
    <link rel="shortcut icon" href="{{asset('images/favicon.svg')}}">
    <link rel="icon" type="image/svg" href="{{asset('images/favicon.svg')}}" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('images/favicon.svg')}}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
    @vite(['resources/assets/css/app-frontend.scss'])
    @livewireStyles
    @stack('after-styles')
    <!-- / Styles -->

    <!-- <x-google-analytics \/> -->
</head>

<body>

    @include('frontend.includes.header')

    <main>
        @yield('content')
    </main>

    @include('frontend.includes.footer')

    <!-- Scripts -->
    <script src="{{asset('vendor/jquery/jquery@3.2.1-min.js')}}"></script>
    @vite(['resources/assets/js/app-frontend.js'])
    @livewireScriptConfig
    @stack('after-scripts')
    <!-- / Scripts -->
</body>

</html>