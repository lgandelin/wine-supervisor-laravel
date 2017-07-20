@extends('wine-supervisor::default')

@section('page-title') Gestion des professionnels < Administration | WineSupervisor @endsection

@section('page-content')

    @include('wine-supervisor::pages.admin.includes.header')

    <div class="technician-template admin-template">

        <!-- MAIN CONTENT -->
        <div class="main-content container">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>Gestion des professionnels</h1>
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
                        <td class="table-cell table-cell-header align-left">Nom de la société</td>
                        <td class="table-cell table-cell-header align-left">Email</td>
                        <td class="table-cell table-cell-header align-left">Statut</td>
                        <td class="table-cell table-cell-header align-left">Action</td>
                    </tr>

                    @foreach ($technicians as $technician)
                        <tr class="table-row">
                            <td class="table-cell align-left">{{ $technician->company }}</td>
                            <td class="table-cell align-left"><a href="mailto:{{ $technician->email }}">{{ $technician->email }}</a></td>
                            <td class="table-cell align-left">@if ($technician->status == Webaccess\WineSupervisorLaravel\Models\Technician::STATUS_ENABLED) Activé @else Désactivé @endif
                            <td class="table-cell align-left action"><a href="{{ route('admin_technician_update', $technician->id) }}"><button class="edit">Modifier</button></a></td>
                        </tr>
                    @endforeach
                </table>

            </div>
            <!-- PAGE CONTENT -->

        </div>
        <!-- MAIN CONTENT -->

    </div>
@stop