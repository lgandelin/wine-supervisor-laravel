<ul>
    <li class="info @if (isset($route) && $route == 'club_premium') active @endif"><a title="Informations" href="{{ route('club_premium') }}"><span>Informations</span></a></li>
    <li class="comity @if (isset($route) && $route == 'club_premium_comity') active @endif"><a title="Comité de dégustation" href="{{ route('club_premium_comity') }}"><span>Comité de dégustation</span></a></li>
    <li class="current-sales @if (isset($route) && $route == 'club_premium_current_sales') active @endif"><a title="Ventes en cours" href="{{ route('club_premium_current_sales') }}"><span>Ventes en cours</span></a></li>
    <li class="history @if (isset($route) && $route == 'club_premium_sales_history') active @endif"><a title="Historique des ventes" href="{{ route('club_premium_sales_history') }}"><span>Historique des ventes</span></a></li>
</ul>