@extends('layouts.dashboard')

@section('title', $title)

@if (count($blogs) === 0)
    @section('content')
        <div class="d-flex justify-content-between">
            <h2 class="card-title">{{ _($title) }}</h2>
            @can('crear-blog')
                <a href="{{ route('blogs.create') }}" class="btn btn-primary">{{ _('Nueva Entrada de Blog') }}</a>
            @endcan
        </div>
        <p>Sin contenido</p>
    @endsection
@endif

@section('content')
    {{-- Tabla de usuarios --}}
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h2 class="card-title">{{ _($title) }}</h2>
                    @can('crear-blog')
                        <a href="{{ route('blogs.create') }}" class="btn btn-primary">{{ _('Nueva Entrada de Blog') }}</a>
                    @endcan
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ _('Titulo') }}</th>
                                <th>{{ _('Autor') }}</th>
                                <th>{{ _('Categoria') }}</th>
                                <th>{{ _('Imagen') }}</th>
                                <th>{{ _('Fecha de Creación') }}</th>
                                <th>{{ _('Opciones') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($blogs as $blog)
                                <tr>
                                    <td class="text-capitalize"> {{ $blog->title }} </td>
                                    <td class="text-capitalize"> {{ $blog->user->name }} </td>
                                    <td class="text-capitalize"> {{ $blog->category->name }} </td>
                                    <td class="text-capitalize"> {{ _('Hacer Funcionalidad de Imagenes') }} </td>
                                    <td class="text-capitalize">
                                        {{ \Carbon\Carbon::parse($blog->created_at)->toDateString() }} </td>
                                    <td>
                                        @can('editar-blog')
                                            <a href="{{ route('blogs.edit', $blog->id) }}"
                                                class="btn btn-info">{{ _('Editar Entrada') }}</a>
                                        @endcan

                                        @can('borrar-blog')
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['blogs.destroy', $blog->id], 'style' => 'display: inline']) !!}
                                            {!! Form::submit('Borrar Entrada', ['class' => 'btn btn-danger']) !!}
                                            {!! Form::close() !!}
                                        @endcan

                                        <a href="{{ url('/blogs', $blog->id) }}" class="btn btn-primary"
                                            target="_blank">{{ _('Ver Entrada') }}</a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="pagination justify-content-end">
                    {!! $blogs->links() !!}
                </div>
            </div>
        </div>
    </div>

    {{-- Fin tabla --}}
@endsection
