@extends('layouts.dashboard')

@section('title', $title)

@section('content')
    <div class="home-tab">
        <div class="tab-content tab-content-basic">
            <div class="row justify-content-center">
                @if (auth()->user()->kpiViewAuthorization())
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">{{ __('Indices de KPI') }}</div>
                            <div class="card-body">
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                <div class="colorText">
                                    <iframe title="KPI MELTEC 2023 V3" width="100%" height="768"
                                        src="https://app.powerbi.com/reportEmbed?reportId=34da48bd-c499-4800-980b-0f4d1d4ded8b&autoAuth=true&ctid=d396c4f8-3298-489e-8bd4-1df6b2a47184&navContentPaneEnabled=false"
                                        frameborder="0" allowFullScreen="true"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
