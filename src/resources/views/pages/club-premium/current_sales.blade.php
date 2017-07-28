@extends('wine-supervisor::default')

@section('page-title') Ventes en cours du Club Avantage | WineSupervisor @endsection

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
                <h1>Ventes en cours</h1>
                <p>Tous les trimestres retrouvez la nouvelle sélection du Club Avantage WineSupervisor validée par le comité de dégustation.</p>
            </div>
            <!-- PAGE HEADER -->

            <!-- SALES -->
            <div class="sales">
                @foreach ($sales as $i => $sale)
                    @include('wine-supervisor::partials.sales-slider', ['sale' => $sale, 'index' => ($i+1), 'display' => ($i != 0) ? 'none' : 'block'])
                @endforeach
            </div>
            <!-- SALES -->

        </div>

        @include('wine-supervisor::partials.legal-notices')
    </div>
@stop