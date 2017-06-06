@extends('wine-supervisor::default')

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

        <h1>Créer une vente</h1>

        <form action="{{ route('admin_sale_create_handler') }}" method="POST">

            <a href="{{ route('admin_ws_list') }}">Retour</a>
            <input type="submit" value="Valider" />
            {{ csrf_field() }}
        </form>

    </div>
@stop