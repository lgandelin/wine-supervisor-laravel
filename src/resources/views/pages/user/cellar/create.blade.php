@extends('wine-supervisor::default')

@section('page-content')
    <div class="signup-template">

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

        <h1>Création d'une cave</h1>

        <form action="{{ route('user_cellar_create_handler') }}" method="POST">

            <div>
                <label for="id_ws">Adresse Mak</label>
                <input type="text" name="id_ws" id="id_ws" />
            </div>

            <div>
                <label for="id_ws">ID Professionnel</label>
                <input type="text" name="technician_id" id="technician_id" />
            </div>

            <div>
                <label for="name">Nom de la cave (optionnel)</label>
                <input type="text" name="name" id="name" />
            </div>

            <div>
                <label for="serial_number">N° de série</label>
                <input type="text" name="serial_number" id="serial_number" />
            </div>

            <div>
                <label for="address">Adresse</label>
                <input type="text" name="address" id="address" />
            </div>

            <div>
                <label for="zipcode">Code postal</label>
                <input type="text" name="zipcode" id="zipcode" />
            </div>

            <div>
                <label for="city">Ville</label>
                <input type="text" name="city" id="city" />
            </div>

            <a href="{{ route('user_index') }}">Retour</a>
            <input type="submit" value="Valider" />
            {{ csrf_field() }}
        </form>

    </div>
@stop