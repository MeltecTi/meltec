@extends('layouts.dashboard')

@section('title', $title)

@section('content')

    {{-- Tabla de usuarios --}}
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h2 class="card-title">{{ _($title) }}</h2>
                    @can('crear-usuarios')
                        <a href="{{ route('usuarios.create') }}" class="btn btn-primary">{{ _('Nuevo Usuario') }}</a>
                    @endcan
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ _('Nombre') }}</th>
                                <th>{{ _('Correo Electronico') }}</th>
                                <th>{{ _('Rol') }}</th>
                                <th>{{ _('Opciones') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuarios as $usuario)
                                <tr>
                                    <td> {{ $usuario->name }} </td>
                                    <td> {{ $usuario->email }} </td>
                                    <td>
                                        @if (!empty($usuario->getRoleNames()))
                                            @foreach ($usuario->getRoleNames() as $rolName)
                                                <h5><span>{{ $rolName }}</span></h5>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        @can('editar-usuarios')
                                            <a href="{{ route('usuarios.edit', $usuario->id) }}"
                                                class="btn btn-info">{{ _('Editar Usuario') }}</a>
                                        @endcan

                                        @can('borrar-usuarios')
                                            {!! Form::open([
                                                'method' => 'DELETE',
                                                'route' => ['usuarios.destroy', $usuario->id],
                                                'style' => 'display: inline',
                                                'class' => 'formdelete',
                                                'data-value' => $usuario->id,
                                            ]) !!}

                                            {!! Form::submit('Borrar Usuario', ['class' => 'btn btn-danger']) !!}
                                            {!! Form::close() !!}
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="pagination justify-content-end">
                    {!! $usuarios->links() !!}
                </div>
            </div>
        </div>
    </div>
    @vite(['resources/js/custom/deleteuser.js'])

    {{-- Fin tabla --}}
@endsection
