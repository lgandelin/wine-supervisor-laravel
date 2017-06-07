@extends('wine-supervisor::default')

@section('page-content')

    @include('wine-supervisor::pages.admin.includes.menu')

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

        <h1>Gestion des ventes</h1>

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
                    <td>{{ \DateTime::createFromFormat('Y-m-d', $sale->start_date)->format('d/m/Y') }}</td>
                    <td>{{ \DateTime::createFromFormat('Y-m-d', $sale->end_date)->format('d/m/Y') }}</td>
                    <td><a href="{{ route('admin_sale_update', $sale->id) }}">Modifier</a></td>
                    <td><a href="{{ route('admin_sale_delete_handler', $sale->id) }}">Supprimer</a></td>
                </tr>
            @endforeach
        </table>

        <a href="{{ route('admin_sale_create') }}">Créer une vente</a>
    </div>
@stop