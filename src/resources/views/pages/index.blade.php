@extends('wine-supervisor::default')

@section('page-content')
    <a href="{{ route('user_signup') }}">Créer un compte utilisateur</a> |
    <a href="{{ route('technician_signup') }}">Créer un compte professionnel</a> |
    <a href="{{ route('user_login') }}">Se connecter</a>

    <h1>Public site</h1>

@stop