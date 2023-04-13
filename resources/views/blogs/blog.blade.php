@extends('layouts.app')

@section('title', $title)

@section('content-header')
    <div class="container-fluid bg-primary py-5 bg-header"
        style="margin-bottom: 90px; background: linear-gradient(rgba(9, 30, 62, .7), rgba(9, 30, 62, .7)), url( {{ asset('img/carousel-1.jpg') }}), center center no-repeat ">
        <div class="row py-5">
            <div class="col-12 pt-lg-5 mt-lg-5 text-center">
                <h1 class="display-4 text-white animated zoomIn"> {{ $title }} </h1>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <!-- Blog Start -->
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-12">
                    <a class="text-uppercase" href=" {{ url('blogs') }} "><i class="fas fa-arrow-left">{{  _(' Volver a las Entradas') }}</i></a>
                    <!-- Blog Detail Start -->
                    <div class="mb-5 mt-3">
                        <figure>
                            <blockquote class="blockquote">
                                <h1 class="mb-4">{{ $title }}</h1>
                            </blockquote>
                            <figcaption class="blockquote-footer">
                                {{ _('Creado por: ') }} <cite title="Source Title">{{ $blog->user->name }}</cite>
                            </figcaption>
                            <figcaption class="blockquote-footer">
                                {{ \Carbon\Carbon::parse($blog->created_at)->toFormattedDateString() }}
                            </figcaption>
                        </figure>
                        {{-- 
                        > --}}
                        {!! $blog->content  !!}
                    </div>
                    <!-- Blog Detail End -->
                </div>
            </div>
        </div>
    <!-- Blog End -->
@endsection
