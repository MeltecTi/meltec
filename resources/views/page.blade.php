@extends('layouts.app')
@section('title', $page->name)

@section('content-header')
    @include('includes.content-header')
@endsection

@section('content')
    <div class="container">
        <div class="container py-5">
            <div class="row g-5 mb-5">
                <div class="col-lg-7">
                    <div class="section-title position-relative pb-3 mb-5">
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
                                src="https://fastly.picsum.photos/id/40/4106/2806.jpg?hmac=MY3ra98ut044LaWPEKwZowgydHZ_rZZUuOHrc3mL5mI"
                                style="object-fit: cover;">
                        @endif
                        @foreach ($dataExtra->galleries as $gallery)
                            <img class="position-absolute w-100 h-100 rounded wow zoomIn" data-wow-delay="0.9s"
                                src="https://fastly.picsum.photos/id/3/5000/3333.jpg?hmac=GDjZ2uNWE3V59PkdDaOzTOuV3tPWWxJSf4fNcxu4S2g"
                                style="object-fit: cover;">
                        @endforeach
                    </div>
                </div>
            </div>

            @if ($page->parent === 0)
                <div class="mt-5 section-title text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px; ">
                    <h2 class="mb-0">{{ _('Paginas Relacionadas a este sitio: ') }}</h2>
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
