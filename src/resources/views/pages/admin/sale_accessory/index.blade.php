@extends('wine-supervisor::default')

@section('page-title') Gestion des ventes d'accessoires < Administration | WineSupervisor @endsection

@section('page-content')

    @include('wine-supervisor::pages.admin.includes.header')

    <div class="sale-template admin-template">

        <!-- MAIN CONTENT -->
        <div class="main-content container">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>Gestion des ventes d'accessoires</h1>
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
                
                <a href="{{ route('admin_accessories_sale_create') }}" class="add">Créer une vente d'accessoire</a>

                <table class="table-list">
                    <tr class="table-row">
                        <td class="table-cell table-cell-header align-left @if ($sort_column == 'title') current-filter @endif"><a href="{{ route('admin_accessories_sale_list', ['sc' => 'title', 'so' => $sort_order]) }}">Titre</a></td>
                        <td class="table-cell table-cell-header align-left @if ($sort_column == 'start_date') current-filter @endif"><a href="{{ route('admin_accessories_sale_list', ['sc' => 'start_date', 'so' => $sort_order]) }}">Date de début</a></td>
                        <td class="table-cell table-cell-header align-left @if ($sort_column == 'end_date') current-filter @endif"><a href="{{ route('admin_accessories_sale_list', ['sc' => 'end_date', 'so' => $sort_order]) }}">Date de fin</a></td>
                        <td class="table-cell table-cell-header align-left">En ligne</td>
                        <td class="table-cell table-cell-header" width="15%">Action</td>
                    </tr>
                    @foreach ($sales as $sale)
                        <tr class="table-row">
                            <td class="table-cell align-left">{{ $sale->title }}</td>
                            <td class="table-cell align-left">@if ($sale->start_date){{ \DateTime::createFromFormat('Y-m-d', $sale->start_date)->format('d/m/Y') }}@endif</td>
                            <td class="table-cell align-left">@if ($sale->end_date){{ \DateTime::createFromFormat('Y-m-d', $sale->end_date)->format('d/m/Y') }}@endif</td>
                            <td class="table-cell align-left">@if ($sale->is_active) Oui @else Non @endif</td>
                            <td class="table-cell align-left action">
                                <a href="{{ route('admin_accessories_sale_update', $sale->id) }}"><button class="edit">Modifier</button></a>
                                <a href="{{ route('admin_accessories_sale_delete_handler', $sale->id) }}"><button class="delete">Supprimer</button></a>
                            </td>
                        </tr>
                    @endforeach
                </table>

                <a href="{{ route('admin_accessories_sale_create') }}" class="add">Créer une vente d'accessoire</a>

            </div>
            <!-- PAGE CONTENT -->

        </div>
        <!-- MAIN CONTENT -->

    </div>
@stop