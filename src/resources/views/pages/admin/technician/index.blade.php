@extends('wine-supervisor::default')

@section('page-title') Gestion des techniciens < Administration | WineSupervisor @endsection

@section('page-content')

    @include('wine-supervisor::pages.admin.includes.header')

    <div class="technician-template admin-template">

        <!-- MAIN CONTENT -->
        <div class="main-content container">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>Gestion des techniciens</h1>
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
                        <td class="table-cell table-cell-header align-left @if ($sort_column == 'company') current-filter @endif"><a href="{{ route('admin_technician_list', ['sc' => 'company', 'so' => $sort_order]) }}">Nom de la société</a></td>
                        <td class="table-cell table-cell-header align-left @if ($sort_column == 'email') current-filter @endif"><a href="{{ route('admin_technician_list', ['sc' => 'email', 'so' => $sort_order]) }}">Email</a></td>
                        <td class="table-cell table-cell-header align-left @if ($sort_column == 'status') current-filter @endif"><a href="{{ route('admin_technician_list', ['sc' => 'status', 'so' => $sort_order]) }}">Statut</a></td>
                        <td class="table-cell table-cell-header align-left @if ($sort_column == 'created_at' || !$sort_column) current-filter @endif"><a href="{{ route('admin_technician_list', ['sc' => 'created_at', 'so' => $sort_order]) }}">Date de création</a></td>
                        <td class="table-cell table-cell-header align-left @if ($sort_column == 'read_only') current-filter @endif"><a href="{{ route('admin_technician_list', ['sc' => 'read_only', 'so' => $sort_order]) }}">Lecture seule</a></td>
                        <td class="table-cell table-cell-header align-left">Action</td>
                    </tr>

                    @foreach ($technicians as $technician)
                        <tr class="table-row">
                            <td class="table-cell align-left">{{ $technician->company }}</td>
                            <td class="table-cell align-left truncate"><a href="mailto:{{ $technician->email }}">{{ $technician->email }}</a></td>
                            <td class="table-cell align-left">@if ($technician->status == Webaccess\WineSupervisorLaravel\Models\Technician::STATUS_ENABLED) Activé @else Désactivé @endif
                            <td class="table-cell align-left">@if ($technician->created_at){{ DateTime::createFromFormat('Y-m-d H:i:s', $technician->created_at)->format('d/m/y') }}@endif</td>
                            <td class="table-cell align-left">@if ($technician->read_only) Oui @else Non @endif</td>
                            <td class="table-cell align-left action" width="15%">
                                <a href="{{ route('admin_technician_update', $technician->id) }}"><button class="edit">Modifier</button></a>
                                <a href="{{ route('admin_technician_delete_handler', $technician->id) }}"><button class="delete">Supprimer</button></a>
                            </td>
                        </tr>
                    @endforeach
                </table>

            </div>
            <!-- PAGE CONTENT -->

        </div>
        <!-- MAIN CONTENT -->

    </div>
@stop