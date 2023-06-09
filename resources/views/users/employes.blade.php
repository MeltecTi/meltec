@extends('layouts.dashboard')

@section('title', $title)

@section('content')
    <div class="row flex-grow">
        <div class="col-12 grid-margin stretch-card">
            <div class="card card-rounded">
                <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-start">
                        <div>
                            <h4 class="card-title card-title-dash">{{ _('Empleados Meltec Comunicaciones S.A') }}</h4>
                            <p class="card-subtitle card-subtitle-dash" id="quantityEmployes">You have 50+ new requests</p>
                        </div>
                    </div>
                    <div class="table-responsive mt-1" id="table">
                        <table class="table select-table table-striped table-hover" id="tableConstruct">
                            <thead>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Nombre Completo</th>
                                    <th>Identificacion</th>
                                    <th>Region</th>
                                    <th>Email</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@vite(['resources/js/sapApi/employes/list.js'])


{{-- Modal para editar y/o ver los datos --}}
<div class="modal fade" id="vieworeditData" tabindex="-1" aria-labelledby="vieworeditDataLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="vieworeditDataLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label for="inputEmail4" class="form-label">{{ _('Nombre del Empleado') }}</label>
                        <input type="text" class="form-control" id="SAPname" disabled>
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">{{ _('Correo Electronico') }}</label>
                        <input type="text" class="form-control" id="SAPemail">
                    </div>
                    <div class="col-12">
                        <label for="inputAddress" class="form-label">Address</label>
                        <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
                    </div>
                    <div class="col-12">
                        <label for="inputAddress2" class="form-label">Address 2</label>
                        <input type="text" class="form-control" id="inputAddress2"
                            placeholder="Apartment, studio, or floor">
                    </div>
                    <div class="col-md-6">
                        <label for="inputCity" class="form-label">City</label>
                        <input type="text" class="form-control" id="inputCity">
                    </div>
                    <div class="col-md-4">
                        <label for="inputState" class="form-label">State</label>
                        <select id="inputState" class="form-select">
                            <option selected>Choose...</option>
                            <option>...</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="inputZip" class="form-label">Zip</label>
                        <input type="text" class="form-control" id="inputZip">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
