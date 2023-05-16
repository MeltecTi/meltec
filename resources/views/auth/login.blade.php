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

                            <div class="mt-3 d-grid gap-2">
                                <button type="submit"
                                    class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">{{ _('Ingresar') }}</button>
                            </div>

                            {!! Form::close() !!}
                            <div class="mt-3 d-grid gap-2">
                                <a href="{{ url('/login-google') }}" class="btn btn-block btn-google auth-form-btn">
                                    <i class="ti-google me-2"></i>{{ _('Ingresar con Google') }}
                                </a>
                            </div>

                            <div class="text-center mt-4 fw-light">
                                <a href="{{ url('/') }}"
                                    class="text-primary">{{ _('Volver a la Pagina Principal') }}</a>
                            </div>


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
