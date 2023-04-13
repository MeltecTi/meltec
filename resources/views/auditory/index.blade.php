@extends('layouts.dashboard')
@section('title', $title)

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ $title }}</h4>
                <div class="table-responsive pt-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>
                                    {{ _('Id') }}
                                </th>
                                <th>
                                    {{ _('Evento o Cambio') }}
                                </th>
                                <th>
                                    {{ _('Usuario Responsable') }}
                                </th>
                                <th>
                                    {{ _('Modelo cambiado') }}
                                </th>
                                <th>
                                    {{ _('Fecha de Cambio') }}
                                </th>
                                <th>
                                    {{ _('Direccion IP') }}
                                </th>
                                <th>
                                    {{ _('') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($auditions as $audition)
                                <tr>
                                    <td>{{ $audition->id }}</td>
                                    <td>{{ $audition->event }}</td>
                                    <td>{{ $audition->user->name }}</td>
                                    <td>
                                        @switch ($audition->auditable_type)
                                            @case ('App\Models\User')
                                                Usuarios
                                            @break

                                            @case ('App\Models\Blog')
                                                Blogs
                                            @break

                                            @case ('App\Models\Category')
                                                Categorias
                                            @break
                                            @case ('App\Models\Gallery')
                                                Galeria
                                            @break
                                            @case ('App\Models\BaseWeb')
                                                Datos Basicos de la Web
                                            @break
                                            @case ('App\Models\Menu')
                                                Paginas
                                            @break
                                            @case ('App\Rols')
                                                Roles
                                            @break
                                        @endswitch
                                    </td>
                                    <td>{{ $audition->created_at }}</td>
                                    <td>{{ $audition->ip_address }}</td>
                                    <td>
                                        <button type="button" class="btn btn-info audition" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal"
                                            data-value="{{ $audition->id }}">{{ _('Ver mas Detalles') }}</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalBody">

            </div>
        </div>
    </div>
</div>

@vite(['resources/js/custom/auditory/app.js'])

{{--
    <ol class="list-group list-group-numbered">
  <li class="list-group-item d-flex justify-content-between align-items-start">
    <div class="ms-2 me-auto">
      <div class="fw-bold">Subheading</div>
      Cras justo odio
    </div>
    <span class="badge bg-primary rounded-pill">14</span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-start">
    <div class="ms-2 me-auto">
      <div class="fw-bold">Subheading</div>
      Cras justo odio
    </div>
    <span class="badge bg-primary rounded-pill">14</span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-start">
    <div class="ms-2 me-auto">
      <div class="fw-bold">Subheading</div>
      Cras justo odio
    </div>
    <span class="badge bg-primary rounded-pill">14</span>
  </li>
</ol>
--}}
