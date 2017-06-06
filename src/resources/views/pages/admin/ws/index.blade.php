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

        <h1>Dashboard - Gestion des WineSupervisor</h1>

        <table>
            <tr>
                <th>ID</th>
                <th>Type de carte</th>
                <th>Action</th>
            </tr>
            @foreach ($wss as $ws)
                <tr>
                    <td><h2>{{ $ws->id }}</h2></td>
                    <td>{{ Webaccess\WineSupervisorLaravel\Services\WSManager::getBoardTypeLabel($ws->board_type) }}</td>
                    <td><a href="{{ route('admin_ws_update', $ws->id) }}">Modifier</a></td>
                </tr>
            @endforeach
        </table>

        <a href="{{ route('admin_logout') }}">Logout</a>
    </div>
@stop