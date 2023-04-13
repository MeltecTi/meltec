@extends('layouts.dashboard')

@section('title', $title)

@section('content')

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
            {!! Form::open(['route' => ['roles.update', $role->id], 'method' => 'PUT']) !!}

            <div class="form-group">
                <label for="nameRol">{{ _('Nombre del Rol') }}</label>
                {!! Form::text('name', $role->name, [
                    'class' => 'form-control',
                    'placeholder' => 'Nombre del Rol',
                    'id' => 'nameRol',
                ]) !!}
            </div>

            <div class="form-group">
                <label for="permissions">{{ _('Permisos') }}</label>
                <br/>
                @foreach ($permission as $p)
                    <label for="">{{ Form::checkbox('permission[]', $p->id, in_array($p->id, $rolePermission) ? true : false , ['class' => 'name']) }} {{ $p->name }}</label>
                    <br/>
                @endforeach
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <button type="submit" class="btn btn-primary">{{ _('Editar Rol') }}</button>
            </div>

            {!! Form::close() !!}
        </div>
    </div>

@endsection
