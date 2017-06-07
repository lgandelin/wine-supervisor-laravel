@extends('wine-supervisor::default')

@section('page-title'){{ trans('wine-supervisor::dashboard.meta_title') }}@endsection

@section('page-content')

    @include('wine-supervisor::pages.admin.includes.menu')

    <div class="ws-template">

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

        <h1>Gestion des WineSupervisor</h1>

        <table>
            <tr>
                <th>ID</th>
                <th>Type de carte</th>
                <th>Action</th>
            </tr>
            @foreach ($wss as $ws)
                <tr>
                    <td>{{ $ws->id }}</td>
                    <td>{{ Webaccess\WineSupervisorLaravel\Services\WSManager::getBoardTypeLabel($ws->board_type) }}</td>
                    <td><a href="{{ route('admin_ws_update', $ws->id) }}">Modifier</a></td>
                </tr>
            @endforeach
        </table>

        <a href="{{ route('admin_logout') }}">Logout</a>
    </div>
@stop