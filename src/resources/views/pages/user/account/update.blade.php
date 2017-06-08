@extends('wine-supervisor::default')

@section('page-content')
    <div class="my-account-template">

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

        <h1>Mon compte</h1>

        <form action="{{ route('user_update_account_handler') }}" method="POST">

            <div>
                <label for="last_name">Nom</label>
                <input type="text" name="last_name" id="last_name" value="{{ $user->last_name }}" />
            </div>

            <div>
                <label for="first_name">Prénom</label>
                <input type="text" name="first_name" id="first_name" value="{{ $user->first_name }}"/>
            </div>

            <div>
                <label for="email">Email</label>
                <input type="text" name="email" id="email" value="{{ $user->email }}" autocomplete="off" />
            </div>

            <div>
                <label for="login">Login</label>
                <input type="text" name="login" id="login" value="{{ $user->login }}" autocomplete="off" />
            </div>

            <div>
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" autocomplete="new-password" />
                <i>Laisser vide pour ne pas modifier le mot de passe</i>
            </div>

            <div>
                <label for="opt_in">S'inscrire à la newsletter</label>
                <input type="checkbox" name="opt_in" id="opt_in" @if ($user->opt_in == true || $user->opt_in === null)checked="checked"@endif />
            </div>

            <input type="submit" value="Valider" />
            {{ csrf_field() }}
        </form>

    </div>
@stop