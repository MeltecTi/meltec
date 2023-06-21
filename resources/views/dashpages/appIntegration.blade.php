@extends('layouts.dashboard')

@section('title', $title)

@section('content')
    <div class="row">
        <div class="col-lg-4 d-flex flex-column">
            <div class="row flex-grow">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card card-rounded">
                        <div class="card-body">
                            <div class="d-sm-flex justify-content-between align-items-start">
                                <div>
                                    <h4 class="card-title card-title-dash">{{ _('Generar Token para Autorizacion') }}</h4>
                                    <p class="card-subtitle card-subtitle-dash">
                                        {{ _('Autorizacion de Aplicaciones Externas') }}</p>
                                </div>
                            </div>
                            <form class="form-floating" id="formCreatedToken">
                                <input type="text" class="form-control" id="application_name">
                                <label for="floatingInputValue">{{ _('Nombre de la Aplicacion') }}</label>
                                <button type="submit" class="btn btn-primary">{{ _('Generar API Token') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 d-flex flex-column">
            <div class="row flex-grow">
                <div class="col-md-6 col-lg-12 grid-margin stretch-card">
                    <div class="card card-rounded">
                        <div class="card-body pb-0">
                            <h4 class="card-title card-title-dash mb-4">{{ _('Aplicaciones autenticadas') }}</h4>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@vite(['resources/js/custom/appsaprove/app.js'])