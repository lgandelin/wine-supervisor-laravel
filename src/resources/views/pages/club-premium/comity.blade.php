@extends('wine-supervisor::default')

@section('page-content')

    <div class="club-premium-template">
        @include('wine-supervisor::pages.user.includes.header')

                <!-- BANNER -->
        <div class="banner">
            <h1>
                <span class="subtitle">Aux membres du</span>
                <span class="title">Club Avantage</span>
            </h1>
            <span class="border"></span>
        </div>
        <!-- BANNER -->

        <div class="main-content container">

            <!-- LEFT NAVIGATION -->
            <nav class="left-navigation">
                @include('wine-supervisor::pages.club-premium.includes.menu')
            </nav>
            <!-- LEFT NAVIGATION -->

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>Comité de dégustation</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer a hendrerit justo. Curabitur rhoncus faucibus elit. A hendrerit justo curabitur nteger a hendrerit justo. Curabitur rhoncus faucibus elit. </p>
            </div>
            <!-- PAGE HEADER -->

            <!-- PAGE CONTENT -->
            <div class="page-content text-content">
                <section>
                    <div class="left-image"><img src="{{ asset('img/club-premium/left-image.jpg') }}" width="350" height="400" /></div>
                    <div class="text">
                        <h2>Comité de dégustation</h2>

                        <p>Les produits sont sélectionnés par notre comité de dégustation indépendant qui est représentatif des adeptes de la climatisation de cave.</p>
                        <p>Composé de sommeliers, de cavistes, de chefs, de spécialistes et d’amateurs de vins en général, le comité valide une sélection exclusivement destinée à vous faire faire de belles découvertes à prix avantageux.</p>
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