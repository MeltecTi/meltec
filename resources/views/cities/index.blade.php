@extends('layouts.dashboard')

@section('title', $title)

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h2 class="card-title">{{ _($title) }}</h2>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNew">
                        {{ _('Nueva Ubicación') }}
                    </button>
                </div>
                <div class="table-responsive" id="listadoCiudades">

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar-->
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" id="modalEditContent">
                <div class="loader3">
                    @include('includes.dashboard.loader')
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Crear-->
    <div class="modal fade" id="modalNew" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" id="modalNewContent">
                <div class="modal-header">
                    <h5 class="modal-title">{{ _('Agregar nueva Ciudad') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {!! Form::open(['id' => 'formNewCity']) !!}
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        {!! Form::text('name', null, [
                            'class' => 'form-control',
                            'id' => 'titleCity',
                        ]) !!}
                        <label for="titleBlog">{{ _('Ciudad') }}</label>
                    </div>

                    <div class="form-floating mb-3">
                        {!! Form::textarea('dataCity', null, [
                            'class' => 'form-control',
                            'id' => 'contentCity',
                            'style' => 'height: 250px; line-height: normal;',
                        ]) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{_('Cerrar')}}</button>
                    <button type="submit" class="btn btn-primary" id="sendCity">{{ _('Guardar') }}</button>
                </div>
                {!! Form::close() !!}
                <div class="loader2">
                    @include('includes.dashboard.loader')
                </div>
            </div>
        </div>
    </div>


    @vite(['resources/js/custom/city/index.js'])
@endsection
