@extends('layouts.dashboard')

@section('title', $title)

@section('content')
    <div class="col-lg-4 grid-margin stretch-card">
        <div class="card">
            @can('crear-categoria')
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h2 class="card-title">{{ _($titleNew) }}</h2>
                    </div>
                    {!! Form::open(['route' => 'categorias.store', 'method' => 'POST']) !!}

                    <div class="form-group">
                        <label for="nameCategory">{{ _('Nombre de la categoria') }}</label>
                        {!! Form::text('name', null, [
                            'class' => 'form-control',
                            'placeholder' => 'Nombre de la categoria',
                            'id' => 'nameCategory',
                        ]) !!}
                    </div>

                    <div class="form-group">
                        <label for="slugCategory">{{ _('Slug') }}</label>
                        {!! Form::text('slug', null, [
                            'class' => 'form-control',
                            'placeholder' => 'slug-categoria',
                            'id' => 'slugCategory',
                        ]) !!}
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <button type="submit" class="btn btn-primary">{{ _('Crear Categoria') }}</button>
                    </div>

                    {!! Form::close() !!}

                </div>
            @endcan
        </div>
    </div>

    <div class="col-lg-7 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ $title }}</h4>
                <div class="table-responsive">
                    <table class="table table-hover text-center">
                        <thead>
                            <tr>
                                <th>{{ _('Nombre') }}</th>
                                <th>{{ _('Slug') }}</th>
                                <th>{{ _('Fecha de Creación') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->slug }}</td>
                                    <td>{{ \Carbon\Carbon::parse($category->created_at)->toDateString() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
