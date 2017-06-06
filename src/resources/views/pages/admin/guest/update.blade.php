@extends('wine-supervisor::default')

@section('page-content')
    <div class="cellar-template">

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

        <h1>Editer un invité</h1>

        <form action="{{ route('admin_guest_update_handler') }}" method="POST">

            <div>
                <label for="first_name">Prénom</label>
                <input type="text" name="first_name" id="first_name" value="{{ $guest->first_name }}" />
            </div>

            <div>
                <label for="last_name">Nom</label>
                <input type="text" name="last_name" id="last_name" value="{{ $guest->last_name }}" />
            </div>

            <div>
                <label for="access_start_date">Date de début d'accès</label>
                <input type="text" name="access_start_date" id="access_start_date" value="{{ \DateTime::createFromFormat('Y-m-d', $guest->access_start_date)->format('d/m/Y') }}" class="datepicker" />
            </div>

            <div>
                <label for="access_end_date">Date de fin d'accès</label>
                <input type="text" name="access_end_date" id="access_end_date" value="{{ \DateTime::createFromFormat('Y-m-d', $guest->access_end_date)->format('d/m/Y') }}" class="datepicker" />
            </div>

            <div>
                <label for="login">Login</label>
                <input type="text" name="login" id="login" value="{{ $guest->login }}" />
            </div>

            <div>
                <label for="login">Mot de passe</label>
                <input type="password" name="password" id="password" value="" autocomplete="off" />
                <i>Laisser vide pour ne pas modifier le mot de passe</i>
            </div>

            <div>
                <label for="email">Email</label>
                <input type="text" name="email" id="email" value="{{ $guest->email }}" />
            </div>

            <div>
                <label for="phone">Téléphone</label>
                <input type="text" name="phone" id="phone" value="{{ $guest->phone }}" />
            </div>

            <div>
                <label for="address">Adresse</label>
                <input type="text" name="address" id="address" value="{{ $guest->address }}" />
            </div>

            <div>
                <label for="zipcode">Code postal</label>
                <input type="text" name="zipcode" id="zipcode" value="{{ $guest->zipcode }}" />
            </div>

            <div>
                <label for="city">Ville</label>
                <input type="text" name="city" id="city" value="{{ $guest->city }}" />
            </div>

            <a href="{{ route('admin_guest_list') }}">Retour</a>
            <input type="submit" value="Valider" />
            <input type="hidden" name="guest_id" value="{{ $guest->id }}" />
            {{ csrf_field() }}
        </form>

    </div>
@stop