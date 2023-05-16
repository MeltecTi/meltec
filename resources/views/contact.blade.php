@extends('layouts.app')
@vite(['resources/css/loader.css'])

@section('title', $page->name)


@section('content-header')
    @include('includes.content-header')
@endsection


@section('content')
    <div class="container">
        <div class="section-title text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px;">
            <h5 class="fw-bold text-primary text-uppercase">{{ $page->name }}</h5>
            <h1 class="mb-0">
                {{ _('Nos encanta conocer y hacer parte de los retos tecnológicos en comunicación que necesita tu empresa.') }}
            </h1>
        </div>
        <div class="row g-5 mt-5">
            <div class="col-lg-6 wow slideInUp" data-wow-delay="0.3s">

                <iframe width="100%" height="450" src="https://app.flokzu.com/public/039e4LGESR?embedded=true"
                    frameborder="0"></iframe>
            </div>
            <div class="col-lg-6 wow slideInUp" data-wow-delay="0.6s">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3976.2845683867495!2d-74.0687423!3d4.7205544999999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3f852459bad601%3A0x799ac647e2c83082!2sMeltec%20Comunicaciones%20S.A.!5e0!3m2!1ses!2sco!4v1681247823174!5m2!1ses!2sco"
                    width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade" style=""></iframe>
            </div>
        </div>

        <div class="section-title text-center position-relative pb-3 mb-5 mx-auto mt-5">
            <h2 class="fw-bold text-primary text-uppercase">{{ _('Nuestas Sedes') }}</h2>

        </div>
        <div class="row g-5 mb-5 p-5">

            @foreach ($cities as $city)
                <div class="col-lg-3 p-3">
                    <div class="d-flex align-items-center wow fadeIn" data-wow-delay="0.1s">
                        <div class="ps-4">
                            <h5 class="mb-2">{{ $city->name }}</h5>
                            <div>
                                {!! $city->dataCity !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>



    {{-- @vite(['resources/js/custom/contact/form.js']) --}}
@endsection
