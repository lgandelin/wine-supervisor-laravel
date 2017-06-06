@extends('wine-supervisor::default')

@section('page-title'){{ trans('wine-supervisor::dashboard.meta_title') }}@endsection

@section('page-content')
    <div class="sale-template">

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

        <h1>Dashboard - Gestion des ventes</h1>

        <table>
            <tr>
                <th>Titre</th>
                <th>Date de début</th>
                <th>Date de fin</th>
                <th>Action</th>
            </tr>
            @foreach ($sales as $sale)
                <tr>
                    <td>{{ $sale->title }}</td>
                    <td>{{ $sale->start_date }}</td>
                    <td>{{ $sale->end_date }}</td>
                    <td><a href="{{ route('admin_sale_update', $sale->id) }}">Modifier</a></td>
                </tr>
            @endforeach
        </table>

        <a href="{{ route('admin_sale_create') }}">Ajouter une vente</a>
        <a href="{{ route('admin_logout') }}">Logout</a>
    </div>
@stop