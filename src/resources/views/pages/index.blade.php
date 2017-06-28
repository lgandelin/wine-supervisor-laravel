@extends('wine-supervisor::default')

@section('page-content')
    <div class="home-template">

        <!-- HEADER -->
        <header>

            <!-- TOP BAR -->
            <div class="top-bar">
                <div class="container">
                    <div class="nav">
                        <nav>
                            <ul>
                                <li><a href="{{ route('user_signup') }}">Créer un compte</a></li>
                                <li class="logout"><span class="account-icon"></span></li>
                            </ul>
                        </nav>

                        <form class="login" action="mes-caves.html">
                            <div class="input-login">
                                <input type="text" />
                            </div>

                            <div class="input-password">
                                <input type="password" />
                            </div>

                            <input type="submit" value="Se connecter" />
                            <a class="forgotten-password" href="#">Mot de passe oublié ?</a>
                        </form>
                    </div>
                </div>
            </div>
            <!-- TOP BAR -->

            <!-- LOGO AND NAVIGATION -->
            <div class="logo-navigation">
                <div class="container">
                    <nav>
                        <ul>
                            <li><a href="#wine-supervisor">WineSupervisor</a></li>
                            <li><a href="#club-avantage">Le Club</a></li>
                            <li><a href="#actualites">Actualités</a></li>
                            <li><a href="#nos-partenaires">Nos partenaires</a></li>
                            <li><a href="#top">Contact</a></li>
                        </ul>
                    </nav>

                    <h1 class="logo">
                        <a href="#">
                            <img src="img/header/logo-wine-supervisor.png" width="308" height="67" alt="WineSupervisor" />
                        </a>
                    </h1>
                </div>
            </div>
            <!-- LOGO AND NAVIGATION -->

        </header>
        <!-- HEADER -->

        <!-- BANNER -->
        <div class="banner" id="top">
            <h2>
                <span class="your-cellar subtitle">Votre cave</span>
                <span class="title">Accessible partout</span>
            </h2>
            <span class="border"></span>
        </div>
        <!-- BANNER -->

        <!-- BOX -->
        <div class="box" id="wine-supervisor">
            <div class="container">
                <img class="box-image" src="img/home/box/box.png" width="390" height="453" alt="Boitier WineSupervisor" />
                <span class="subtitle">Boitier</span>
                <h2 class="title">WineSupervisor</h2>
                <p>Lorem ipsum dolor sit amet, <a href="#">consectetur adipiscing elit</a>. Aenean non lobortis nisi. Nullam nec convallis magna. Nulla iaculis leo vitae erat pellentesque pulvinar. Nam porta diam in lorem fermentum ullamcorper. Proin aliquet dui at interdum dictum. Donec vehicula, diam sed pellentesque faucibus.</p>
            </div>
        </div>
        <!-- BOX -->


        <!-- CLUB -->
        <div class="club" id="club-avantage">
            <div class="container">
                <span class="subtitle">Des vins d'exception grâce au</span>
                <h2 class="title">Club Avantages</h2>
                <span class="border"></span>
            </div>
        </div>
        <!-- CLUB -->

        <!-- SALES SLIDER -->
        <div class="sales">
            <div class="container">
                <div class="slider-container">
                    <div class="sales-slider-arrows"></div>
                    <ul class="sales-slider" data-slider="1">
                        <li>
                            <img class="bottle" src="img/home/sales/bottle.png" alt="Belle Emilie" />
                            <div class="content">
                                <span class="sale-subtitle">Cuvée des Chartreux</span>
                                <h3 class="sale-name">Belle Emilie</h3>
                                <p>
                                    <strong>- Note du jury</strong><br/>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer a hendrerit justo. Curabitur rhoncus faucibus amet curibatur elit.
                                </p>

                                <p>
                                    <strong>- En gastronomie</strong><br/>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer a hendrerit justo. Curabitur rhoncus faucibus amet curibatur elit.
                                </p>

                                <p>
                                    <strong>- Caractéristiques</strong><br/>
                                    Garde : 2 à 3 ans - T° : 14°C<br/>
                                    Assemblage : Pinot, Carminoir
                                </p>

                                <a href="#" class="button">Commander</a>
                            </div>
                        </li>

                        <li>
                            <img class="bottle" src="img/home/sales/bottle.png" alt="Belle Emilie" />
                            <div class="content">
                                <span class="sale-subtitle">Cuvée des Chartreux</span>
                                <h3 class="sale-name">Belle Emilie</h3>
                                <p>
                                    <strong>- Note du jury</strong><br/>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer a hendrerit justo. Curabitur rhoncus faucibus amet curibatur elit.
                                </p>

                                <p>
                                    <strong>- En gastronomie</strong><br/>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer a hendrerit justo. Curabitur rhoncus faucibus amet curibatur elit.
                                </p>

                                <p>
                                    <strong>- Caractéristiques</strong><br/>
                                    Garde : 2 à 3 ans - T° : 14°C<br/>
                                    Assemblage : Pinot, Carminoir
                                </p>

                                <a href="#" class="button">Commander</a>
                            </div>
                        </li>

                        <li>
                            <img class="bottle" src="img/home/sales/bottle.png" alt="Belle Emilie" />
                            <div class="content">
                                <span class="sale-subtitle">Cuvée des Chartreux</span>
                                <h3 class="sale-name">Belle Emilie</h3>
                                <p>
                                    <strong>- Note du jury</strong><br/>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer a hendrerit justo. Curabitur rhoncus faucibus amet curibatur elit.
                                </p>

                                <p>
                                    <strong>- En gastronomie</strong><br/>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer a hendrerit justo. Curabitur rhoncus faucibus amet curibatur elit.
                                </p>

                                <p>
                                    <strong>- Caractéristiques</strong><br/>
                                    Garde : 2 à 3 ans - T° : 14°C<br/>
                                    Assemblage : Pinot, Carminoir
                                </p>

                                <a href="#" class="button">Commander</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="container">
                <ul class="sales-navigation">
                    <li data-slider="1" class="active">
                        <span class="sale-background"><img src="img/home/sales/1.jpg" alt="Sale 1" /></span>
                        <span class="sale-name">En cours</span>
                    </li>

                    <li data-slider="2">
                        <span class="sale-background"><img src="img/home/sales/2.jpg" alt="Sale 2" /></span>
                        <span class="sale-name">06 Juin - 21 Juin</span>
                    </li>

                    <li data-slider="3">
                        <span class="sale-background"><img src="img/home/sales/3.jpg" alt="Sale 3" /></span>
                        <span class="sale-name">12 Juillet - 26 Juillet</span>
                    </li>
                </ul>
            </div>
        </div>
        <!-- SALES SLIDER -->


        <!-- NEWS -->
        <div class="news" id="actualites">
            <div class="container">
                <span class="subtitle">Suivez nos</span>
                <h2 class="title">Actualités</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <strong>Aenean non lobortis nisi</strong>. Nullam nec convallis magna.</p>

                <div class="news-slider-dots"></div>
                <ul class="news-slider">
                    <li>
                        <img class="image" src="img/home/news/1.jpg" alt="Actualité 1" width="350" height="273" />
                        <div class="content">
                            <span class="date">16 Aout 2016</span>
                            <h3>Lorem ipsum</h3>
                            <p>Lorem <a href="#">ipsum dolor sit amet</a>, consectetur adipiscing elit. Aenean non lobortis nisi. Nulla iaculis leo vitae erat pellentesque pulvinar. Nam porta diam in lorem fermentum ullamcorper. Proin <a href="#">aliquet dui at interdum dictum</a>. Donec vehicula, diam sed pellentesque faucibus.</p>
                        </div>
                    </li>

                    <li>
                        <img class="image" src="img/home/news/1.jpg" alt="Actualité 2" width="350" height="273" />
                        <div class="content">
                            <span class="date">16 Aout 2016</span>
                            <h3>Lorem ipsum</h3>
                            <p>Lorem <a href="#">ipsum dolor sit amet</a>, consectetur adipiscing elit. Aenean non lobortis nisi. Nulla iaculis leo vitae erat pellentesque pulvinar. Nam porta diam in lorem fermentum ullamcorper. Proin <a href="#">aliquet dui at interdum dictum</a>. Donec vehicula, diam sed pellentesque faucibus.</p>
                        </div>
                    </li>

                    <li>
                        <img class="image" src="img/home/news/1.jpg" alt="Actualité 3" width="350" height="273" />
                        <div class="content">
                            <span class="date">16 Aout 2016</span>
                            <h3>Lorem ipsum</h3>
                            <p>Lorem <a href="#">ipsum dolor sit amet</a>, consectetur adipiscing elit. Aenean non lobortis nisi. Nulla iaculis leo vitae erat pellentesque pulvinar. Nam porta diam in lorem fermentum ullamcorper. Proin <a href="#">aliquet dui at interdum dictum</a>. Donec vehicula, diam sed pellentesque faucibus.</p>
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
                    <img class="partner" src="img/home/partners/1.png" alt="Partenaire 1" width="243" height="162" />
                    <img class="partner" src="img/home/partners/2.png" alt="Partenaire 2" width="190" height="190" />
                    <img class="partner" src="img/home/partners/1.png" alt="Partenaire 1" width="243" height="162" />
                    <img class="partner" src="img/home/partners/2.png" alt="Partenaire 2" width="190" height="190" />
                    <img class="partner" src="img/home/partners/1.png" alt="Partenaire 1" width="243" height="162" />
                    <img class="partner" src="img/home/partners/2.png" alt="Partenaire 2" width="190" height="190" />
                    <img class="partner" src="img/home/partners/1.png" alt="Partenaire 1" width="243" height="162" />
                    <img class="partner" src="img/home/partners/2.png" alt="Partenaire 2" width="190" height="190" />
                    <img class="partner" src="img/home/partners/1.png" alt="Partenaire 1" width="243" height="162" />
                    <img class="partner" src="img/home/partners/2.png" alt="Partenaire 2" width="190" height="190" />
                    <img class="partner" src="img/home/partners/1.png" alt="Partenaire 1" width="243" height="162" />
                    <img class="partner" src="img/home/partners/2.png" alt="Partenaire 2" width="190" height="190" />
                    </li>
                </ul>
            </div>
        </div>
        <!-- OUR PARTNERS -->


        <!-- FOOTER -->
        <footer>
            <div class="container">
                <a href="#">Mentions légales</a>
            </div>
        </footer>
        <!-- FOOTER -->

        <div style="display:none">
            @if (!$is_user && !$is_guest)
                <a href="{{ route('user_signup') }}">Créer un compte utilisateur</a> |
                <a href="{{ route('technician_signup') }}">Créer un compte professionnel</a> |
                <a href="{{ route('user_login') }}">Se connecter</a>
            @endif

            @if ($is_eligible_to_club_premium)
                <a href="{{ route('club_premium') }}">Club Premium</a>
            @endif

            @if ($is_eligible_to_supervision)
                <a href="{{ url('supervision') }}">Supervision</a>
            @endif

            @if ($is_user)
                <a href="{{ route('user_cellar_list') }}">Mes caves</a>
                <a href="{{ route('user_update_account') }}">Gérer mon compte</a>
            @endif
        </div>
    </div>
@stop