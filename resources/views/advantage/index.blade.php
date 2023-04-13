@extends('layouts.dashboard')

@section('title', $title)

@if (count($advantage) === 0)
    @section('content')
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h2 class="card-title">{{ _($title) }}</h2>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            {{ _('Nueva Ventaja') }}
                        </button>
                    </div>
                    <p class="lead text-center">
                        {{ _('No hay contenido para Mostrar') }}
                    </p>
                </div>
            </div>
        </div>
    @endsection
@endif
@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h2 class="card-title">{{ _($title) }}</h2>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        {{ _('Nueva Ventaja') }}
                    </button>
                </div>
                <div class="table-responsive" id="listadoVentajas">

                </div>
                <div class="pagination justify-content-end">
                    {!! $advantage->links() !!}
                </div>
            </div>
        </div>
    </div>
    <div class="loader">
        @include('includes.dashboard.loader')
    </div>
@endsection


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ _('Nueva Ventaja') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(['route' => 'ventajas.store', 'method' => 'POST', 'id' => 'formAdd']) !!}
            <div class="modal-body">
                <div class="form-floating mb-3">
                    {!! Form::text('title', null, [
                        'class' => 'form-control',
                        'placeholder' => 'Titulo de la Entrada',
                        'id' => 'titleAdv',
                        'data-field' => 'Titulo de la Ventaja',
                    ]) !!}
                    <label for="titleBlog">{{ _('Titulo de la Ventaja') }}</label>
                </div>

                <div class="form-floating mb-3">
                    {!! Form::textarea('content', null, [
                        'class' => 'form-control',
                        'placeholder' => 'Contenido de la Entrada',
                        'id' => 'contentAdv',
                        'style' => 'height: 250px; line-height: normal;',
                        'data-field' => 'Contenido de la Ventaja',
                    ]) !!}
                    <label for="contentBlog">{{ _('Contenido') }}</label>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ _('Cerrar') }}</button>
                <button type="submit" class="btn btn-primary"> {{ _('Crear Ventaja') }} </button>
            </div>
            {!! Form::close() !!}
            <div class="loader2">
                @include('includes.dashboard.loader')
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar-->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="modalEditContent">
    <div class="loader3">
        @include('includes.dashboard.loader')
    </div>
    </div>
  </div>
</div>

@vite(['resources/js/custom/advantage/index.js'])
