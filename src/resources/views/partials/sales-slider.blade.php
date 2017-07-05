<div class="container">
    <div class="slider-container">
        <div class="sales-slider-arrows"></div>
        <ul class="sales-slider" data-slider="1">

            <li>
                <div class="background" style="background-image: url({{ asset('img/sales/1/0/background.jpg') }})"></div>
            </li>

            <li>
                <div class="background" style="background-image:url({{ asset('img/sales/1/1/background.jpg') }})"></div>
                <img class="bottle" src="{{ asset('img/sales/1/1/bottle.png') }}" alt="Insolence" />
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
                </div>

                @if ($is_user)<span class="sale-price">Prix : <span class="value">12€</span></span>@endif
                <a href="@if (!$is_user){{ route('user_login_handler') }}@else{{ '#' }}@endif" class="button">Commander</a>
            </li>


            <li>
                <div class="background" style="background-image: url({{ asset('img/sales/1/2/background.jpg') }})"></div>
                <img class="bottle" src="{{ asset('img/sales/1/2/bottle.png') }}" alt="Mauzac" />
                <div class="content">
                    <span class="sale-subtitle">Mauzac</span>
                    <h3 class="sale-name">Brut</h3>
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
                </div>

                @if ($is_user)<span class="sale-price">Prix : <span class="value">10€</span></span>@endif
                <a href="@if (!$is_user){{ route('user_login_handler') }}@else{{ '#' }}@endif" class="button">Commander</a>
            </li>


            <li>
                <div class="background" style="background-image: url({{ asset('img/sales/1/3/background.jpg') }})"></div>
                <img class="bottle" src="{{ asset('img/sales/1/3/bottle.png') }}" alt="Douce envolée" />
                <div class="content">
                    <span class="sale-subtitle">Mauzac - Len de lel</span>
                    <h3 class="sale-name">Mauzac</h3>
                    <p>
                        <strong>Dégustation</strong><br/>
                        Douce Envolée s’exprime sur des notes de pomme, d’abricot, et en finale sur des agrumes
                        avec une pointe d’acidité. Sélectionné par le Guide belge « Vins et Terroirs Authentiques »
                    </p>

                    <p>
                        <strong>Vinification</strong><br/>
                        Douce Envolée résulte d’un effeuillage partiel du cep de vigne, d’un passerillage par le soleil et le vent d’autan exceptionnel. Un débourbage gravitaire et une fermentation thermorégulée en cuves béton jalonnent l’élaboration de cette cuvée, l’arrêt de la fermentation est exécuté par filtration.
                    </p>

                    <p>
                        <strong>Accords parfaits</strong><br/>
                        Douce Envolée se savoure selon vos envies en apéritif,
                        avec un fromage à pâte<br/> persillée, un foie gras ou un dessert chocolaté.
                    </p>
                </div>

                @if ($is_user)<span class="sale-price">Prix : <span class="value">18€</span></span>@endif
                <a href="@if (!$is_user){{ route('user_login_handler') }}@else{{ '#' }}@endif" class="button">Commander</a>
            </li>


            <li>
                <div class="background" style="background-image: url({{ asset('img/sales/1/4/background.jpg') }})"></div>
                <img class="bottle" src="{{ asset('img/sales/1/4/bottle.png') }}" alt="Parcelle de l'Ortolan" />
                <div class="content">
                    <span class="sale-subtitle">Sauvignon - Len de l'el</span>
                    <h3 class="sale-name">Parcelle de l'Ortolan</h3>
                    <p>
                        <strong>Dégustation</strong><br/>
                        La Parcelle de l’Ortolan 2015 possède une très belle maturité, son nez caractéristique
                        du Sauvignon avec des notes agrumes et de fruits blancs (pêche, poire) vous surprendra.
                        Le cépage indigène Len de lel apporte en bouche de la finesse, un côté minéral
                        et des notes de fruits exotiques.<br/>
                        Médaille d’argent au Concours International de Lyon 2016<br/>
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
                        La Parcelle de l’Ortolan accompagnera parfaitement fruits de mer, poissons<br/> et fromages.
                    </p>
                </div>

                @if ($is_user)<span class="sale-price">Prix : <span class="value">10€</span></span>@endif
                <a href="@if (!$is_user){{ route('user_login_handler') }}@else{{ '#' }}@endif" class="button">Commander</a>
            </li>


            <li>
                <div class="background" style="background-image: url({{ asset('img/sales/1/5/background.jpg') }})"></div>
                <img class="bottle" src="{{ asset('img/sales/1/5/bottle.png') }}" alt="Péché de vigne" />
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
                </div>

                @if ($is_user)<span class="sale-price">Prix : <span class="value">13€</span></span>@endif
                <a href="@if (!$is_user){{ route('user_login_handler') }}@else{{ '#' }}@endif" class="button">Commander</a>
            </li>


            <li>
                <div class="background" style="background-image: url({{ asset('img/sales/1/6/background.jpg') }})"></div>
                <img class="bottle" src="{{ asset('img/sales/1/6/bottle.png') }}" alt="Arigliole Julian" />
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
                </div>

                @if ($is_user)<span class="sale-price">Prix : <span class="value">9€</span></span>@endif
                <a href="@if (!$is_user){{ route('user_login_handler') }}@else{{ '#' }}@endif" class="button">Commander</a>
            </li>
        </ul>
    </div>
</div>