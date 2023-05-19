@extends('layouts.dashboard')

@section('title', $title)

@section('content')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h2 class="card-title">{{ _($title) }}</h2>
                    <input type="hidden" id="id" value="{{ $data->id }}">
                </div>
                {!! Form::open(['route' => ['budgets.update', $data->id], 'method' => 'PUT', 'id' => 'formData']) !!}
                <div class="row g-2 mb-3">
                    <div class="card-title">{{ _('Datos de la Unidad de Negocio') }}</div>
                    <div class="col-md">
                        <div class="form-floating mb-3">
                            {!! Form::text('businessUnit', $data->businessUnit, [
                                'class' => 'form-control',
                                'id' => 'businessUnit',
                            ]) !!}
                            <label for="businessUnit">{{ _('Unidad de Negocio') }}</label>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-floating mb-3">
                            {!! Form::number('goal', $data->goal, [
                                'class' => 'form-control',
                                'id' => 'goal',
                            ]) !!}
                            <label for="goal">{{ _('Meta ') }}</label>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-floating mb-3">
                            {!! Form::number('goalPercent', $data->goalPercent, [
                                'class' => 'form-control',
                                'id' => 'goalPercent',
                            ]) !!}
                            <label for="goalPercent">{{ _('Porcentaje de la Meta (%)') }}</label>
                        </div>
                    </div>
                </div>

                <div class="row g-2 mb-3">
                    <div class="card-title">{{ _('Información del Director y Comerciales') }}</div>
                    <div class="col-md">
                        <div class="form-floating mb-3">
                            {!! Form::number('goalDirector', $data->goalDirector, [
                                'class' => 'form-control',
                                'id' => 'goalDirector',
                            ]) !!}
                            <label for="goalDirector">{{ _('Meta del Director') }}</label>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-floating mb-3">
                            {!! Form::number('goalDirectorPercent', $data->goalDirectorPercent, [
                                'class' => 'form-control',
                                'id' => 'goalDirectorPercent',
                            ]) !!}
                            <label for="goalDirectorPercent">{{ _('Porcentaje de la meta (%) ') }}</label>
                        </div>
                    </div>
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-md">
                        <div class="form-floating mb-3">
                            {!! Form::number('goalCommercial', $data->goalCommercial, [
                                'class' => 'form-control',
                                'id' => 'goalCommercial',
                            ]) !!}
                            <label for="goalCommercial">{{ _('Meta de los comerciales') }}</label>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-floating mb-3">
                            {!! Form::number('commercialPercent', $data->commercialPercent, [
                                'class' => 'form-control',
                                'id' => 'commercialPercent',
                            ]) !!}
                            <label for="commercialPercent">{{ _('Porcentaje de la meta (%) ') }}</label>
                        </div>
                    </div>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-md">
                        <div class="row g-2 mb-3">
                            <div class="card-title">{{ _('Q1') }}</div>
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    {!! Form::number('q1Percent', $data->q1Percent, [
                                        'class' => 'form-control',
                                        'id' => 'q1Percent',
                                    ]) !!}
                                    <label for="q1Percent">{{ _('Porcentaje Q1 (%)') }}</label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    {!! Form::number('q1', $data->q1, [
                                        'class' => 'form-control',
                                        'id' => 'q1',
                                    ]) !!}
                                    <label for="q1">{{ _('Meta Q1') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="row g-2 mb-3">
                            <div class="card-title">{{ _('Q2') }}</div>
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    {!! Form::number('q2Percent', $data->q2Percent, [
                                        'class' => 'form-control',
                                        'id' => 'q2Percent',
                                    ]) !!}
                                    <label for="q2Percent">{{ _('Porcentaje Q2 (%)') }}</label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    {!! Form::number('q2', $data->q2, [
                                        'class' => 'form-control',
                                        'id' => 'q2',
                                    ]) !!}
                                    <label for="q2">{{ _('Meta Q2') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="row g-2 mb-3">
                            <div class="card-title">{{ _('Q3') }}</div>
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    {!! Form::number('q3Percent', $data->q3Percent, [
                                        'class' => 'form-control',
                                        'id' => 'q3Percent',
                                    ]) !!}
                                    <label for="q3Percent">{{ _('Porcentaje Q3 (%)') }}</label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    {!! Form::number('q3', $data->q3, [
                                        'class' => 'form-control',
                                        'id' => 'q3',
                                    ]) !!}
                                    <label for="q3">{{ _('Meta Q3') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="row g-2 mb-3">
                            <div class="card-title">{{ _('Q4') }}</div>
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    {!! Form::number('q4Percent', $data->q4Percent, [
                                        'class' => 'form-control',
                                        'id' => 'q4Percent',
                                    ]) !!}
                                    <label for="q2Percent">{{ _('Porcentaje Q4 (%)') }}</label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    {!! Form::number('q4', $data->q4, [
                                        'class' => 'form-control',
                                        'id' => 'q4',
                                    ]) !!}
                                    <label for="q4">{{ _('Meta Q4') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <button type="submit" class="btn btn-primary">{{ _('Editar Datos') }}</button>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@vite(['resources/js/custom/budget/edit.js'])