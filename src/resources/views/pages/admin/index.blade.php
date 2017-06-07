@extends('wine-supervisor::default')

@section('page-title'){{ trans('wine-supervisor::dashboard.meta_title') }}@endsection

@section('page-content')

    @include('wine-supervisor::pages.admin.includes.menu')

    <div class="dashboard-template">

        @if (isset($error))
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        @endif

        @if (isset($confirmation))
            <div class="alert alert-success">
                {{ $confirmation }}
            </div>
        @endif

        <h1>Tableau de bord</h1>
    </div>
@stop