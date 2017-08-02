@extends('wine-supervisor::default')

@section('page-title') Gestion des caves < Administration | WineSupervisor @endsection

@section('page-content')

    @include('wine-supervisor::pages.admin.includes.header')

    <div class="cellar-template admin-template">

        <!-- MAIN CONTENT -->
        <div class="main-content container">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>Gestion des caves</h1>
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
                        <td class="table-cell table-cell-header align-left">ID WS</th>
                        <td class="table-cell table-cell-header align-left">Utilisateur</th>
                        <td class="table-cell table-cell-header align-left">Technicien</th>
                        <td class="table-cell table-cell-header align-left">Date de création</th>
                        <td class="table-cell table-cell-header">Action</th>
                    </tr>
                    @foreach ($cellars as $cellar)
                        <tr class="table-row">
                            <td class="table-cell"><a title="Voir la fiche du WS" href="{{ route('admin_ws_update', ['id_ws' => $cellar->id_ws]) }}">{{ $cellar->id_ws }}</a></td>
                            <td class="table-cell align-left">@if ($cellar->user)<a href="{{ route('admin_user_update', ['uuid' => $cellar->user->id]) }}" title="Voir la fiche de l'utilisateur">{{ $cellar->user->last_name }} {{ $cellar->user->first_name }}</a>@endif</td>
                            <td class="table-cell align-left">@if ($cellar->technician)<a href="{{ route('admin_technician_update', ['uuid' => $cellar->technician->id]) }}" title="Voir la fiche du technicien">{{ $cellar->technician->last_name }} {{ $cellar->technician->first_name }} [{{ $cellar->technician->company }}]</a>@endif</td>
                            <td class="table-cell align-left">@if ($cellar->created_at){{ DateTime::createFromFormat('Y-m-d H:i:s', $cellar->created_at)->format('d/m/Y') }}@endif</td>
                            <td class="table-cell action"><a href="{{ route('admin_cellar_update', $cellar->id) }}"><button class="edit">Modifier</button></a></td>
                        </tr>
                    @endforeach
                </table>

            </div>
            <!-- PAGE CONTENT -->

        </div>
        <!-- MAIN CONTENT -->

    </div>
@stop