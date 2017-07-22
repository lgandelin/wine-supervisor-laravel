@extends('wine-supervisor::default')

@section('page-title') Informations sur le Club Avantage | WineSupervisor @endsection

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
                <h1>Informations</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer a hendrerit justo. Curabitur rhoncus faucibus elit. A hendrerit justo curabitur nteger a hendrerit justo. Curabitur rhoncus faucibus elit. </p>
            </div>
            <!-- PAGE HEADER -->

            <!-- PAGE CONTENT -->
            <div class="page-content text-content">
                <section>
                    <div class="left-image"><img src="{{ asset('img/club-premium/left-image.jpg') }}" width="350" height="400" /></div>
                    <div class="text">
                        <?php include base_path() . '/contents/club-avantage/qu-est-ce-que-le-club-avantage.html' ?>
                    </div>
                </section>

                <section>
                    <div class="right-image" style="margin-top:6rem"><img src="{{ asset('img/club-premium/right-image.jpg') }}" width="541" height="361" /></div>
                    <div class="text" style="padding-top: 0rem;">
                        <?php include base_path() . '/contents/club-avantage/programme-des-ventes.html' ?>
                    </div>
                </section>

            </div>
            <!-- PAGE CONTENT -->

        </div>

        @include('wine-supervisor::partials.legal-notices')
    </div>

@stop