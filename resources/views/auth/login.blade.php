<!DOCTYPE html>
<html lang="en">

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
    @vite(['resources/css/vertical-layout-light/style.css', 'resources/vendors/css/vendor.bundle.base.css', 'resources/vendors/simple-line-icons/css/simple-line-icons.css', 'resources/vendors/typicons/typicons.css', 'resources/vendors/ti-icons/css/themify-icons.css', 'resources/vendors/mdi/css/materialdesignicons.min.css', 'resources/vendors/feather/feather.css'])
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('img/logos/Meltec.png') }}" />
</head>


<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo">
                                <img src="{{ asset('img/logos/Meltec.png') }}" alt="logo">
                            </div>
                            <h4>{{ \Carbon\Carbon::now()->subHours(5)->get('hour') >= '12'? _('Buenas Tardes'): _('Buenos Dias') }}
                                {{ _('Familia Meltec') }} </h4>
                            <h6 class="fw-light">{{ _('Ingresa tus Credenciales') }}</h6>

                            {!! Form::open(['route' => 'login', 'method' => 'POST'], ['class' => 'pt-3']) !!}

                            <div class="form-floating mb-3 ">
                                {!! Form::email('email', old('email'), [
                                    'class' => 'form-control',
                                    'placeholder' => 'correo@correo.com',
                                    'id' => 'email',
                                    'required' => true,
                                    'autocomplete' => 'email',
                                    'autofocus' => true,
                                ]) !!}
                                <label for="email">{{ _('Correo electronico') }}</label>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-floating mb-3">
                                {!! Form::password('password', [
                                    'class' => 'form-control',
                                    'id' => 'password',
                                    'required' => true,
                                    'autocomplete' => 'current-password',
                                ]) !!}
                                <label for="email">{{ _('Contraseña') }}</label>
                            </div>

                            <div class="mt-3">
                                <button type="submit"
                                    class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">{{ _('Ingresar') }}</button>
                            </div>

                            <div class="text-center mt-4 fw-light">
                                <a href="{{ url('/') }}" class="text-primary">{{ _('Volver a la Pagina Principal') }}</a>
                            </div>

                            {!! Form::close() !!}

                            {{-- <form class="pt-3">
                                
                                <div class="my-2 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <label class="form-check-label text-muted">
                                            <input type="checkbox" class="form-check-input">
                                            Keep me signed in
                                        </label>
                                    </div>
                                    <a href="#" class="auth-link text-black">Forgot password?</a>
                                </div>
                                <div class="mb-2">
                                    <button type="button" class="btn btn-block btn-facebook auth-form-btn">
                                        <i class="ti-facebook me-2"></i>Connect using facebook
                                    </button>
                                </div>
                                
                            </form> --}}
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>

    @include('includes.dashboard.scripts')
</body>

</html>


{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf


                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
