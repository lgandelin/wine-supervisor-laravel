@extends('wine-supervisor::master')

@section('page-title') Mot de passe oublié | WineSupervisor @endsection

@section('main-content')

    <div class="login-template">

        @include('wine-supervisor::pages.user.includes.header')

        <div class="main-content container">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>Mot de passe oublié</h1>

                <div class="login">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('forgotten_password_handler') }}">
                        <div class="input-login">
                            <input type="text" name="email" value="{{ old('email') }}" placeholder="Votre email" />
                        </div>

                        <input type="submit" class="btn btn-valid" value="M'envoyer un nouveau mot de passe" />
                        <a href="{{ route('user_login') }}" title="Retour" class="back-link">Retour</a>

                        {!! csrf_field() !!}
                    </form>
                </div>
            </div>
            <!-- PAGE HEADER -->

            @if ($message)
                <div class="alert alert-success">
                    {{ $message }}
                </div>
            @endif

            @if ($error)
                <div class="alert alert-danger">
                    {{ $error }}
                </div>
            @endif

        </div>
    </div>

@endsection