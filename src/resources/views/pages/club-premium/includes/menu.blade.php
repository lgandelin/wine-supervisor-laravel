<ul>
    <li class="info @if (isset($route) && $route == 'club_premium') active @endif"><a href="{{ route('club_premium') }}"><span>Informations</span></a></li>
    <li class="comity"><a href="#"><span>Comité</span></a></li>
    <li class="current-sales @if (isset($route) && $route == 'club_premium_current_sales') active @endif"><a href="{{ route('club_premium_current_sales') }}"><span>Ventes en cours</span></a></li>
    <li class="history @if (isset($route) && $route == 'club_premium_sales_history') active @endif"><a href="{{ route('club_premium_sales_history') }}"><span>Historique des ventes</span></a></li>
</ul>