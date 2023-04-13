@extends('layouts.app')

@section('title', $page->name)

@section('content-header')
    @include('includes.content-header')
@endsection

@section('content')
    <!-- Service Start -->
    <div class="container-fluid wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="container py-5">
                <div class="section-title text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px;">
                    <h5 class="fw-bold text-primary text-uppercase">{{ $page->content }}</h5>
                    <h1 class="mb-0">{{ $page->subtitle }}</h1>
                </div>

                {{-- Carta de las marcas --}}
                <div class="gallery-marks">
                    @foreach ($industriesItems as $industry)
                        <div class="grid-container-gallery">
                            <a href="{{ url($page->slug . '/' . $industry->id) }}" class="image-mark">
                                <div class="galery-image"
                                    style="background: url('{{ asset('storage/pages/' . $industry->image) }}'); background-position: center center; background-repeat: no-repeat; background-size: cover;">
                                    <div class="absolute-bg"></div>
                                </div>
                                <div class="content-mark">
                                    <h5>{{ $industry->name }}</h5>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                {{-- Fin carta de las marcas --}}
            </div>
        </div>
        <!-- Service End -->
    @endsection
