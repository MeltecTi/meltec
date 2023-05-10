@extends('layouts.presentation')

@section('title', $title)

<style>
    .podium {
        display: flex;
    }
    .container_podium {
        display: flex;
        align-items: flex-end;
        justify-content: center;
    }

    .podium__item {
        width: 300px;
    }

    .podium__rank {
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 35px;
        color: #f3f3f3;
    }

    .podium__city {
        text-align: center;
        font-size: 20px;
        padding: 0 .5rem;
    }

    .podium__number {
        width: 100%;
        text-align: center;
        padding: 0 20px;
        font-size: 30px;
    }

    .podium .first {
        min-height: 400px;
        background: #81A3FF;
    }

    .podium .second {
        min-height: 275px;
        background: #FFAF9C;
    }

    .podium .third {
        min-height: 200px;
        background: #8BB352;
    }

    .code-loader {
        color: #fff;
        font-family: Consolas, Menlo, Monaco, monospace;
        font-weight: bold;
        font-size: 100px;
        opacity: 0.8;
        display: flex;
        justify-content: center;
    }

    .code-loader span {
        display: inline-block;
        animation: pulse_414 0.4s alternate infinite ease-in-out;
        color: #000000;
    }

    .code-loader span:nth-child(odd) {
        animation-delay: 0.4s;
    }

    @keyframes pulse_414 {
        to {
            transform: scale(0.8);
            opacity: 0.5;
        }
    }
</style>

@section('content')
    {{-- Ventas Diarias y dia Anterior --}}
    <div class="d-flex justify-content-between">
        <h2>{{ _($title . ' - Reporte de Ventas Diario y Semanal ') }}</h2>
        @if (Auth::check())
            <a href="{{ url('/home/reports') }}" class="btn btn-primary">{{ _('Volver a los reportes') }}</a>
        @endif
    </div>
    <div class="col-md-12 mb-5">
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

                <div class="col-12 mt-3 mb-3">
                    <h2 class="text-center">{{ _('Meta Anual') }}</h2>
                    <div class="progress mt-3 mb-3" role="progressbar" aria-label="Proggres Meltec 2023" aria-valuemin="0"
                        aria-valuemax="100" style="height: 50px;" id="progressBar">
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-md-6">
                        {{-- Podio de los 3 Primeros Comerciales --}}

                        <div id="podium">
                            <div class="container_podium podium" >
                                <div class="podium__item" id="second_podium">
                                    <h4 class="podium__city" id="second_saller"></h4>
                                    <div class="podium__rank second">
                                        <div class="podium__number" id="second_seller_value">

                                        </div>
                                    </div>
                                </div>
                                <div class="podium__item" id="podiun_one">
                                    <h4 class="podium__city" id="first_saller"></h4>
                                    <div class="podium__rank first">
                                        <div class="podium__number" id="first_seller_value">

                                        </div>
                                    </div>
                                </div>
                                <div class="podium__item" id="three_podium">
                                    <h4 class="podium__city" id="three_saller"></h4>
                                    <div class="podium__rank third">
                                        <div class="podium__number" id="three_seller_value">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <canvas id="graficaid" width="1190" height="400"></canvas>
                            </div>
                        </div>

                        <div class="load" id="loaderJson">
                            <div class="code-loader">
                                <span>{</span><span>}</span>
                            </div>
                            <h2 class="text-center">{{ _('No se han reportado ventas hasta el momento') }}</h2>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="row mb-5 pt-3">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body p-5">
                                        <h3 class="text-center" id="ventasHoyValorTotal"></h3>
                                        <h4 class="text-center">{{ _('Ventas Hoy') }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body p-5">
                                        <h3 class="text-center" id="ventasHDiaAnteriorValorTotal"></h3>
                                        <h4 class="text-center">{{ _('Ventas Dia Anterior') }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5 pb-3">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body p-5">
                                        <h3 class="text-center" id="ventaSemanalValorTotal"></h3>
                                        <h4 class="text-center">{{ _('Ventas Semana') }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body p-5">
                                        <h3 class="text-center" id="SemanaAnterior"></h3>
                                        <h4 class="text-center">{{ _('Ventas Semana Pasada') }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <canvas id="graficaUnidadesVenta" width="1190" height="500"></canvas>
                        </div>

                    </div>
                </div>


                {{-- Graficas con Slider --}}


                <div id="carouselExampleSlidesOnly" class="carousel slide mt-3" data-bs-ride="carousel" style="display: none;">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <h3 class="text-center">{{ _('Ventas del Dia vs Dia Anterior') }}</h3>
                            <div class="row">

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
