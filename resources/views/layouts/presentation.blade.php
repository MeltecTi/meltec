<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title> @yield('title') - {{ config('app.name', 'Meltec Comunicaciones S.A') }}</title>

    <!-- plugins:css -->
    <link rel="stylesheet" href="">

    <!-- endinject -->

    <!-- inject:css -->
    @vite(['resources/css/sliderinfinito.css', 'resources/css/vertical-layout-light/style.css', 'resources/vendors/css/vendor.bundle.base.css', 'resources/vendors/simple-line-icons/css/simple-line-icons.css', 'resources/vendors/typicons/typicons.css', 'resources/vendors/ti-icons/css/themify-icons.css', 'resources/vendors/mdi/css/materialdesignicons.min.css', 'resources/vendors/feather/feather.css', 'resources/css/spiner.css', 'resources/css/loader.css', 'resources/css/403.css'])
    <!-- endinject -->
    <link rel="shortcut icon" href="images/favicon.png" />
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link href="https://unpkg.com/gridjs/dist/theme/mermaid.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="module" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
        crossorigin="anonymous"></script>
    @vite(['resources/js/app.js'])
    @viteReactRefresh
</head>

<body>
    @include('includes.dashboard.spiner')
    <div class="container-scroller" style="opacity: 0.2;" id="containerAll">
        {{-- <div class="container-fluid page-body-wrapper"> --}}
        <div class="container-fluid mx-auto p-4">
            @yield('content')
        </div>
        {{-- </div> --}}

    </div>


    @include('includes.dashboard.scripts')

</body>

</html>
