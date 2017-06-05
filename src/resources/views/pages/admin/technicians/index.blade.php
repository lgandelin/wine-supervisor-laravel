@extends('wine-supervisor::default')

@section('page-title'){{ trans('wine-supervisor::dashboard.meta_title') }}@endsection

@section('page-content')
    <div class="dashboard-template">

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

        <h1>Dashboard - Gestion des professionnels</h1>

        <table>
            <tr>
                <th>Nom de la société</th>
                <th>Email</th>
                <th>Statut</th>
                <th>Action</th>
            </tr>
            @foreach ($technicians as $technician)
                <tr>
                    <td><h2>{{ $technician->company }}</h2></td>
                    <td><a href="mailto:{{ $technician->email }}">{{ $technician->email }}</a></td>
                    <td>@if ($technician->status == Webaccess\WineSupervisorLaravel\Models\Technician::STATUS_ENABLED) Activé @else Désactivé @endif
                    <td><a href="{{ route('admin_technician_update', $technician->id) }}" class="btn">Modifier</a></td>
                </tr>
            @endforeach
        </table>

        <a href="{{ route('admin_logout') }}">Logout</a>
    </div>
@stop