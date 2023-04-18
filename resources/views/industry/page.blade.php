@extends('layouts.app')

@section('title', $title)

@section('content-header')
    @include('includes.content-header')
@endsection

@section('content')
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-7">
                    <div class="section-title position-relative pb-3 mb-5">
                        <h5 class="fw-bold text-primary text-uppercase">{{ $page->name }}</h5>
                        <h1 class="mb-0">{{ $page->subtitle }}</h1>
                    </div>
                    <p class="mb-4">{!! $page->content !!}</p>
                </div>
                <div class="col-lg-5" style="min-height: 500px;">
                    <div class="position-relative h-100">
                        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-title text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px;">
                <h5 class="fw-bold text-primary text-uppercase">
                    {{ _('Descubre las razones por las que debes elegir Meltec') }}</h5>
                <h1 class="mb-0">{{ _('¿Cómo agregamos valor a la industria?') }}</h1>
            </div>
            <div class="row">
                @foreach ($page->advantages as $advantage)
                    <div class="col-lg-6 col-md-6 mb-3 wow zoomIn" data-wow-delay="0.3s">
                        <div class="service-item  rounded d-flex flex-column justify-content-around pt-3" style="--bs-bg-opacity: .25; background-color: #EEF9FF ;">
                            <h4 class="text-center m-0">{{ $advantage->title }}</h4>
                            <p class="m-0"> {{ $advantage->content }} </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


@endsection
