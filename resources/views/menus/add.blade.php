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
            <div class="d-flex justify-content-between">
                <h4 class="card-title">{{ $title }}</h4>
                <div class="col-6">
                    {!! Form::select(
                        'template',
                        ['0' => 'Selecciona la Plantilla', 'Templates' => $templates],
                        [],
                        [
                            'class' => 'form-control',
                            'id' => 'templates',
                            'aria-label' => 'Floating label select',
                            'data-field' => 'Templates',
                        ],
                    ) !!}

                </div>
            </div>
            <div class="card-body" id="dataTemplates">

            </div>
        </div>
    </div>

@endsection
@vite(['resources/js/custom/pages/add.js'])
