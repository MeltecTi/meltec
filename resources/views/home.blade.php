@extends('layouts.dashboard')

@section('title', $title)

@section('content')
    <div class="home-tab">
        <div class="tab-content tab-content-basic">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Dashboard') }}</div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <div class="colorText">
                                {{ _('Hola '. auth()->user()->name) }}
                                @foreach (auth()->user()->roles as $rol)
                                    {{ _('Tu rol es: '. $rol->name) }}
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
