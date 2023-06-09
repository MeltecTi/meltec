@extends('layouts.dashboard')

@section('title', $title)

@section('content')
    <div class="row flex-grow">
        <div class="col-12 grid-margin stretch-card">
            <div class="card card-rounded">
                <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-start">
                        <div>
                            <h4 class="card-title card-title-dash">{{ _('Enviame.io Meltec') }}</h4>
                        </div>
                    </div>       
            </div>
        </div>
    </div>
@endsection
