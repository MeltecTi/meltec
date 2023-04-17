@extends('layouts.dashboard')
@section('title', $title)

@section('content')
    {{-- Tabla  --}}
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h2 class="card-title">{{ _($title) }}</h2>
                    <div class="d-grid gap-2 d-md-block">
                        <a href="{{ route('menus.create') }}" class="btn btn-primary">{{ _('Nueva Pagina') }}</a>
                        <a href="{{ route('ciudades.index') }}" class="btn btn-info">{{ _('Ciudades') }}</a>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" id="resourcesWeb">
                            {{ _('Recursos del Sitio') }}
                        </button>
                    </div>
                </div>
                <div class="table-responsive" id="dataApi">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ _('Titulo de la Pagina') }}</th>
                                <th>{{ _('Slug') }}</th>
                                <th>{{ _('Relacionado A') }}</th>
                                <th>{{ _('Estado') }}</th>
                                <th>{{ _('Fecha de publicación') }}</th>
                                <th>{{ _('Fecha de ultima edición') }}</th>
                                <th>{{ _('Opciones') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($menus as $menu)
                                <tr>
                                    <td class="text-capitalize">{{ _($menu->name) }}</td>
                                    <td class="text-lowercase">
                                        <a href="{{ url($menu->slug) }}" target="_blank">{{ $menu->slug }}</a>
                                    </td>
                                    <td class="text-capitalize">
                                        {{ $menu->parentMenu != '' ? $menu->parentMenu->name : _('/') }}
                                    </td>
                                    <td class="text-capitalize">
                                        {{ $menu->enabled == '1' ? _('Publicada') : _('En Borrador') }}</td>
                                    <td class="text-capitalize">
                                        {{ $menu->enabled == '1'? \Carbon\Carbon::parse($menu->created_at)->subHours(5)->toDateString(): _('No publicada') }}
                                    </td>
                                    <td class="text-capitalize">
                                        {{ \Carbon\Carbon::parse($menu->updated_at)->subHours(5)->toDayDateTimeString() }}
                                    </td>
                                    <td>
                                        @can('editar-blog')
                                            <a href="{{ route('menus.edit', $menu->id) }}"
                                                class="btn btn-info">{{ _('Editar Pagina') }}</a>
                                        @endcan

                                        @if ($menu->parent != 0)
                                            @can('borrar-blog')
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['menus.destroy', $menu->id], 'style' => 'display: inline']) !!}
                                                {!! Form::submit('Borrar Entrada', ['class' => 'btn btn-danger']) !!}
                                                {!! Form::close() !!}
                                            @endcan
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="pagination justify-content-end">
                    {!! $menus->links() !!}
                </div>
            </div>
        </div>
    </div>

    {{-- Fin tabla --}}
@endsection


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" id="myModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">{{ _('Recursos del Sitema') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalBody">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ _('Cerrar') }}</button>
            </div>
        </div>
    </div>
</div>

@vite(['resources/js/custom/web/app.js'])