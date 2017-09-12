@extends('wine-supervisor::default')

@section('page-title'){{ trans('wine-supervisor::club_premium.sales_history.meta_title') }}@endsection

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
                <h1>{{ trans('wine-supervisor::club_premium.sales_history.page_title') }}</h1>
                <p>{{ trans('wine-supervisor::club_premium.sales_history.page_header') }}</p>
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