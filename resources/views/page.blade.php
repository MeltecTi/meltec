@extends('layouts.app')
@section('logosheader')
    <a href="{{ url('/') }}" class="navbar-brand p-0">
        <img src="{{ asset('img/logos/Meltec.png') }}" alt="Logo Meltec" class="img-fluid w-50">
    </a>
@endsection
@section('title', $page->name)

@section('content-header')
    @include('includes.content-header')
@endsection

@section('content')
    <div class="container">
        <div class="container py-5">
            <div class="row g-5 mb-5">
                <div class="col-lg-7">
                    <div class=" position-relative pb-3 mb-5">
                        <h5 class="fw-bold text-primary text-uppercase">{{ $page->name }}</h5>
                        <h1 class="mb-0">{{ $page->subtitle }}</h1>
                    </div>

                    <div class="fs-6">
                        {!! $page->content !!}
                    </div>

                </div>
                <div class="col-lg-5" style="min-height: 500px;">
                    <div class="position-relative h-100">
                        @if (count($dataExtra->galleries) === 0)
                            <img class="position-absolute w-100 h-100 rounded wow zoomIn" data-wow-delay="0.9s"
                                src="https://assets.website-files.com/5e1652731cfa696ddc109232/5f6b6650cb21f3704224a05a_meltec_logo.png"
                                style="object-fit: cover;">
                        @endif
                        @foreach ($dataExtra->galleries as $gallery)
                            <img class="position-absolute w-100 h-100 rounded wow zoomIn" data-wow-delay="0.9s"
                                src="{{ asset('storage/gallery/' . $gallery->file) }}" style="object-fit: cover;">
                        @endforeach
                    </div>
                </div>
            </div>

            @if ($page->parent === 0)
                <div class="mt-5 text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px; ">
                    <h2 class="mb-0">{{ _('Explorar mas: ') }}</h2>
                </div>
                @if (count($parentPages) !== 0)
                    <div class="gallery-marks">
                        @foreach ($parentPages as $pages)
                            <div class="grid-container-gallery">
                                <a href="{{ url($pages->slug) }}" class="image-mark">
                                    <div class="galery-image"
                                        style="background: url('{{ asset('storage/pages/' . $pages->image) }}'); background-position: center center; background-repeat: no-repeat; background-size: cover;">
                                        <div class="absolute-bg"></div>
                                    </div>
                                    <div class="content-mark">
                                        <h5>{{ $pages->name }}</h5>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>No hay paginas relacionadas</p>
                @endif

            @endif
        </div>

    </div>


@endsection
