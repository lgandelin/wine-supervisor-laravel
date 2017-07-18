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
                    @if (!$is_user && !$is_technician)
                        <a href="{{ route('user_login') }}" class="btn red-button btn-supervision">Se connecter</a>
                    @elseif ($is_eligible_to_supervision)
                        <a href="{{ route('supervision') }}" target="_blank" class="btn red-button btn-supervision">Se connecter</a>
                    @endif
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

            @foreach ($sales as $i => $sale)
                @include('wine-supervisor::partials.sales-slider', ['sale' => $sale, 'index' => $i, 'display' => ($i != 0) ? 'none' : 'block'])
            @endforeach

            <div class="container">
                <ul class="sales-navigation">
                    @foreach ($sales as $i => $sale)
                        <li data-slider="{{ $i }}" @if ($i == 0)class="active"@endif>
                            <span class="sale-background"><img src="{{ asset('img/sales/' . $sale->id . '/0/' . $sale->image) }}" alt="En cours" /></span>
                            <span class="sale-name">En cours</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <!-- SALES -->

        <!-- NEWS -->
        @if ($contents)
            <div class="news" id="actualites">
                <div class="container">
                    <span class="subtitle">Suivez nos</span>
                    <h2 class="title">Actualités</h2>
                    <!--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <strong>Aenean non lobortis nisi</strong>. Nullam nec convallis magna.</p>-->

                    <div class="news-slider-dots"></div>
                    <ul class="news-slider">
                        @foreach ($contents as $content)
                            <li>
                                @if ($content->image)<img class="image" src="{{ asset($content->image) }}" alt="{{ $content->title }}" width="350" height="273" />@endif
                                <div class="content">
                                    @if ($content->publication_date)<span class="date">{{ strftime('%d %B %Y', DateTime::createFromFormat('Y-m-d', $content->publication_date)->getTimestamp()) }}</span>@endif
                                    @if ($content->title)<h3>{{ $content->title }}</h3>@endif
                                    @if ($content->text)<p>{!! $content->text !!}</p>@endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
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