@extends('wine-supervisor::default')

@section('page-content')
    <div class="home-template">

        @include('wine-supervisor::pages.user.includes.header')

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
                <p>
                    CAVE 100% CONNECTÉE<br/>
                    Votre cave accessible tout le temps et partout !<br/><br/>

                    Surveillez température et humidité, configurez et recevez des alertes en temps réel.
                    Optimisez la consommation énergétique de votre cave grâce à WineSupervisor II.<br/>
                </p>
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

        <div class="club-contents">
            <div class="container">
                <div class="image">
                    <img src="img/home/partners/1.jpg" alt="Wine Supervisor - Club Avantage" width="300" height="205" />
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
            </div>
        </div>

        <!-- SALES SLIDER -->
        <div class="sales">
            <div class="container">
                <div class="slider-container">
                    <div class="sales-slider-arrows"></div>
                    <ul class="sales-slider" data-slider="1">
                        <li>
                            <div class="background" style="background-image:url({{ asset('img/sales/1/background.jpg') }})"></div>
                            <img class="bottle" src="{{ asset('img/sales/1/bottle.png') }}" alt="Insolence" />
                            <div class="content">
                                <span class="sale-subtitle">Merlot - Duras - Braucol</span>
                                <h3 class="sale-name">Insolence</h3>
                                <p>
                                    <strong>Dégustation</strong><br/>
                                    Insolence est un vin ample et velouté, aux arômes de fruits mûrs et d’épices.
                                </p>

                                <p>
                                    <strong>Vinification</strong><br/>
                                    Insolence bénéficie d’une macération pelliculaire à chaud du raisin en cuves inox
                                    une journée puis d’une fermentation alcoolique thermo-régulée à froid, procédé
                                    éco-énergétique breveté par le domaine du Grand Chêne (unique au monde).
                                    La typicité et la tradition sont respectées dans cette vinification moderne,
                                    favorisant le fruit et la structure de notre produit.
                                </p>

                                <p>
                                    <strong>Accords parfaits</strong><br/>
                                    Insolence accompagnera une belle pièce<br/>
                                    de viande, un filet mignon, une volaille rôtie ou<br/>
                                    un caviar d’aubergines.
                                </p>

                                <a href="#" class="button">Commander</a>
                            </div>
                        </li>


                        <li>
                            <div class="background" style="background-image: url({{ asset('img/sales/2/background.jpg') }})"></div>
                            <img class="bottle" src="{{ asset('img/sales/2/bottle.png') }}" alt="Mauzac" />
                            <div class="content">
                                <!--<span class="sale-subtitle">Merlot - Duras - Braucol</span>-->
                                <h3 class="sale-name">Mauzac</h3>
                                <p>
                                    <strong>Dégustation</strong><br/>
                                    Dans cette bouteille, l’effervescence de notre savoir-faire. Depuis plus de 1000 ans, le Mauzac, cépage historique gaillacois est naturellement prédisposé à l’élaboration de cette méthode ancestrale.<br/><br/>

                                    Notes pomme/poire et finesse des bulles mettront vos papilles en éveil pour tous vos moments de fête!
                                </p>

                                <p>
                                    <strong>Accords parfaits</strong><br/>
                                    En apéritif ou au dessert, pour un moment festif <br/>et convivial.<br/><br/>

                                    Service : 6-8°C
                                </p>

                                <a href="#" class="button">Commander</a>
                            </div>
                        </li>


                        <li>
                            <div class="background" style="background-image: url({{ asset('img/sales/3/background.jpg') }})"></div>
                            <img class="bottle" src="{{ asset('img/sales/3/bottle.png') }}" alt="Douce envolée" />
                            <div class="content">
                                <span class="sale-subtitle">Mauzac - Len de l'el</span>
                                <h3 class="sale-name">Mauzac</h3>
                                <p>
                                    <strong>Dégustation</strong><br/>
                                    Douce Envolée s’exprime sur des notes de pomme, d’abricot, et en finale sur des agrumes
                                    avec une pointe d’acidité.<br/>
                                    Sélectionné par le Guide belge « Vins et Terroirs Authentiques »<br/>
                                    Note dégustation: 15,5/20<br/>
                                    <a href="http://www.vinsetterroirs.be/revue_num_detail?fileId=23">http://www.vinsetterroirs.be/revue_num_detail?fileId=23</a>
                                </p>

                                <p>
                                    <strong>Vinification</strong><br/>
                                    Douce Envolée résulte d’un effeuillage partiel du cep de vigne, d’un passerillage
                                    par le soleil et le vent d’autan exceptionnel grâce à l’exposition de la parcelle.
                                    La pourriture noble est aussi au rendez-vous sur une partie des raisins.
                                    Un débourbage gravitaire et une fermentation thermorégulée en cuves béton jalonnent
                                    l’élaboration de cette cuvée, l’arrêt de la fermentation est exécuté par filtration.
                                </p>

                                <p>
                                    <strong>Accords parfaits</strong><br/>
                                    Douce Envolée se savoure selon vos envies en apéritif,
                                    avec un fromage à pâte persillée, un foie gras ou un dessert chocolaté.<br/>
                                    Cette Douce Envolée est de celles que l’on déguste<br/>
                                    aussi pour elles-mêmes, elle peut s’accompagner<br/>
                                    seulement de quelques bons amis.
                                </p>

                                <a href="#" class="button">Commander</a>
                            </div>
                        </li>


                        <li>
                            <div class="background" style="background-image: url({{ asset('img/sales/4/background.jpg') }})"></div>
                            <img class="bottle" src="{{ asset('img/sales/4/bottle.png') }}" alt="Parcelle de l'Ortolan" />
                            <div class="content">
                                <span class="sale-subtitle">Sauvignon - Len de l'el</span>
                                <h3 class="sale-name">Parcelle de l'Ortolan</h3>
                                <p>
                                    <strong>Dégustation</strong><br/>
                                    La Parcelle de l’Ortolan 2015 possède une très belle maturité, son nez caractéristique
                                    du Sauvignon avec des notes agrumes et de fruits blancs (pêche, poire) vous surprendra.
                                    Le cépage indigène Len de lel apporte en bouche de la finesse, un côté minéral
                                    et des notes de fruits exotiques.<br/><br/>

                                    Médaille d’argent au Concours International de Lyon 2016<br/><br/>

                                    Sélectionné dans le Guide Dis Vins Edition
                                </p>

                                <p>
                                    <strong>Vinification</strong><br/>
                                    La Parcelle de l’Ortolan bénéficie d’une macération pelliculaire,
                                    d’un débourbage gravitaire et d’une fermentation alcoolique thermo-régulée,
                                    procédé éco-énergétique breveté par le domaine (unique au monde).
                                </p>

                                <p>
                                    <strong>Accords parfaits</strong><br/>
                                    La Parcelle de l’Ortolan accompagnera<br/>
                                    parfaitement fruits de mer,
                                    poissons et fromages.
                                </p>

                                <a href="#" class="button">Commander</a>
                            </div>
                        </li>


                        <li>
                            <div class="background" style="background-image: url({{ asset('img/sales/5/background.jpg') }})"></div>
                            <img class="bottle" src="{{ asset('img/sales/5/bottle.png') }}" alt="Péché de vigne" />
                            <div class="content">
                                <span class="sale-subtitle">Syrah</span>
                                <h3 class="sale-name">Pêche de vigne</h3>
                                <p>
                                    <strong>Dégustation</strong><br/>
                                    Péché de Vigne est un rosé friand, aux notes de fraise, de framboise et de cassis,
                                    il libère un belle acidité en fin de bouche.<br/><br/>

                                    Médaille d’or au Concours International de Lyon 2016<br/>
                                </p>

                                <p>
                                    <strong>Vinification</strong><br/>
                                    Péché de Vigne découle d’une macération du raisin et du jus de 24h, d’un pressurage à froid
                                    puis d’un débourbage gravitaire et fermentation thermorégulée en cuves béton.
                                    L’élevage en cuves sur lies s’est effectué durant 2 mois avec des bâtonnages réguliers.
                                </p>

                                <p>
                                    <strong>Accords parfaits</strong><br/>
                                    Péché de Vigne se savoure avec des viandes<br/>
                                    blanches, des grillades et des salades <br/>
                                    gourmandes d’été.
                                </p>

                                <a href="#" class="button">Commander</a>
                            </div>
                        </li>


                        <li>
                            <div class="background" style="background-image: url({{ asset('img/sales/6/background.jpg') }})"></div>
                            <img class="bottle" src="{{ asset('img/sales/6/bottle.png') }}" alt="Arigliole Julian" />
                            <div class="content">
                                <span class="sale-subtitle">Braucol - Syrah - Duras</span>
                                <h3 class="sale-name">Arigliole Julian</h3>
                                <p>
                                    <strong>Dégustation</strong><br/>
                                    Jeune, il est apprécié pour ses arômes de mûre, groseille, fraise et poivron jaune. Sa structure et ses tanins nobles lui permettront de s’arrondir au bout de quelques années.
                                </p>

                                <p>
                                    <strong>Vinification</strong><br/>
                                    Cette cuvée est issue d’une sélection parcellaire rigoureuse, de faibles rendements, (30hL/ha). Macération pelliculaire du raisin à froid, fermentation alcoolique thermo-régulée par un process
                                    éco-énergétique breveté par le domaine (unique au monde). Elevage partiel en vieux fûts de chêne.
                                </p>

                                <p>
                                    <strong>Accords parfaits</strong><br/>
                                    Ce vin accompagnera parfaitement bœuf ou magret<br/>
                                    de canard grillé ou en sauce, escalope de veau<br/>
                                    panée ou foie gras poêlé… à vos papilles !
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
                            <span class="date">4 Juillet 2017</span>
                            <h3>Premier comité de dégustation</h3>
                            <p>Le premier comité de dégustation du Club Avantage WineSupervisor s’est réuni le 4 Juillet.
                                Sylvie Coudurier, sommelier conseil a animé la soirée qui a vu mettre en avant les vins
                                du domaine Grand Chêne de Aristide Lacombe.</p>
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
                    <img class="partner" src="img/home/partners/1.jpg" alt="Wine Supervisor - Club Avantage" width="220" height="150" />
                    <img class="partner" src="img/home/partners/2.jpg" alt="Friax Industrie" width="220" height="150" />
                    <img class="partner" src="img/home/partners/1.jpg" alt="Wine Supervisor - Club Avantage" width="220" height="150" />
                    <img class="partner" src="img/home/partners/2.jpg" alt="Friax Industrie" width="220" height="150" />
                    <img class="partner" src="img/home/partners/1.jpg" alt="Wine Supervisor - Club Avantage" width="220" height="150" />
                    <img class="partner" src="img/home/partners/2.jpg" alt="Friax Industrie" width="220" height="150" />
                    <img class="partner" src="img/home/partners/1.jpg" alt="Wine Supervisor - Club Avantage" width="220" height="150" />
                    <img class="partner" src="img/home/partners/2.jpg" alt="Friax Industrie" width="220" height="150" />
                </ul>
            </div>
        </div>
        <!-- OUR PARTNERS -->

        @include('wine-supervisor::partials.legal-notices')

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