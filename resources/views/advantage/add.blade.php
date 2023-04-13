@extends('layouts.dashboard')

@section('title', $title)

@section('content')
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            @if ($errors->any())
                <div class="alert alert-dark alert-dismissible fade show" role="alert">
                    <strong>¡Revise los campos!</strong>
                    @foreach ($errors->all() as $error)
                        <span class="badge badge-danger">{{ $error }}</span>
                    @endforeach
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="card-body">
                <h4 class="card-title">{{ $title }}</h4>
                {!! Form::open(['route' => 'ventajas.store', 'method' => 'POST', 'id' => 'formAdd']) !!}

                <div class="form-floating mb-3">
                    {!! Form::text('title', null, [
                        'class' => 'form-control',
                        'placeholder' => 'Titulo de la Entrada',
                        'id' => 'titleAdv',
                        'data-field' => 'Titulo de la Ventaja',
                    ]) !!}
                    <label for="titleBlog">{{ _('Titulo de la Ventaja') }}</label>
                </div>

                <div class="form-floating mb-3">
                    {!! Form::textarea('content', null, [
                        'class' => 'form-control',
                        'placeholder' => 'Contenido de la Entrada',
                        'id' => 'contentAdv',
                        'style' => 'height: 250px; line-height: normal;',
                        'data-field' => 'Contenido de la Ventaja',
                    ]) !!}
                    <label for="contentBlog">{{ _('Contenido') }}</label>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <button type="submit" class="btn btn-primary">{{ _('Crear Ventaja') }}</button>
                </div>

                {!! Form::close() !!}
            </div>

            <div class="loader">
                @include('includes.dashboard.loader')
            </div>
        </div>
    </div>
@endsection

@vite(['resources/js/custom/advantage/add.js'])
