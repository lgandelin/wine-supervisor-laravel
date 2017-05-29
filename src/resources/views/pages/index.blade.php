@extends('wine-supervisor::default')

@section('page-content')
    <a href="{{ route('user_signup') }}">Créer un compte</a>
    <a href="{{ route('user_login') }}">Se connecter</a>

    <h1>Public site</h1>

@stop