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
            {!! Form::open(['route' => ['menus.store'], 'method' => 'POST', 'files' => true]) !!}

            <div class="row g-2 mb-3">
                <div class="col-md">
                    <div class="form-floating mb-3">
                        {!! Form::text('name', null, [
                            'class' => 'form-control',
                            'placeholder' => 'Titulo de la Pagina',
                            'id' => 'namePage',
                        ]) !!}
                        <label for="namePage">{{ _('Titulo de la Pagina') }}</label>
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-floating mb-3">
                        {!! Form::text('slug', null, [
                            'class' => 'form-control',
                            'placeholder' => 'example',
                            'id' => 'slug',
                        ]) !!}
                        <label for="slug">{{ _('Slug') }}</label>
                    </div>
                </div>
            </div>

            <div class="form-floating mb-3">
                {!! Form::text('subtitle', null, [
                    'class' => 'form-control',
                    'placeholder' => 'Descripcion de la Pagina',
                    'id' => 'namePage',
                ]) !!}
                <label for="namePage">{{ _('Descripcion de la Pagina') }}</label>
            </div>

            <div class="form-floating mb-3">
                {!! Form::textarea('content', null, [
                    'class' => 'form-control',
                    'placeholder' => 'Contenido de la Entrada',
                    'id' => 'contentBlog',
                    'style' => 'height: 250px; line-height: normal;',
                ]) !!}
            </div>

            <div class="row g-2 mb-3">
                <div class="col-md">
                    <label for="formFile" class="form-label">{{ _('Imagen Principal') }}</label>
                    {!! Form::file('image', [
                        'class' => 'form-control form-control-lg',
                        'id' => 'formFile',
                        'accept' => 'image/png, image/jpeg, image/webp',
                    ]) !!}
                </div>
            </div>

            <div class="row g-2 mb-3">
                <div class="col-md">
                    <div class="form-floating col-sm-12">
                        {!! Form::select(
                            'parent',
                            ['0' => 'Sin relación', 'Paginas' => $opciones],
                            [],
                            ['class' => 'form-select', 'id' => 'authors', 'aria-label' => 'Floating label select'],
                        ) !!}
                        <label for="roles">{{ _('Pagina relacionada a:') }}</label>
                    </div>
                </div>
            </div>
            <div class="col-md btn-group">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#staticBackdrop">
                    {{ _('Agregar Imagenes') }}
                </button>
            </div>
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalAdvantage">
                {{ _('Seleccionar las ventajas empresariales para esta pagina') }}
            </button>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                <button type="submit" class="btn btn-primary">{{ _('Publicar Pagina') }}</button>
            </div>
        </div>
    </div>

    {{-- Modal para seleccionar las ventajas de la Pagina --}}

    <!-- Modal -->
    <div class="modal fade" id="modalAdvantage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="smodalAdvantageLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ _('Ventajas empresariales') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        @foreach ($advantage as $a)
                        <label for="">{{ Form::checkbox('advantages[]', $a->id, false, ['class' => 'name']) }} {{ $a->title }}</label>
                            <br/>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ _('Cerrar') }}</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal Seleccionar Imgenes para la galeria -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ _('Galeria de Imagenes') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @foreach ($galleries as $file)
                            <div class="col-md-3">
                                <div class="custom-control custom-checkbox image-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="galleries[]"
                                        value="{{ $file->id }}">
                                    <label class="custom-control-label" for="{{ $file->id }}">
                                        <img src="{{ asset('storage/gallery/' . $file->file) }}" alt="#"
                                            class="img-fluid">
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cerrar') }}</button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#staticBackdrop2">
                        {{ _('Agregar Imagenes') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}


    <!-- Modal  Cargar Imagenes-->
    <div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdrop2Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdrop2Label">{{ _('Añadir Imagenes') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! Form::open([
                        'route' => ['gallery.store'],
                        'method' => 'POST',
                        'files' => true,
                        'class' => 'dropzone',
                        'id' => 'my-great-dropzone',
                    ]) !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('Cerrar') }}</button>
                </div>
                {!! Form::close() !!}
                <script>
                    Dropzone.options.myGreatDropzone = {
                        paramName: "file",
                        maxFilesize: 12,
                        acceptedFiles: '.jpeg, .jpg, .png, .webp',
                        addRemoveLinks: true,
                        timeout: 5000,
                        success: function(file, response) {
                            console.log(response);
                        },
                        error: function(file, response) {
                            return false;
                        }
                    };
                </script>
            </div>
        </div>
    </div>
@endsection
@vite(['resources/js/custom/pages/add.js'])