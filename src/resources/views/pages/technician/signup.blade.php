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

        <h1>Création d'un professionnel</h1>

        <form action="{{ route('technician_signup_handler') }}" method="POST">

            <div>
                <label for="company">Nom de la société</label>
                <input type="text" name="company" id="company" value="{{ old('company') }}" />
            </div>

            <div>
                <label for="registration">Immatriculation</label>
                <input type="text" name="registration" id="registration" value="{{ old('registration') }}"/>
            </div>

            <div>
                <label for="phone">Téléphone</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}"/>
            </div>

            <div>
                <label for="email">Email</label>
                <input type="text" name="email" id="email" value="{{ old('email') }}"/>
            </div>

            <div>
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" />
            </div>

            <div>
                <label for="address">Adresse</label>
                <input type="text" name="address" id="address" value="{{ old('address') }}"/>
            </div>

            <div>
                <label for="zipcode">Code postal</label>
                <input type="text" name="zipcode" id="zipcode" value="{{ old('zipcode') }}"/>
            </div>

            <div>
                <label for="city">Ville</label>
                <input type="text" name="city" id="city" value="{{ old('city') }}"/>
            </div>

            <input type="submit" value="Valider" />
            {{ csrf_field() }}
        </form>

    </div>
@stop