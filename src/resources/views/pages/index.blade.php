@extends('wine-supervisor::default')

@section('page-content')
    @if (!$is_user && !$is_guest)
        <a href="{{ route('user_signup') }}">Créer un compte utilisateur</a> |
        <a href="{{ route('technician_signup') }}">Créer un compte professionnel</a> |
        <a href="{{ route('user_login') }}">Se connecter</a>
    @endif

    @if ($is_eligible_to_club_premium)
        <a href="{{ route('club_premium') }}">Club Premium</a>
    @endif

    @if ($is_eligible_to_supervision)
        <a href="{{ url('supervision') }}">Supervision</a>
    @endif

    @if ($is_user)
        <a href="{{ route('user_cellar_list') }}">Mes caves</a>
    @endif

    <h1>WineSupervisor</h1>

@stop