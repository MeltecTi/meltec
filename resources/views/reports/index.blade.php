@extends('layouts.dashboard')
@section('title', $title)

@section('content')
    <div class="d-flex justify-content-between">
        <h2 class="card-title">{{ _($title) }}</h2>
    </div>
    <div class="col-md-8 mt-5">
        <div class="card">
            <div class="card-header">{{ __('Resumen de Ventas') }}</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-8 grid-margin">
                        <canvas id="grafica"></canvas>
                    </div>
                    <div class="col-lg-4 grid-margin">
                        <div id="sapdata" class="text-wrap"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mt-5">
        <div class="card">
            <div class="card-header">{{ __('Indice de Informes') }}</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="d-grid gap-2">
                            <a href="{{ url('home/reports/ventas') }}" class="btn btn-info">{{ _('Informe de Ventas '. date('Y')) }}</a>
                            <a href="#" class="btn btn-info">Hola desde un boton</a>
                            <a href="#" class="btn btn-info">Hola desde un boton</a>
                            <a href="#" class="btn btn-info">Hola desde un boton</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="d-grid gap-2">
                            <a href="#" class="btn btn-info">Hola desde un boton</a>
                            <a href="#" class="btn btn-info">Hola desde un boton</a>
                            <a href="#" class="btn btn-info">Hola desde un boton</a>
                            <a href="#" class="btn btn-info">Hola desde un boton</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@vite(['resources/js/newsapapi.js'])
