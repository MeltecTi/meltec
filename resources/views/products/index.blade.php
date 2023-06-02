@extends('layouts.dashboard')
@section('title', $title)

@if (count($products) === 0)
    @section('content')
        <div class="d-flex justify-content-between">
            <h2 class="card-title">{{ _($title) }}</h2>
            <a href="{{ route('products.create') }}" class="btn btn-primary">{{ _('Nuevo Producto') }}</a>
        </div>
        <p>{{ _('No se ha registrado ningun producto')}}</p>
    @endsection
@endif
@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h2 class="card-title">{{ _($title) }}</h2>
                    <div class="d-grid gap-2 d-md-block">
                        <a href="{{ route('products.create') }}" class="btn btn-primary">{{ _('Nuevo Producto') }}</a>
                    </div>
                </div>
                <div class="table-responsive" id="dataApi">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ _('Producto') }}</th>
                                <th>{{ _('Resumen del Producto') }}</th>
                                <th>{{ _('Descripción') }}</th>
                                <th>{{ _('Imagen') }}</th>
                                <th>{{ _('Ficha Tecnica') }}</th>
                                <th>{{ _('Marca') }}</th>
                                <th>{{ _('Opciones') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
