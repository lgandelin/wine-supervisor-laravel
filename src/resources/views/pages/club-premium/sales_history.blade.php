@extends('wine-supervisor::default')

@section('page-title') Historique des ventes du Club Avantage | WineSupervisor @endsection

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
                <h1>Historique des ventes</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer a hendrerit justo. Curabitur rhoncus faucibus elit. A hendrerit justo curabitur nteger a hendrerit justo. Curabitur rhoncus faucibus elit. </p>
            </div>
            <!-- PAGE HEADER -->

            <!-- SALES -->
            <div class="sales">
                @include('wine-supervisor::partials.sales-slider')

                <div class="container">
                    <ul class="sales-navigation">
                        <li data-slider="1" class="active">
                            <span class="sale-background"><img src="{{ asset('img/sales/1/background.jpg') }}" alt="En cours" /></span>
                            <span class="sale-name">12 Mai - 22 Mai</span>
                        </li>

                        <!--<li data-slider="2">
                            <span class="sale-background"><img src="img/home/sales/2.jpg" alt="Sale 2" /></span>
                            <span class="sale-name">06 Juin - 21 Juin</span>
                        </li>

                        <li data-slider="3">
                            <span class="sale-background"><img src="img/home/sales/3.jpg" alt="Sale 3" /></span>
                            <span class="sale-name">12 Juillet - 26 Juillet</span>
                        </li>-->
                    </ul>
                </div>
            </div>
            <!-- SALES -->

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
    @endforeach-->

@stop