@extends('wine-supervisor::default')

@section('page-content')

    @include('wine-supervisor::pages.user.includes.menu')

    <div class="user-cellar-template">

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

        <h1>Tableau de bord</h1>

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
                        </td>
                    </tr>
                @endforeach
            </table>
        @endif

        <a href="{{ route('user_cellar_create') }}">Ajouter une cave</a>
    </div>
@stop