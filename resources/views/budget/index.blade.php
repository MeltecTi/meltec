@extends('layouts.dashboard')

@section('title', $title)

@section('content')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                @if (session('success'))
                    <div id="alertContainer" class="alert alert-success fade show" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div id="alertContainer" class="alert alert-danger fade show" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="d-flex justify-content-between">
                    <h2 class="card-title">{{ _($title) }}</h2>
                    <div class="d-grid gap-2 d-md-block">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            {{ _('Importar mediante Excel') }}
                        </button>
                    </div>
                </div>
                <div class="table-responsive mt-3" id="data">

                </div>

                <div class="d-grid mt-3 gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('budgets.export') }}" class="btn btn-primary">{{ _('Exportar a Excel') }}</a>
                    <a href="{{ route('budgets.exportTemplate') }}"
                        class="btn btn-info">{{ _('Descargar Plantilla de Subida de datos') }}</a>
                </div>

            </div>
        </div>
    </div>
@endsection

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    id="myModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">{{ _('Importar Datos') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => ['budgets.store'], 'method' => 'POST', 'files' => true]) !!}
                {!! Form::file('excel', [
                    'class' => 'form-control form-control-lg',
                    'id' => 'formFile',
                    'accept' => '.csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel',
                ]) !!}

                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <button type="submit" class="btn btn-primary">{{ _('Importar Excel') }}</button>
                </div>
                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ _('Cerrar') }}</button>
            </div>
        </div>
    </div>
</div>


@vite(['resources/js/custom/budget/imports.js'])