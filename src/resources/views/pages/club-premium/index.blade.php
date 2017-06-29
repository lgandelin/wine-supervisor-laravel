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
                <ul>
                    <!-- @include('wine-supervisor::pages.club-premium.includes.menu')-->
                    <li class="info active"><a href="club-avantage.html"><span>Informations</span></a></li>
                    <li class="comity"><a href="#"><span>Comité</span></a></li>
                    <li class="current-sales"><a href="club-avantage-ventes-en-cours.html"><span>Ventes en cours</span></a></li>
                    <li class="history"><a href="#"><span>Historique des ventes</span></a></li>
                </ul>
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
                    <h2>Qu’est ce que le Club Avantage</h2>

                    <p>Lorem ipsum <a href="#">dolor sit amet</a>, consectetur adipiscing elit. Integer a hendrerit justo. Curabitur rhoncusnteger ultricies, neque eget elementum dapibus, velit nunc vulputate nulla, sit amet suscipit lorem tellus eget justo. Donec <a href="#">volutpat ligula eget felis eleifend fermentum</a>.</p>

                    <p>Sit amet, consectetur adipiscing elit. Integer a <a href="#">hendrerit justo</a>. Curabitur rhoncusnteger ultricies, <a href="#">neque eget elementum dapibus</a>, ipsum dolor velit nunc vulputate nulla, sit amet suscipit lorem tellus eget justo.</p>

                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer a hendrerit justo. Curabitur <a href="#">rhoncusnteger ultricies</a>, neque eget elementum dapibus, velit nunc vulputate nulla, <a href="#">sit amet suscipit lorem tellus</a> eget justo. Donec volutpat ligula eget felis eleifend fermentum.</p>
                </section>

                <section>
                    <h2>Le Programme des ventes </h2>

                    <p>Lorem ipsum <a href="#">dolor sit amet</a>, consectetur adipiscing elit. Integer a hendrerit justo. Curabitur rhoncusnteger ultricies, neque eget elementum dapibus, velit nunc vulputate nulla, sit amet suscipit lorem tellus eget justo. Donec <a href="#">volutpat ligula eget felis eleifend fermentum</a>.</p>

                    <p>Sit amet, consectetur adipiscing elit. Integer a <a href="#">hendrerit justo</a>. Curabitur rhoncusnteger ultricies, <a href="#">neque eget elementum dapibus</a>, ipsum dolor velit nunc vulputate nulla, sit amet suscipit lorem tellus eget justo.</p>

                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer a hendrerit justo. Curabitur <a href="#">rhoncusnteger ultricies</a>, neque eget elementum dapibus, velit nunc vulputate nulla, <a href="#">sit amet suscipit lorem tellus</a> eget justo. Donec volutpat ligula eget felis eleifend fermentum.</p>
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