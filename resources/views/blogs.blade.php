@extends('layouts.app')
@section('title', $title)

@section('content-header')
    <div class="container-fluid bg-primary py-5 bg-header" style="margin-bottom: 90px; background: linear-gradient(rgba(9, 30, 62, .7), rgba(9, 30, 62, .7)), url( {{ asset('img/carousel-1.jpg') }}), center center no-repeat ">
        <div class="row py-5">
            <div class="col-12 pt-lg-5 mt-lg-5 text-center">
                <h1 class="display-4 text-white animated zoomIn"> {{ $title }} </h1>
                <p class="lead text-light">
                    {{ _('Nos encanta conocer y hacer parte de los retos tecnológicos en comunicación que necesita tu empresa.') }}
                </p>
            </div>
        </div>
    </div>
@endsection

{{-- @if( isset($blogsAll))
    @section('content')
        <div class="container py-5">
            <h1 class="text-center">{{ _('No hay contenido de Blogs en este momento') }}</h1>
        </div>
    @endsection
@endif --}}

@section('content')
    <div class="container py-5">
        <div class="row g-">
            <!-- Blog list Start -->
            <div class="col-lg-12">
                <div class="row g-5">

                    @foreach ($blogsAll as $blog)
                        <div class="col-md-6 wow slideInUp" data-wow-delay="0.1s">
                            <div class="blog-item bg-light rounded overflow-hidden">
                                <div class="blog-img position-relative overflow-hidden">
                                    <img class="img-fluid" src="{{ asset('img/blogsImg/'.$blog->image) }}" alt="">
                                    <a class="position-absolute top-0 start-0 bg-primary text-white rounded-end mt-5 py-2 px-4"
                                        href="">{{ $blog->category->name }}</a>
                                </div>
                                <div class="p-4">
                                    <div class="d-flex mb-3">
                                        <small class="me-3"><i class="far fa-user text-primary me-2"></i>{{ $blog->user->name }}</small>
                                        <small><i class="far fa-calendar-alt text-primary me-2"></i>{{ \Carbon\Carbon::parse($blog->created_at)->toFormattedDateString() }}</small>
                                    </div>
                                    <h4 class="mb-3">{{ $blog->title }}</h4>
                                    <p>{!! Str::limit($blog->content, 20) !!}</p>
                                    <a class="text-uppercase" href=" {{ url('blogs', $blog->id) }} ">{{  _('Ver Entrada ') }}<i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- Blog list End -->
        </div>
    </div>
@endsection
