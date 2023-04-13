@extends('layouts.dashboard')
@section('title', $title)

@section('content')
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="card-body">
                <h4 class="card-title">{{ $title }}</h4>
                {!! Form::open(['route' => ['usuarios.update', $user->id], 'method' => 'PUT', 'files' => true]) !!}

                <div class="form-floating mb-3">
                    {!! Form::text('name', $user->name, [
                        'class' => 'form-control',
                        'placeholder' => 'Nombre del Usuario',
                        'id' => 'nameUser',
                    ]) !!}
                    <label for="nameUser">{{ _('Nombre del Usuario') }}</label>
                </div>

                <div class="form-floating mb-3">
                    {!! Form::email('email', $user->email, [
                        'class' => 'form-control',
                        'placeholder' => 'Correo Electronico',
                        'id' => 'emailUser',
                    ]) !!}
                    <label for="emaiUser">{{ _('Correo electronico') }}</label>
                </div>

                <div class="form-floating mb-3">
                    {!! Form::password('password', ['class' => 'form-control', 'id' => 'password']) !!}
                    <label for="password">{{ _('Contraseña') }}</label>
                </div>

                <div class="form-floating mb-3">
                    {!! Form::password('confirm-password', ['class' => 'form-control', 'id' => 'c-password']) !!}
                    <label for="c-password">{{ _('Confirmar Contraseña') }}</label>
                </div>

                <div class="mb-3">
                    <label for="formFile" class="form-label">{{ _('Imagen') }}</label>
                    {!! Form::file('image', [
                        'class' => 'form-control form-control-lg',
                        'id' => 'formFile',
                        'accept' => 'image/png, image/jpeg, image/webp',
                    ]) !!}
                </div>

                <div class="form-floating mb-3">
                    {!! Form::select('roles[]', $roles, [], ['class' => 'form-control']) !!}
                    <label for="roles">{{ _('Roles y permisos del Usuario') }}</label>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <button type="submit" class="btn btn-primary">{{ _('Editar Usuario') }}</button>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
