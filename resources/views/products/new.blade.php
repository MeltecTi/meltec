@extends('layouts.dashboard')
@section('title', $title)

@section('content')
    <div class="card">
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="card-body">
            <h4 class="card-title">{{ $title }}</h4>
            {!! Form::open(['route' => ['products.store'], 'method' => 'POST', 'files' => true]) !!}

            <div class="row g-2 mb-3">
                <div class="col-md">
                    <div class="form-floating mb-3">
                        {!! Form::text('name', null, [
                            'class' => 'form-control',
                            'id' => 'namePage',
                        ]) !!}
                        <label for="namePage">{{ _('Nombre del Producto') }}</label>
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-floating mb-3">
                        {!! Form::text('resume', null, [
                            'class' => 'form-control',
                            'id' => 'resume',
                        ]) !!}
                        <label for="resume">{{ _('Resumen del Producto') }}</label>
                    </div>
                </div>
            </div>

            <div class="form-floating mb-3">
                {!! Form::textarea('description', null, [
                    'class' => 'form-control',
                    'id' => 'description',
                    'style' => 'height: 250px; line-height: normal;',
                ]) !!}
                <label for="description">{{ _('Descripcion del Producto') }}</label>
            </div>

            <div class="row g-2 mb-3">
                <div class="col-md">
                    <label for="resume">{{ _('Imagen del Producto') }}</label>
                    {!! Form::file('image', [
                        'class' => 'form-control form-control-lg',
                        'id' => 'formFile',
                        'accept' => 'image/png, image/jpeg, image/webp',
                    ]) !!}
                </div>
            </div>

            <div class="row g-2 mb-3">
                <div class="col-md">
                    <div class="form-floating mb-3">
                        {!! Form::text('urlTechnical', null, [
                            'class' => 'form-control',
                            'id' => 'urlTechnical',
                        ]) !!}
                        <label for="urlTechnical">{{ _('Ficha Tecnica (url)') }}</label>
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-floating mb-3 col-sm-12">
                        {!! Form::select(
                            'mark_id',
                            ['0' => 'Seleccione una Opcion', 'Categorias' => $marks->pluck('name', 'id')],
                            [],
                            ['class' => 'form-select', 'id' => 'marks', 'aria-label' => 'Floating label select'],
                        ) !!}
                        <label for="marks">{{ _('Categorias') }}</label>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                <button type="submit" class="btn btn-primary">{{ _('Crear Producto') }}</button>
            </div>
        </div>
    </div>

    {!! Form::close() !!}
@endsection
{{-- @vite(['resources/js/custom/products/add']) --}}
