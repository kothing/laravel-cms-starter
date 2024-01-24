<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('images/favicon.svg')}}">
    <link rel="icon" type="image/png" href="{{asset('images/favicon.svg')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>@yield('title') | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ setting('meta_description') }}">
    <meta name="keyword" content="{{ setting('meta_keyword') }}">
    @include('frontend.includes.meta')

    <!-- Shortcut Icon -->
    <link rel="shortcut icon" href="{{asset('images/favicon.svg')}}">
    <link rel="icon" type="image/ico" href="{{asset('images/favicon.svg')}}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/assets/css/app-frontend.scss', 'resources/assets/js/app-frontend.js'])

    @livewireStyles
    
    @stack('after-styles')

    <!-- <x-google-analytics \/> -->
</head>

<body>

    @include('frontend.includes.header')

    <main>
        @yield('content')
    </main>

    @include('frontend.includes.footer')

    <!-- Scripts -->
    @livewireScriptConfig
    @stack('after-scripts')
    <!-- / Scripts -->
</body>

</html>