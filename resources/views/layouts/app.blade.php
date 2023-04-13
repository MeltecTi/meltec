<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @yield('title') - {{ config('app.name', 'Meltec Comunicaciones S.A') }}</title>

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Rubik:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('/storage/favicon/favicon.png') }}" type="image/x-icon">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />


    <!-- Scripts Iniciales -->
    @vite(['resources/sass/app.scss', 'resources/css/app.css', 'resources/lib/owlcarousel/assets/owl.carousel.min.css', 'resources/lib/animate/animate.min.css'])
</head>

<body>
    <!-- Spinner Start -->
    @include('includes.spiner')
    <!-- Spinner End -->

    {{-- Condicion si el usuario esta logeado --}}
    @if(Auth::check())
        @include('includes.toolbar-login')
    @endif
    {{-- Fin condicion --}}

    <!-- Topbar Start -->
    @include('includes.toolbar')
    <!-- Topbar End -->

    <div class="container-fluid position-relative p-0">

        {{-- Navbar Start --}}
        @include('includes.navbar')
        
    {{-- Navbar End --}}

    @yield('content-header')
</div>

{{-- Search --}}
@include('includes.search')

<main class="py-4">
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        @yield('content')
    </div>
</main>

@include('includes.footer')

{{-- Librerias y Scrips --}}
@include('includes.scripts')

</body>


</html>
