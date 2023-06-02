@extends('layouts.dashboard')
@vite(['resources/css/card.css'])

@section('title', $title)

@if (count($gallery) === 0)
    @section('content')
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h2 class="card-title">{{ _($title) }}</h2>
                        <button type="button" class="btn btn-lg btn-primary" data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop">
                            {{ _('Subir Imagenes') }}
                        </button>
                    </div>
                    <p class="lead text-center">
                        {{ _('No hay contenido para Mostrar') }}
                    </p>
                </div>
            </div>
        </div>
    @endsection
@else
    @section('content')
        {{-- Tabla  --}}
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h2 class="card-title">{{ _($title) }}</h2>
                        <button type="button" class="btn btn-lg btn-primary" data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop">
                            {{ _('Subir Imagenes') }}
                        </button>
                    </div>

                    <div class="container text-center">
                        <div class="row row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 m-3" id="sectionImages">

                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Fin tabla --}}
    @endsection
@endif

@vite(['resources/js/custom/gallery/app.js'])


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ _('Galeria de Imagenes') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {!! Form::open([
                    'route' => ['gallery.store'],
                    'method' => 'POST',
                    'files' => true,
                    'class' => 'dropzone',
                    'id' => 'my-great-dropzone',
                ]) !!}

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cerrar') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>


