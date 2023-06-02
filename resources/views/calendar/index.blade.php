@extends('layouts.dashboard')

@section('title', $title)

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title text-center">{{ _($title) }}</h2>
                <div class="calendar" id="calendar"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{ _('Reservar Sala') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! Form::open() !!}
                    <div class="form-floating mb-3">
                        {!! Form::text('titleEvent', null, [
                            'class' => 'form-control',
                            'id' => 'titleEvent',
                        ]) !!}
                        <label for="titleEvent">{{ _('Titulo del Evento') }}</label>
                    </div>

                    <div class="form-check mb-3">
                        {!! Form::checkbox('isAllDay', '', false, [
                            'class' => 'form-check-input',
                            'id' => 'isAllDay',
                        ]) !!}
                        <label class="form-check-label" for="isAllDay">{{ _('Reservar para todo el dia') }}</label>
                    </div>

                    <div class="row mb-3">
                        <div class="form-floating mb-3 col-6">
                            {!! Form::date('eventStart', null, [
                                'class' => 'form-control',
                                'id' => 'eventStart',
                            ]) !!}
                            <label for="eventStart">{{ _('Fecha de Inicio del Evento') }}</label>
                        </div>

                        <div class="form-floating mb-3 col-6">
                            {!! Form::date('eventEnd', null, [
                                'class' => 'form-control',
                                'id' => 'eventEnd',
                            ]) !!}
                            <label for="eventEnd">{{ _('Fecha de Fin del Evento') }}</label>
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        {!! Form::textarea('eventDescription', null, [
                            'class' => 'form-control',
                            'id' => 'eventDescription',
                            'style' => 'height: 250px; line-height: normal;',
                        ]) !!}
                        <label for="eventDescription">{{ _('Descripcion del Evento') }}</label>
                    </div>

                    <div class="row mb-3">
                        <div class="form-floating mb-3 col-6">
                            {!! Form::select(
                                'rooms[]',
                                ['0' => '-- Seleccione la sala --', 'Salas Disponibles' => $rooms],
                                [],
                                [
                                    'class' => 'form-control',
                                    'id' => 'rooms',
                                    'aria-label' => 'Floating label select',
                                    'data-field' => 'Sala de Reuniones',
                                ],
                            ) !!}
                            <label for="rooms">{{ _('Roles y permisos del Usuario') }}</label>
                        </div>
                        <div class="form-floating mb-3 col-6">
                            {!! Form::number('personal_quantity', null, [
                                'class' => 'form-control',
                                'id' => 'personal_quantity',
                            ]) !!}
                            <label for="personal_quantity">{{ _('Cantidad de Asistentes') }}</label>
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ _('Cerrar') }}</button>
                    <button type="button" class="btn btn-primary">{{ _('Crear Evento') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@vite(['resources/js/custom/calendar/app.js'])
