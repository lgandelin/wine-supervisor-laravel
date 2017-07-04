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
                        <td class="table-cell table-cell-header">Action</th>
                    </tr>
                    @foreach ($cellars as $cellar)
                        <tr class="table-row">
                            <td class="table-cell">{{ $cellar->id_ws }}</td>
                            <td class="table-cell align-left">{{ $cellar->user->last_name }} {{ $cellar->user->first_name }}</td>
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