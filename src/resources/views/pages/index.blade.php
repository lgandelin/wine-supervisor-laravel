@extends('wine-supervisor::default')

@section('page-title') Votre cave, accessible partout | WineSupervisor @endsection

@section('page-content')
    <div class="home-template">

        @include('wine-supervisor::pages.user.includes.header')

        <!-- BANNER -->
        <div class="banner" id="top">
            <h2>
                <span class="your-cellar subtitle">Votre cave</span>
                <span class="title">Accessible partout</span>
            </h2>
        </div>
        <!-- BANNER -->

        <!-- BOX -->
        <div class="box" id="wine-supervisor">
            <div class="container">
                <img class="box-image" src="{{ asset('img/home/box/box.png') }}" width="390" height="453" alt="Boitier WineSupervisor" />
                <!--<span class="subtitle">Boitier</span>
                <h2 class="title">WineSupervisor</h2>-->
                <h2 class="title"><img class="logo-wine-supervisor-ii" src="{{ asset('img/home/box/logo-winesupervisor-ii.png') }}" width="450" height="100" alt="WineSupervisor" /></h2>
                <p>
                    CAVE 100% CONNECTÉE<br/>
                    Votre cave accessible tout le temps et partout !<br/><br/>

                    Surveillez température et humidité, configurez et recevez des alertes en temps réel.
                    Optimisez la consommation énergétique de votre cave grâce à WineSupervisor II.<br/>
                </p>

                <div class="buttons">
                    <a href="http://friax.fr/winesupervisor" target="_blank" class="btn red-button btn-discover">Découvrir</a>
                    <a @if ($is_eligible_to_supervision)href="{{ route('supervision') }}" target="_blank" @else href="{{ route('user_login') }}"@endif class="btn red-button btn-supervision">Se connecter</a>
                </div>
            </div>
        </div>
        <!-- BOX -->

        <!-- CLUB -->
        <div class="club" id="club-avantage">
            <div class="container">
                <span class="subtitle">Des vins d'exception grâce au</span>
                <h2 class="title">Club Avantage</h2>
            </div>
        </div>
        <!-- CLUB -->

        <div class="club-contents">
            <div class="container">
                <div class="image">
                    <img src="{{ asset('img/club-premium/logo-club-avantage.png') }}" alt="Wine Supervisor - Club Avantage" width="300" height="205" />
                </div>
                <div class="text">
                    <p>
                        WineSupervisor CLUB AVANTAGE donne accès à des ventes très privées à durée
                        limitée aux utilisateurs de WineSupervisor II.
                    </p>
                    <p>
                        Des produits exclusifs à prix avantageux sont négociés par le club et validés par un
                        comité de sélection indépendant représentatif de la clientèle des produits de
                        climatisation de cave : Oenologues, cavistes, chefs, spécialistes...
                    </p>
                </div>

                <a href="{{ route('club_premium') }}" class="btn red-button">Découvrez le Club Avantage</a>
            </div>
        </div>

        <!-- SALES -->
        <div class="sales">
            @include('wine-supervisor::partials.sales-slider')

            <div class="container">
                <ul class="sales-navigation">
                    <li data-slider="1" class="active">
                        <span class="sale-background"><img src="{{ asset('img/sales/1/0/background.jpg') }}" alt="En cours" /></span>
                        <span class="sale-name">En cours</span>
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

        <!-- NEWS -->
        <div class="news" id="actualites">
            <div class="container">
                <span class="subtitle">Suivez nos</span>
                <h2 class="title">Actualités</h2>
                <!--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <strong>Aenean non lobortis nisi</strong>. Nullam nec convallis magna.</p>-->

                <div class="news-slider-dots"></div>
                <ul class="news-slider">
                    <li>
                        <img class="image" src="img/home/news/1.jpg" alt="Actualité 1" width="350" height="273" />
                        <div class="content">
                            <span class="date">4 Juillet 2017</span>
                            <h3>Premier comité de dégustation</h3>
                            <p>Le premier comité de dégustation du Club Avantage WineSupervisor s’est réuni le 4 Juillet.
                                Sylvie Coudurier, sommelier conseil a animé la soirée qui a vu mettre en avant les vins
                                du domaine Grand Chêne de Aristide Lacombe.</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- NEWS -->


        <!-- OUR PARTNERS -->
        <div class="our-partners" id="nos-partenaires">
            <div class="container">
                <span class="subtitle">Nos</span>
                <h2 class="title">Partenaires</h2>

                <div class="partners-slider-arrows"></div>
                <ul class="partners-slider">
                    <li><a href="{{ route('club_premium') }}"><img class="partner" src="img/home/partners/1.png" alt="Wine Supervisor - Club Avantage" width="220" height="150" /></a></li>
                    <li><a href="http://friax.fr" target="_blank"><img class="partner" src="img/home/partners/2.jpg" alt="Friax Industrie" width="220" height="150" /></a></li>
                    <li><a href="{{ route('club_premium') }}"><img class="partner" src="img/home/partners/1.png" alt="Wine Supervisor - Club Avantage" width="220" height="150" /></a></li>
                    <li><a href="http://friax.fr" target="_blank"><img class="partner" src="img/home/partners/2.jpg" alt="Friax Industrie" width="220" height="150" /></a></li>
                    <li><a href="{{ route('club_premium') }}"><img class="partner" src="img/home/partners/1.png" alt="Wine Supervisor - Club Avantage" width="220" height="150" /></a></li>
                    <li><a href="http://friax.fr" target="_blank"><img class="partner" src="img/home/partners/2.jpg" alt="Friax Industrie" width="220" height="150" /></a></li>
                    <li><a href="{{ route('club_premium') }}"><img class="partner" src="img/home/partners/1.png" alt="Wine Supervisor - Club Avantage" width="220" height="150" /></a></li>
                    <li><a href="http://friax.fr" target="_blank"><img class="partner" src="img/home/partners/2.jpg" alt="Friax Industrie" width="220" height="150" /></a></li>
                </ul>
            </div>
        </div>
        <!-- OUR PARTNERS -->

        @include('wine-supervisor::partials.legal-notices')
    </div>
@stop