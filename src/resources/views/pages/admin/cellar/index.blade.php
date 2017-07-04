@extends('wine-supervisor::default')

@section('page-content')

    @include('wine-supervisor::pages.admin.includes.header')

    <div class="ws-template">

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

        <h1>Gestion des caves</h1>

        <table>
            <tr>
                <th>ID WS</th>
                <th>Utilisateur</th>
                <th>Action</th>
            </tr>
            @foreach ($cellars as $cellar)
                <tr>
                    <td>{{ $cellar->id_ws }}</td>
                    <td>{{ $cellar->user->last_name }} {{ $cellar->user->first_name }}</td>
                    <td><a href="{{ route('admin_cellar_update', $cellar->id) }}">Modifier</a></td>
                </tr>
            @endforeach
        </table>
    </div>
@stop