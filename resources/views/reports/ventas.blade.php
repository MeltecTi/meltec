@extends('layouts.dashboard')

@section('title', $title)


@section('content')
    {{-- Ventas Diarias y dia Anterior --}}
    <div class="d-flex justify-content-between">
        <h2 class="card-title">{{ _($title) }}</h2>
    </div>
    <div class="col-md-6 mt-5">
        <div class="card">
            <div class="card-header">{{ __('Venta diaria ' . date('d-M-Y')) }}</div>
            <div class="card-body">
                <h3 id="tituloVentas"></h3>
                <canvas id="graficaid" width="800" height="800"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6 mt-5">
        <div class="card">
            <div class="card-header">{{ __('Venta dia anterior') }}</div>
            <div class="card-body">
                <h3 id="tituloDiaAnterior"></h3>
                <canvas id="diaAnterior" width="800" height="800"></canvas>
            </div>
        </div>
    </div>

    {{-- Ventas Semanales --}}
    <div class="col-md-6 mt-5 h-50">
        <div class="card">
            <div class="card-header">{{ _('Ventas de la semana') }}</div>
            <div class="card-body">
                <h3 id="tituloVentasSemanal" ></h3>
                <canvas id="ventasSemana" width="800" height="800"></canvas>
            </div>
        </div>
    </div>

    {{-- Ventas Anuales --}}
    <div class="col-md-6 mt-5">
        <div class="card">
            <div class="card-header">{{ __('Ventas anuales') }}</div>
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
    
@endsection
@vite(['resources/js/newsapapi.js'])
@vite(['resources/js/sapApi/ventasDia.js'])
@vite(['resources/js/sapApi/ventasDiaAnterior.js'])
@vite(['resources/js/sapApi/ventasSemana.js'])
