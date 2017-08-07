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

                @if (isset($is_technician) && $is_technician)
                    <p>Votre accès professionnel ne vous donne pas droit aux ventes du Club Avantage Wine Supervisor. Si vous désirez un code pour accédez à une vente, faites-nous
                        une demande avec le formulaire de l’onglet <a style="font-weight:bold; color: white" href="{{ route('contact') }}">contact</a> du site en précisant votre nom, prénom, votre société et le nom de la vente qui vous intéresse.
                        En tant que partenaire WineSupervisor nous vous communiquerons un code personnel pour y accéder.
                    </p>
                @endif

                @if (isset($is_eligible_to_club_premium) && !$is_eligible_to_club_premium)
                    <p>Votre compte ne vous donne pas droit aux ventes du Club Avantage Wine Supervisor.</p>
                @endif

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

                        <input type="hidden" name="route" @if (isset($next_route) && $next_route)value="{{ $next_route }}"@endif />
                        {!! csrf_field() !!}
                    </form>
                </div>
            </div>
            <!-- PAGE HEADER -->

        </div>
    </div>

@endsection
