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
                {!! Form::open(['route' => 'blogs.store', 'method' => 'POST', 'files' => true]) !!}

                <div class="form-floating mb-3 col-sm-3 col-md-6">
                    {!! Form::text('title', null, [
                        'class' => 'form-control',
                        'placeholder' => 'Titulo de la Entrada',
                        'id' => 'titleBlog',
                    ]) !!}
                    <label for="titleBlog">{{ _('Titulo de la Entrada') }}</label>
                </div>

                <div class="form-floating mb-3">
                    {!! Form::textarea('content', null, [
                        'class' => 'form-control',
                        'placeholder' => 'Contenido de la Entrada',
                        'id' => 'contentBlog',
                        'style' => 'height: 250px; line-height: normal;',
                    ]) !!}
                </div>

                <div class="mb-3">
                    <label for="formFile" class="form-label">{{ _('Imagen') }}</label>
                    {!! Form::file('image', [
                        'class' => 'form-control form-control-lg',
                        'id' => 'formFile',
                        'accept' => 'image/png, image/jpeg, image/webp',
                    ]) !!}
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-md">
                        <div class="form-floating col-sm-12">
                            @if (auth()->user()->isAdmin())
                                {!! Form::select(
                                    'user_id',
                                    ['0' => 'Selecciona un Autor', 'Autores' => $authors->pluck('name', 'id')],
                                    [],
                                    ['class' => 'form-select', 'id' => 'authors', 'aria-label' => 'Floating label select'],
                                ) !!}
                            @else
                                {!! Form::select(
                                    'user_id',
                                    ['0' => 'Selecciona un Autor', 'Autores' => $authors->pluck('name', 'id')],
                                    auth()->id(),
                                    ['class' => 'form-select', 'id' => 'authors', 'aria-label' => 'Floating label select', 'disabled' => 'disabled'],
                                ) !!}
                            @endif
                            <label for="roles">{{ _('Autor') }}</label>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-floating mb-3 col-sm-12">
                            {!! Form::select(
                                'category_id',
                                ['0' => 'Seleccione una Opcion', 'Categorias' => $categories->pluck('name', 'id')],
                                [],
                                ['class' => 'form-select', 'id' => 'roles', 'aria-label' => 'Floating label select'],
                            ) !!}
                            <label for="roles">{{ _('Categorias') }}</label>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <button type="submit" class="btn btn-primary">{{ _('Crear Entrada de Blog') }}</button>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@vite(['resources/js/custom/blogs/create.js'])