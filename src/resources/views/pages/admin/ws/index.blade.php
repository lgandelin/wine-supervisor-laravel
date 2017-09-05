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
                        <td class="table-cell table-cell-header align-left @if ($sort_column == 'id') current-filter @endif"><a href="{{ route('admin_ws_list', ['sc' => 'id', 'so' => $sort_order]) }}">ID</a></td>
                        <td class="table-cell table-cell-header align-left @if ($sort_column == 'first_activation_date' || !$sort_column) current-filter @endif"><a href="{{ route('admin_ws_list', ['sc' => 'first_activation_date', 'so' => $sort_order]) }}">Date de <sup>1ère</sup> activation</a></td>
                        <td class="table-cell table-cell-header align-left @if ($sort_column == 'board_type') current-filter @endif"><a href="{{ route('admin_ws_list', ['sc' => 'board_type', 'so' => $sort_order]) }}">Type de carte</a></td>
                        <td class="table-cell table-cell-header">Action</td>
                    </tr>

                    @foreach ($wss as $ws)
                        <tr class="table-row">
                            <td class="table-cell">{{ $ws->cd_ws_id }}</td>
                            <td class="table-cell">@if ($ws->first_activation_date){{ DateTime::createFromFormat('Y-m-d H:i:s', $ws->first_activation_date)->format('d/m/Y') }}@endif</td>
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