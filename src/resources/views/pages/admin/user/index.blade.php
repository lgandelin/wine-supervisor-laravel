@extends('wine-supervisor::default')

@section('page-title') Gestion des utilisateurs < Administration | WineSupervisor @endsection

@section('page-content')

    @include('wine-supervisor::pages.admin.includes.header')

    <div class="technician-template admin-template">

        <!-- MAIN CONTENT -->
        <div class="main-content container">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>Gestion des utilisateurs</h1>
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
                        <td class="table-cell table-cell-header align-left @if ($sort_column == 'last_name') current-filter @endif"><a href="{{ route('admin_user_list', ['sc' => 'last_name', 'so' => $sort_order]) }}">Nom complet</a></td>
                        <td class="table-cell table-cell-header align-left @if ($sort_column == 'email') current-filter @endif"><a href="{{ route('admin_user_list', ['sc' => 'email', 'so' => $sort_order]) }}">Email</a></td>
                        <td class="table-cell table-cell-header align-left @if ($sort_column == 'created_at' || !$sort_column) current-filter @endif"><a href="{{ route('admin_user_list', ['sc' => 'created_at', 'so' => $sort_order]) }}">Date de création</a></td>
                        <td class="table-cell table-cell-header align-left @if ($sort_column == 'last_connection_date') current-filter @endif"><a href="{{ route('admin_user_list', ['sc' => 'last_connection_date', 'so' => $sort_order]) }}">Dernière connexion</a></td>
                        <td class="table-cell table-cell-header align-left @if ($sort_column == 'read_only') current-filter @endif"><a href="{{ route('admin_user_list', ['sc' => 'read_only', 'so' => $sort_order]) }}">Lecture seule</a></td>
                        <td class="table-cell table-cell-header align-left">Action</td>
                    </tr>

                    @foreach ($users as $user)
                        <tr class="table-row">
                            <td class="table-cell align-left">{{ $user->last_name }} {{ $user->first_name }}</td>
                            <td class="table-cell align-left truncate"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                            <td class="table-cell align-left">@if ($user->created_at){{ DateTime::createFromFormat('Y-m-d H:i:s', $user->created_at)->format('d/m/y') }}@endif</td>
                            <td class="table-cell align-left">@if ($user->last_connection_date){{ DateTime::createFromFormat('Y-m-d H:i:s', $user->last_connection_date)->format('d/m/y') }}@endif</td>
                            <td class="table-cell align-left">@if ($user->read_only) Oui @else Non @endif</td>
                            <td class="table-cell align-left action" width="10%"><a href="{{ route('admin_user_update', $user->id) }}"><button class="edit">Modifier</button></a></td>
                        </tr>
                    @endforeach
                </table>

            </div>
            <!-- PAGE CONTENT -->

        </div>
        <!-- MAIN CONTENT -->

    </div>
@stop