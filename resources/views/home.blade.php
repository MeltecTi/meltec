@extends('layouts.dashboard')

@section('title', $title)

@section('content')
    <div class="home-tab">
        <div class="tab-content tab-content-basic">

            {{-- Datos para la muestra de ventas resumidas --}}

            <div class="row">
                <div class="col-sm-12">
                    <div class="statistics-details d-flex align-items-center justify-content-between">
                        <div>
                            <p class="statistics-title">{{ _('Porcentaje de venta anual') }}</p>
                            <h3 class="rate-percentage" id="totalPercent"></h3>
                            {{-- Incremento con respecto al porcentaje del dia anterior --}}
                            <p class="text-danger d-flex"><i class="mdi mdi-menu-down"></i><span>-0.5%</span></p>
                        </div>
                        <div>
                            <p class="statistics-title">{{ _('Venta Diaria') }}</p>
                            <h3 class="rate-percentage" id="rateTodaySales"></h3>
                            {{-- Comparacion con respecto a la venta del dia anterior --}}
                            <p class="text-success d-flex"><i class="mdi mdi-menu-up"></i><span>+0.1%</span></p>
                        </div>
                        <div>
                            <p class="statistics-title">{{ _('Venta mas Grande del dia') }}</p>
                            <h3 class="rate-percentage" id="bestBuller"></h3>
                            <p class="text-danger d-flex"><i class="mdi mdi-menu-down"></i><span>68.8</span></p>
                        </div>
                        <div class="d-none d-md-block">
                            <p class="statistics-title">{{ _('Planeando Nueva Data') }}</p>
                            <h3 class="rate-percentage">2m:35s</h3>
                            <p class="text-success d-flex"><i class="mdi mdi-menu-down"></i><span>+0.8%</span></p>
                        </div>
                        
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 d-flex flex-column">
                    <div class="row flex-grow">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                                <div class="card-body">
                                    <div class="d-sm-flex justify-content-between align-items-start">
                                        <div>
                                            <h4 class="card-title card-title-dash">{{ _('Desglose de Ventas Mensuales') }}</h4>
                                            <p class="card-subtitle card-subtitle-dash">{{_('Resumen de ventas Anuales')}}</p>
                                        </div>
                                    </div>
                                    <div class="d-sm-flex align-items-center mt-1 justify-content-between">
                                        <div class="d-sm-flex align-items-center mt-4 justify-content-between">
                                            <h2 class="me-2 fw-bold" id="totalYearValue"></h2>
                                            <h4 class="me-2">COP</h4>
                                            {{-- Subida con respecto a la semana pasada --}}
                                            {{-- <h4 class="text-success">(+1.37%)</h4> --}}
                                        </div>
                                        <div class="me-3">
                                            <div id="marketing-overview-legend"></div>
                                        </div>
                                    </div>
                                    <div class="chartjs-bar-wrapper mt-3">
                                        <canvas id="marketingOverview"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 d-flex flex-column">
                    <div class="row flex-grow">
                        <div class="col-md-6 col-lg-12 grid-margin stretch-card">
                            <div class="card bg-primary card-rounded">
                                <div class="card-body pb-0">
                                    <h4 class="card-title card-title-dash text-white mb-4">Status Summary</h4>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <p class="status-summary-ight-white mb-1">Closed Value</p>
                                            <h2 class="text-info">357</h2>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="status-summary-chart-wrapper pb-4">
                                                <canvas id="status-summary"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="d-flex justify-content-between align-items-center mb-2 mb-sm-0">
                                                <div class="circle-progress-width">
                                                    <div id="totalVisitors" class="progressbar-js-circle pr-2"></div>
                                                </div>
                                                <div>
                                                    <p class="text-small mb-2">Total Visitors</p>
                                                    <h4 class="mb-0 fw-bold">26.80%</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="d-flex justify-content-between align-items-center mb-2 mb-sm-0">
                                                <div class="circle-progress-width">
                                                    <div id="totalVisitors" class="progressbar-js-circle pr-2"></div>
                                                </div>
                                                <div>
                                                    <p class="text-small mb-2">Total Visitors</p>
                                                    <h4 class="mb-0 fw-bold">26.80%</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                @if (auth()->user()->kpiViewAuthorization())
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">{{ __('Indices de KPI') }}</div>
                            <div class="card-body">
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                <div class="colorText">
                                    <iframe title="KPI MELTEC 2023 V3" width="100%" height="768"
                                        src="https://app.powerbi.com/reportEmbed?reportId=34da48bd-c499-4800-980b-0f4d1d4ded8b&autoAuth=true&ctid=d396c4f8-3298-489e-8bd4-1df6b2a47184&navContentPaneEnabled=false"
                                        frameborder="0" allowFullScreen="true"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@vite(['resources/js/home/app.js'])
