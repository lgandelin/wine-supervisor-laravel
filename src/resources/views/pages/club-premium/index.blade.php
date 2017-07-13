@extends('wine-supervisor::default')

@section('page-title') Informations sur le Club Avantage | WineSupervisor @endsection

@section('page-content')

    <div class="club-premium-template">
        @include('wine-supervisor::pages.user.includes.header')

        <!-- BANNER -->
        <div class="banner">
            <h1><img class="logo-club-premium" src="{{ asset('img/club-premium/logo-club-avantage.png') }}" width="300" height="205" alt="Aux membres du Club Avantage" /></h1>
        </div>
        <!-- BANNER -->

        <div class="main-content container" id="top">

            <!-- LEFT NAVIGATION -->
            <nav class="left-navigation">
                @include('wine-supervisor::pages.club-premium.includes.menu')
            </nav>
            <!-- LEFT NAVIGATION -->

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>Informations</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer a hendrerit justo. Curabitur rhoncus faucibus elit. A hendrerit justo curabitur nteger a hendrerit justo. Curabitur rhoncus faucibus elit. </p>
            </div>
            <!-- PAGE HEADER -->

            <!-- PAGE CONTENT -->
            <div class="page-content text-content">
                <section>
                    <div class="left-image"><img src="{{ asset('img/club-premium/left-image.jpg') }}" width="350" height="400" /></div>
                    <div class="text">
                        <h2>Qu’est ce que le Club Avantage ?</h2>

                        <p>En devanant utilisateur WineSupervisor II, vous devenez un membre priviligié du CLUB AVANTAGE, vous donnant alors accès à des ventes de vins très privées.</p>
                        <p>L’offre limitée dans le temps, n’est toutefois pas une vente flash et permet de se laisser le temps de la dégustation pour pouvoir revenir et en faire profiter ses amis...</p>
                        <p>Les ventes se font directement auprès des partenaires sélectionnés.</p>
                    </div>
                </section>

                <section>
                    <div class="right-image" style="margin-top:6rem"><img src="{{ asset('img/club-premium/right-image.jpg') }}" width="541" height="361" /></div>
                    <div class="text" style="padding-top: 0rem;">
                        <h2>Le Programme des ventes </h2>
                        <p>
                            L’ objectif du CLUB AVANTAGE WineSupervisor est de vous permettre de découvrir, c’est pourquoi nous allons proposer dans cette espace des vins confidentiels qui demandent à
                            obtenir la reconnaissance pour devenir des références dans l’avenir. Mais nous allons aussi vous présenter des sélections de vins dont vous connaissez la renommée mais vers
                            lesquels vous n’êtes pas encore allés ou qu’il vous interessera de retrouver.
                        </p>

                        <p>
                            Pour 2017 nous démarrons le CLUB AVANTAGE avec un jeune vigneron de l’appellation Gaillac dans le Tarn. C’est un véritable technicien du vin du fait de sa double formation de
                            vigneron et de frigoriste, ce qui lui à permis de développer un système de vinification thermodnamique breveté très performant. Aristide Lacombe du Domaine Grand Chêne à
                            Senouillac va nous régaler...
                        </p>
                    </div>
                </section>

            </div>
            <!-- PAGE CONTENT -->

        </div>

        @include('wine-supervisor::partials.legal-notices')
    </div>

    <!--
    @foreach ($sales as $sale)
        <div class="sale">
            <h2>{{ $sale->title }}</h2>

            <strong>Note :</strong> {{ $sale->jury_note }} / 20 <br/>
            <strong>Avis du jury :</strong> {!! $sale->jury_opinion !!}
            <strong>Commentaires : </strong> {!! $sale->description !!}

            @if ($sale->link)
                <a href="{{ $sale->link }}" target="_blank">COMMANDER</a>
            @endif

            <hr/>
        </div>
    @endforeach
    -->

@stop