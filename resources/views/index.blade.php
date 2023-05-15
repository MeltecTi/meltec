@extends ('layouts.app')

{{-- Seccion del header antes del contenido principal --}}

@section('content-header')
    <div id="header-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="w-100" src="{{ asset('img/carousel-1.jpg') }}" alt="Image">
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3" style="max-width: 900px;">
                        <h5 class="text-white text-uppercase mb-3 animated slideInDown">{{ _('Innovacion y Tecnologia') }}</h5>
                        <h1 class="display-1 text-white mb-md-4 animated zoomIn">{{ config('app.name') }}</h1>
                        <a href="{{ url('nosotros') }}" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">{{ _('Conocenos') }}</a>
                        <a href="{{ url('contacto') }}" class="btn btn-outline-light py-md-3 px-md-5 animated slideInRight">{{ _('Contactanos') }}</a>
                    </div>
                </div>
            </div>
        </div>

{{-- 
        <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button> --}}
    </div>
@endsection

{{-- Seccion de contenido de la pagina --}}

@section('content')
    <div class="container">
        
    </div>
@endsection
