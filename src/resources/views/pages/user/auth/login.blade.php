@extends('wine-supervisor::master')

@section('page-title') Connexion | WineSupervisor @endsection

@section('main-content')

    <div class="login-template">

        @include('wine-supervisor::pages.user.includes.header')

        <div class="main-content container">

            @if (isset($error))
                <div class="alert alert-danger" style="margin-top: 10rem;">
                    {{ $error }}
                </div>
            @endif

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>Se connecter</h1>

                <div class="login">
                    <form class="login form-horizontal" role="form" method="POST" action="{{ route('user_login_handler') }}">
                        <div class="input-login">
                            <input type="text" name="login" />
                        </div>

                        <div class="input-password">
                            <input type="password" name="password" autocomplete="off" />
                        </div>

                        <input type="submit" value="{{ trans('wine-supervisor::login.login') }}" />
                        <a class="forgotten-password" href="{{ route('forgotten_password') }}">{{ trans('wine-supervisor::login.forgotten_password') }}</a>

                        {!! csrf_field() !!}
                    </form>
                </div>
            </div>
            <!-- PAGE HEADER -->

        </div>
    </div>

@endsection
