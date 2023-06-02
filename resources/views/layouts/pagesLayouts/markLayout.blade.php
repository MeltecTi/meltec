@extends('layouts.app')

@section('title', $page->name)

@section('content-header')
    @include('layouts.pagesLayouts.headers.headerMarks')
@endsection

@section('content')
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5">
                <div class="row g-0 mb-3">
                    {!! _($page->content) !!}
                </div>

                <a href="{{ url('contactanos') }}" class="btn btn-primary py-3 px-5 mt-3 wow zoomIn"
                    data-wow-delay="0.9s">{{ _('Contactanos para mas Información') }}</a>
            </div>
            <div class="col-lg-7" style="min-height: 500px;">
                <div class="position-relative h-100">
                    <iframe width="100%" height="100%" src="{{ $page->videourl.'?autoplay=1&loop=1&controls=0&mute=1' }}"
                        title="Safety Reimagined" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>

    {{-- Soluciones  --}}
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px;">
                <h1 class="mb-0">{{ _('Nuestras Soluciones') }}</h1>
            </div>
            <div class="row g-5">
                {{-- Foreach de los productos relacionados con la marca --}}
                @foreach ($products as $product)
                    <div class="col-lg-4 wow slideInUp" data-wow-delay="0.3s">
                        <div class="team-item bg-light rounded overflow-hidden">
                            <div class="team-img position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="{{ asset('storage/gallery/'.$product->routeImage) }}" alt="">
                                <div class="team-social">
                                    <a class="btn btn-lg btn-primary btn-lg-square rounded"
                                        href="{{ $product->urlTechnical }}" target="_blank"><i
                                            class="fab fa-google-drive"></i></a>
                                </div>
                            </div>
                            <div class="text-center py-4">
                                <h4 class="text-primary">{{ _($product->name) }}</h4>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{-- Fin del Foreach --}}
            </div>
        </div>
    </div>
    {{-- Soluciones  --}}

    <!-- Features Start -->
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px;">
                <h1 class="mb-0">{{ _('Casos de Exito') }}</h1>
            </div>
            {{-- Si se puede agregar Slider Mejor. Añadir datos de una base de Datos --}}
            <div class="row g-5">
                <div class="col-lg-4">
                    <div class="row g-5">
                        <div class="col-12 wow zoomIn" data-wow-delay="0.2s">
                            <div class="bg-primary rounded d-flex align-items-center justify-content-center mb-3"
                                style="width: 60px; height: 60px;">
                                <i class="fa fa-cubes text-white"></i>
                            </div>
                            <h4>Best In Industry</h4>
                            <p class="mb-0">Magna sea eos sit dolor, ipsum amet lorem diam dolor eos et diam dolor</p>
                        </div>
                        <div class="col-12 wow zoomIn" data-wow-delay="0.6s">
                            <div class="bg-primary rounded d-flex align-items-center justify-content-center mb-3"
                                style="width: 60px; height: 60px;">
                                <i class="fa fa-award text-white"></i>
                            </div>
                            <h4>Award Winning</h4>
                            <p class="mb-0">Magna sea eos sit dolor, ipsum amet lorem diam dolor eos et diam dolor</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4  wow zoomIn" data-wow-delay="0.9s" style="min-height: 350px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute w-100 h-100 rounded wow zoomIn" data-wow-delay="0.1s"
                            src="img/feature.jpg" style="object-fit: cover;">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row g-5">
                        <div class="col-12 wow zoomIn" data-wow-delay="0.4s">
                            <div class="bg-primary rounded d-flex align-items-center justify-content-center mb-3"
                                style="width: 60px; height: 60px;">
                                <i class="fa fa-users-cog text-white"></i>
                            </div>
                            <h4>Professional Staff</h4>
                            <p class="mb-0">Magna sea eos sit dolor, ipsum amet lorem diam dolor eos et diam dolor</p>
                        </div>
                        <div class="col-12 wow zoomIn" data-wow-delay="0.8s">
                            <div class="bg-primary rounded d-flex align-items-center justify-content-center mb-3"
                                style="width: 60px; height: 60px;">
                                <i class="fa fa-phone-alt text-white"></i>
                            </div>
                            <h4>24/7 Support</h4>
                            <p class="mb-0">Magna sea eos sit dolor, ipsum amet lorem diam dolor eos et diam dolor</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Features Start -->
@endsection
