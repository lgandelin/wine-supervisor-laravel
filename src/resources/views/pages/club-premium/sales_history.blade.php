@extends('wine-supervisor::default')

@section('page-title') Historique des ventes du Club Avantage | WineSupervisor @endsection

@section('page-content')

    <div class="club-premium-template">
        @include('wine-supervisor::pages.user.includes.header')

        <!-- BANNER -->
        <div class="banner">
            <h1><img class="logo-club-premium" src="{{ asset('img/club-premium/logo-club-avantage.png') }}" width="350" height="205" alt="Aux membres du Club Avantage" /></h1>
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
                @foreach ($sales as $i => $sale)
                    @include('wine-supervisor::partials.sales-slider', ['sale' => $sale, 'index' => ($i+1), 'display' => ($i != 0) ? 'none' : 'block'])
                @endforeach

                <div class="container">
                    @include('wine-supervisor::partials.sales-navigation', ['sales' => $sales])
                </div>
            </div>
            <!-- SALES -->

        </div>

        @include('wine-supervisor::partials.legal-notices')
    </div>

@stop