@extends('layouts.dashboard')

@section('title', $title)

@section('content')


    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h2 class="card-title">{{ _($title) }}</h2>
                @can('crear-rol')
                    <div class="d-grid gap-2 d-md-block">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            {{ _('Crear nuevo Rol') }}
                        </button>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modalNewPermission">
                            {{ _('Agregar nuevos Permisos') }}
                        </button>
                    </div>
                @endcan
            </div>
            <div class="table-responsive" id="resulFetch">

            </div>
        </div>
    </div>



@endsection

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ _('Nuevo Rol') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {!! Form::open(['id' => 'createNewRol']) !!}

                <div class="form-floating mb-3">
                    {!! Form::text('name', null, [
                        'class' => 'form-control',
                        'placeholder' => 'Nombre del Rol',
                        'id' => 'nameRol',
                    ]) !!}
                    <label for="nameRol">{{ _('Nombre del Rol') }}</label>
                </div>

                <div class="form-group">
                    <label for="permissions">{{ _('Permisos') }}</label>
                    <br />
                    @foreach ($permission as $p)
                        <label for="">{{ Form::checkbox('permission[]', $p->id, false, ['class' => 'name']) }}
                            {{ $p->name }}</label>
                        <br />
                    @endforeach
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <button type="submit" class="btn btn-primary">{{ _('Crear Rol') }}</button>
                </div>

                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ _('Cerrar') }}</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal PARA AGREGAR PERMISOS -->
<div class="modal fade" id="modalNewPermission" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="modalNewPermissionpLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalNewPermissionLabel">{{ _('Nuevos Permisos') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createNewPermission">

                    <div class="form-floating mb-3">
                        {!! Form::text('name', null, [
                            'class' => 'form-control',
                            'id' => 'nameRol',
                        ]) !!}
                        <label for="nameRol">{{ _('Nombre del Rol') }}</label>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <button type="submit" class="btn btn-primary">{{ _('Agrergar') }}</button>
                    </div>

                </form>

                <div id="permisosAgregados">

                </div>
                <div id="loader">
                    @include('includes.dashboard.loader')
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ _('Cerrar') }}</button>
                <button type="button" class="btn btn-primary" id="createPermissions"
                    disabled>{{ _('Enviar permisos') }}</button>
            </div>
        </div>
    </div>
</div>
@vite(['resources/js/custom/rol/app.js'])
