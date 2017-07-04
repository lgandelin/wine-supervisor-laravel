@extends('wine-supervisor::default')

@section('page-content')

    @include('wine-supervisor::pages.admin.includes.header')

    <div class="guest-template">

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

        <h1>Créer un invité</h1>

        <form action="{{ route('admin_guest_create_handler') }}" method="POST">

            <div>
                <label for="first_name">Prénom</label>
                <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" />
            </div>

            <div>
                <label for="last_name">Nom</label>
                <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" />
            </div>

            <div>
                <label for="access_start_date">Date de début d'accès</label>
                <input type="text" name="access_start_date" id="access_start_date" value="{{ old('access_start_date') }}" class="datepicker" />
            </div>

            <div>
                <label for="access_end_date">Date de fin d'accès</label>
                <input type="text" name="access_end_date" id="access_end_date" value="{{ old('access_end_date') }}" class="datepicker" />
            </div>

            <div>
                <label for="login">Login</label>
                <input type="text" name="login" id="login" value="{{ old('login') }}" />
            </div>

            <div>
                <label for="login">Mot de passe</label>
                <input type="password" name="password" id="password" value="" autocomplete="off" />
            </div>

            <div>
                <label for="email">Email</label>
                <input type="text" name="email" id="email" value="{{ old('email') }}" />
            </div>

            <div>
                <label for="phone">Téléphone</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" />
            </div>

            <div>
                <label for="address">Adresse</label>
                <input type="text" name="address" id="address" value="{{ old('address') }}" />
            </div>

            <div>
                <label for="zipcode">Code postal</label>
                <input type="text" name="zipcode" id="zipcode" value="{{ old('zipcode') }}" />
            </div>

            <div>
                <label for="city">Ville</label>
                <input type="text" name="city" id="city" value="{{ old('city') }}" />
            </div>

            <a href="{{ route('admin_guest_list') }}">Retour</a>
            <input type="submit" value="Valider" />
            {{ csrf_field() }}
        </form>

    </div>
@stop