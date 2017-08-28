@extends('wine-supervisor::default')

@section('page-title') Gestion des invités < Administration | WineSupervisor @endsection

@section('page-content')

    @include('wine-supervisor::pages.admin.includes.header')

    <div class="guest-template admin-template">

        <!-- MAIN CONTENT -->
        <div class="main-content container">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>Gestion des invités</h1>
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

                <table class="table-list less-padding">
                    <tr class="table-row">
                        <th class="table-cell table-cell-header @if ($sort_column == 'last_name') current-filter @endif"><a href="{{ route('admin_guest_list', ['sc' => 'last_name', 'so' => $sort_order]) }}">Nom complet</a></th>
                        <th class="table-cell table-cell-header @if ($sort_column == 'email') current-filter @endif"><a href="{{ route('admin_guest_list', ['sc' => 'email', 'so' => $sort_order]) }}">Email</a></th>
                        <th class="table-cell table-cell-header @if ($sort_column == 'login') current-filter @endif"><a href="{{ route('admin_guest_list', ['sc' => 'login', 'so' => $sort_order]) }}">Login</a></th>
                        <th class="table-cell table-cell-header @if ($sort_column == 'access_start_date' || !$sort_column) current-filter @endif"><a href="{{ route('admin_guest_list', ['sc' => 'access_start_date', 'so' => $sort_order]) }}">Début</a></th>
                        <th class="table-cell table-cell-header @if ($sort_column == 'access_end_date') current-filter @endif"><a href="{{ route('admin_guest_list', ['sc' => 'access_end_date', 'so' => $sort_order]) }}">Fin</a></th>
                        <th class="table-cell table-cell-header">Action</th>
                    </tr>
                    @foreach ($guests as $guest)
                        <tr class="table-row">
                            <td class="table-cell align-left">{{ $guest->last_name }} {{ $guest->first_name }}</td>
                            <td class="table-cell align-left truncate"><a href="mailto:{{ $guest->email }}">{{ $guest->email }}</a></td>
                            <td class="table-cell align-left">{{ $guest->login }}</td>
                            <td class="table-cell align-left">@if ($guest->access_start_date){{ \DateTime::createFromFormat('Y-m-d', $guest->access_start_date)->format('d/m/y') }}@endif</td>
                            <td class="table-cell align-left">@if ($guest->access_end_date){{ \DateTime::createFromFormat('Y-m-d', $guest->access_end_date)->format('d/m/y') }}@endif</td>
                            <td class="table-cell align-left action">
                                <a href="{{ route('admin_guest_update', $guest->id) }}"><button class="edit">Modifier</button></a>
                                <a href="{{ route('admin_guest_delete_handler', $guest->id) }}"><button class="delete">Supprimer</button></a>
                            </td>
                        </tr>
                    @endforeach
                </table>

                <a href="{{ route('admin_guest_create') }}" class="add">Créer un invité</a>
            </div>
            <!-- PAGE CONTENT -->

        </div>
        <!-- MAIN CONTENT -->

    </div>
@stop