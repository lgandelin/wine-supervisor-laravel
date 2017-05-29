@extends('wine-supervisor::default')

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

        <h1>Dashboard - Utilisateur</h1>

        <a href="{{ route('user_logout') }}">Logout</a>

        <h2>Mes caves</h2>

        @if ($cellars)
            <div class="cellars">
                @foreach($cellars as $cellar)
                    <div>
                        {{ $cellar->id }}
                        {{ $cellar->technician_id }}
                        <h2>{{ $cellar->name }}</h2>
                        <a href="{{ route('user_cellar_update', ['id' => $cellar->id]) }}">Editer</a>
                        <a href="{{ route('user_cellar_delete_handler', ['id' => $cellar->id]) }}">Supprimer</a>
                        <hr>
                    </div>
                @endforeach
            </div>
        @endif

        <a href="{{ route('user_cellar_create') }}">Ajouter une cave</a>
    </div>
@stop