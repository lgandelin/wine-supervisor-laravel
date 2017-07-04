@extends('wine-supervisor::default')

@section('page-content')

    <div class="error-template">

        @include('wine-supervisor::pages.user.includes.header')

        <!-- BANNER -->
        <div class="banner" id="top">
            <h1>
                <span class="title">Page non trouvée</span>
            </h1>
            <span class="border"></span>
        </div>
        <!-- BANNER -->

        <div class="container">
            <p>Votre page n'a pas pu être trouvée. Veuillez vous assurer que vous avez tapé la bonne URL.</p>

            <a href="{{ route('index') }}">Retour à la page d'accueil</a>
        </div>
    </div>

@endsection
