@extends('layouts.dashboard')
@section('title', $title)

@section('content')
    <div class="d-flex justify-content-between">
        <h2 class="card-title">{{ _($title) }}</h2>
    </div>
    <div class="col-md-10 mt-5">


        <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item">
                    <iframe title="KPI MELTEC 2023 V3" width="100%" height="768"
                        src="https://app.powerbi.com/reportEmbed?reportId=34da48bd-c499-4800-980b-0f4d1d4ded8b&autoAuth=true&ctid=d396c4f8-3298-489e-8bd4-1df6b2a47184&navContentPaneEnabled=false"
                        frameborder="0" allowFullScreen="true"></iframe>
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-2 mt-5">
        <div class="card">
            <div class="card-header">{{ __('Indice de Informes') }}</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="d-grid gap-2">
                            <a href="{{ url('reportesSapMeltec/reports/ventas' . date('Y')) }}" class="btn btn-info"
                                target="_blank">{{ _('Informe de Ventas ' . date('Y')) }}</a>
                            <a href="#" class="btn btn-info">Hola desde un boton</a>
                            <a href="#" class="btn btn-info">Hola desde un boton</a>
                            <a href="#" class="btn btn-info">Hola desde un boton</a>
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
