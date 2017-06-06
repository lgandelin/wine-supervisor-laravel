@extends('wine-supervisor::default')

@section('page-title'){{ trans('wine-supervisor::dashboard.meta_title') }}@endsection

@section('page-content')
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

        <h1>Dashboard - Administrateur</h1>

        <ul>
            <li><a href="{{ route('admin_ws_list') }}">Gestion des WineSupervisor</a></li>
            <li><a href="{{ route('admin_cellar_list') }}">Gestion des caves</a></li>
            <li><a href="{{ route('admin_technician_list') }}">Gestion des professionnels</a></li>
            <li><a href="{{ route('admin_guest_list') }}">Gestion des invités</a></li>
        </ul>

        <a href="{{ route('admin_logout') }}">Logout</a>
    </div>
@stop