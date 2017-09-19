@extends('wine-supervisor::default')

@section('page-title'){{ trans('wine-supervisor::club_premium.comity.meta_title') }}@endsection

@section('page-content')

    <div class="club-premium-template">
        @include('wine-supervisor::pages.user.includes.header')

        <!-- BANNER -->
        <div class="banner">
            <h1><img class="logo-club-premium" src="{{ asset('img/club-premium/logo-club-avantage.png') }}" width="350" alt="Aux membres du Club Avantage" /></h1>
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
                <h1>{{ trans('wine-supervisor::club_premium.comity.page_title') }}</h1>
                <p>{{ trans('wine-supervisor::club_premium.comity.page_header') }}</p>
            </div>
            <!-- PAGE HEADER -->

            <!-- PAGE CONTENT -->
            <div class="page-content text-content">
                <section>
                    <div class="left-image"><img src="{{ asset('img/club-premium/comite.jpg') }}" width="541" height="379" /></div>
                    <div class="text" style="padding-top: 6rem">
                        <?php include base_path() . '/contents/' . App::getLocale() . '/club-avantage/comite-de-degustation.html' ?>
                    </div>
                </section>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
            </div>
            <!-- PAGE CONTENT -->

        </div>

        @include('wine-supervisor::partials.legal-notices')
    </div>

@stop