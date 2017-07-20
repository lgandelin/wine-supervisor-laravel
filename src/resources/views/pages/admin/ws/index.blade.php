@extends('wine-supervisor::default')

@section('page-title') Gestion des WineSupervisor < Administration | WineSupervisor @endsection

@section('page-content')

    @include('wine-supervisor::pages.admin.includes.header')

    <div class="ws-template admin-template">

        <!-- MAIN CONTENT -->
        <div class="main-content container">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>Gestion des WineSupervisor</h1>
            </div>
            <!-- PAGE HEADER -->

            <!-- PAGE CONTENT -->
            <div class="page-content">

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

                <table class="table-list">
                    <tr class="table-row">
                        <td class="table-cell table-cell-header align-left">ID</td>
                        <td class="table-cell table-cell-header align-left">Type de carte</td>
                        <td class="table-cell table-cell-header">Action</td>
                    </tr>
                    @foreach ($wss as $ws)
                        <tr class="table-row">
                            <td class="table-cell">{{ $ws->id }}</td>
                            <td class="table-cell">{{ Webaccess\WineSupervisorLaravel\Services\WSService::getBoardTypeLabel($ws->board_type) }}</td>
                            <td class="table-cell action"><a href="{{ route('admin_ws_update', $ws->id) }}"><button class="edit">Modifier</button></a></td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <!-- PAGE CONTENT -->

        </div>
        <!-- MAIN CONTENT -->

    </div>
@stop