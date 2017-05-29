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

        <h1>Création d'un utilisateur</h1>

        <form action="{{ route('user_signup_handler') }}" method="POST">

            <div>
                <label for="last_name">Nom</label>
                <input type="text" name="last_name" id="last_name" value="{{ $last_name }}" />
            </div>

            <div>
                <label for="first_name">Prénom</label>
                <input type="text" name="first_name" id="first_name" value="{{ $first_name }}"/>
            </div>

            <div>
                <label for="email">Email</label>
                <input type="text" name="email" id="email" value="{{ $email }}"/>
            </div>

            <div>
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" />
            </div>

            <div>
                <label for="opt_in">S'inscrire à la newsletter</label>
                <input type="checkbox" name="opt_in" id="opt_in" @if ($opt_in === true || $opt_in === null)checked="checked"@endif />
            </div>

            <input type="submit" value="Valider" />
            {{ csrf_field() }}
        </form>

    </div>
@stop