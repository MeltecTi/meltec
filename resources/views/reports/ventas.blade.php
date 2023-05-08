@extends('layouts.presentation')

<style>
    .scroll-container {
        height: 30vh;
        overflow: hidden;
    }

    .scroll-list {
        width: 100%;
        list-style-type: none;
        height: auto;
        overflow: hidden;
        animation: scroll 40s linear infinite;
    }

    .scroll-list li {
        padding: 10px;
        border: 0;
    }

    @keyframes scroll {
        0% {
            transform: translateY(0);
        }

        100% {
            transform: translateY(-100%);
        }
    }
</style>

@section('title', $title)


@section('content')
    {{-- Ventas Diarias y dia Anterior --}}
    <div class="d-flex justify-content-between">
        <h2>{{ _($title . ' - Reporte de Ventas Diario y Semanal ') }}</h2>
        @if (Auth::check())
            <a href="{{ url('/home/reports') }}" class="btn btn-primary">{{ _('Volver a los reportes') }}</a>
        @endif
    </div>
    <div class="col-md-12 mt-3 mb-5">
        <div class="card">
            <div class="card-body">
                <div class="header">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <img src="{{ asset('img/logos/Meltec.png') }}" alt="Logo Meltec" class="img-fluid">
                        </div>
                        <div class="col-md-10">
                            <h1 class="text-center">{{ _('Ventas Diarias') }}</h1>
                            <p class="text-center fs-4" id="dinamicDate">{{ date('d - M - Y') }}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="scroll-container pt-3">
                            <ul class="scroll-list" id="listItemsData">
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row mb-5 pt-3">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="text-center" id="ventasHoyValorTotal"></h3>
                                        <h4 class="text-center">{{ _('Ventas Hoy') }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="text-center" id="ventasHDiaAnteriorValorTotal"></h3>
                                        <h4 class="text-center">{{ _('Ventas Dia Anterior') }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5 pb-3">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body pt-5 pb-5">
                                        <h3 class="text-center" id="ventaSemanalValorTotal"></h3>
                                        <h4 class="text-center">{{ _('Ventas Semana') }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body pt-5 pb-5">
                                        <h3 class="text-center" id="SemanaAnterior"></h3>
                                        <h4 class="text-center">{{ _('Ventas Semana Pasada') }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="progress mt-3 mb-3" role="progressbar" aria-label="Proggres Meltec 2023"
                            aria-valuemin="0" aria-valuemax="100" style="height: 50px;" id="progressBar">
                        </div>
                    </div>
                </div>

                {{-- Graficas con Slider --}}


                <div id="carouselExampleSlidesOnly" class="carousel slide mt-3" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <h3 class="text-center">{{ _('Ventas del Dia vs Dia Anterior') }}</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <canvas id="graficaid" width="1190" height="595"></canvas>
                                </div>
                                <div class="col-md-6">
                                    <canvas id="diaAnterior" width="1190" height="595"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <h3 class="text-center">{{ _('Ventas Semana vs Semana Anterior') }}</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <canvas id="ventasSemana" width="1190" height="595"></canvas>
                                </div>
                                <div class="col-md-6">
                                    <canvas id="ventasSemanaAnterior" width="1190" height="595"></canvas>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="carousel-item">
                            Hola desde Slider 3
                        </div> --}}
                    </div>
                </div>


            </div>
        </div>
    </div>

@endsection
@vite(['resources/js/sapApi/ventas.js'])
@vite(['resources/js/newsapapi.js'])
@vite(['resources/js/sapApi/ventasDia.js'])
@vite(['resources/js/sapApi/ventasDiaAnterior.js'])
@vite(['resources/js/sapApi/ventasSemana.js'])
@vite(['resources/js/sapApi/ventasSemanaAnterior.js'])
