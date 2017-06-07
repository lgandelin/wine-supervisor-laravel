@extends('wine-supervisor::default')

@section('page-content')
    <tr class="dashboard-template">

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

        <h1>Dashboard - Utilisateur</h1>

        <a href="{{ route('user_logout') }}">Logout</a>

        <h2>Mes caves</h2>

        @if ($cellars)
            <table>
                <tr>
                    <th>Nom</th>
                    <th>Action</th>
                    </tr>
                @foreach($cellars as $cellar)
                    <tr>
                        <td>@if ($cellar->name){{ $cellar->name }}@endif</td>
                        <td>
                            <a href="{{ route('user_cellar_update', ['id' => $cellar->id]) }}">Modifier</a>
                            <a href="{{ route('user_cellar_delete_handler', ['id' => $cellar->id]) }}">Supprimer</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        @endif

        <a href="{{ route('user_cellar_create') }}">Ajouter une cave</a>
    </div>
@stop