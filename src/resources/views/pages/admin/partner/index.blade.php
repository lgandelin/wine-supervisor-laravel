@extends('wine-supervisor::default')

@section('page-name') Gestion des partenaires < Administration | WineSupervisor @endsection

@section('page-content')

    @include('wine-supervisor::pages.admin.includes.header')

    <div class="partner-template admin-template">

        <!-- MAIN CONTENT -->
        <div class="main-content container">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>Gestion des partenaires</h1>
            </div>
            <!-- PAGE HEADER -->

            <!-- PAGE CONTENT -->
            <div class="page-partner">

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

                <a href="{{ route('admin_partner_create') }}" class="add">Créer une partenaire</a>

                <table class="table-list less-padding">
                    <tr class="table-row">
                        <td class="table-cell table-cell-header align-left">Ordre</td>
                        <th class="table-cell table-cell-header @if ($sort_column == 'name') current-filter @endif"><a href="{{ route('admin_partner_list', ['sc' => 'name', 'so' => $sort_order]) }}">Titre</a></th>
                        <th class="table-cell table-cell-header @if ($sort_column == 'display_start_date' || !$sort_column) current-filter @endif"><a href="{{ route('admin_partner_list', ['sc' => 'display_start_date', 'so' => $sort_order]) }}">Date de publication</a></th>
                        <th class="table-cell table-cell-header @if ($sort_column == 'display_end_date' || !$sort_column) current-filter @endif"><a href="{{ route('admin_partner_list', ['sc' => 'display_start_date', 'so' => $sort_order]) }}">Date de publication</a></th>
                        <td class="table-cell table-cell-header align-left">En ligne</td>
                        <th class="table-cell table-cell-header">Action</th>
                    </tr>
                    @foreach ($partners as $partner)
                        <tr class="table-row">
                            <td class="table-cell align-left">{{ $partner->position }}</td>
                            <td class="table-cell align-left">{{ $partner->name }}</td>
                            <td class="table-cell align-left">@if ($partner->display_start_date){{ \DateTime::createFromFormat('Y-m-d', $partner->display_start_date)->format('d/m/Y') }}@endif</td>
                            <td class="table-cell align-left">@if ($partner->display_end_date){{ \DateTime::createFromFormat('Y-m-d', $partner->display_end_date)->format('d/m/Y') }}@endif</td>
                            <td class="table-cell align-left">@if ($partner->is_active) Oui @else Non @endif</td>
                            <td class="table-cell align-left action" width="15%">
                                <a href="{{ route('admin_partner_update', $partner->id) }}"><button class="edit">Modifier</button></a>
                                <a href="{{ route('admin_partner_delete_handler', $partner->id) }}"><button class="delete">Supprimer</button></a>
                            </td>
                        </tr>
                    @endforeach
                </table>

                <a href="{{ route('admin_partner_create') }}" class="add">Créer un partenaire</a>
            </div>
            <!-- PAGE CONTENT -->

        </div>
        <!-- MAIN CONTENT -->

    </div>
@stop