<ul>
    <li class="info @if (isset($route) && $route == 'club_premium') active @endif"><a title="Informations" href="{{ route('club_premium') }}#top"><span>{{ trans('wine-supervisor::menus.club_premium.informations') }}</span></a></li>
    <li class="comity @if (isset($route) && $route == 'club_premium_comity') active @endif"><a title="Comité de dégustation" href="{{ route('club_premium_comity') }}#top"><span>{{ trans('wine-supervisor::menus.club_premium.comity') }}</span></a></li>
    <li class="current-sales @if (isset($route) && $route == 'club_premium_current_sales') active @endif"><a title="Ventes en cours" href="{{ route('club_premium_current_sales') }}#top"><span>{{ trans('wine-supervisor::menus.club_premium.current_sales') }}</span></a></li>
    <li class="history @if (isset($route) && $route == 'club_premium_sales_history') active @endif"><a title="Historique des ventes" href="{{ route('club_premium_sales_history') }}#top"><span>{{ trans('wine-supervisor::menus.club_premium.sales_history') }}</span></a></li>
</ul>
