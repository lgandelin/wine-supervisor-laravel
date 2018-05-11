<ul>
    @if ($is_admin)
        <li @if (isset($route) && $route == 'admin_index')class="active"@endif><a href="{{ route('admin_index') }}">Tableau de bord</a></li>
        <li @if (isset($route) && preg_match('/admin_ws/', $route))class="active"@endif><a href="{{ route('admin_ws_list') }}">WineSupervisor</a></li>
        <li @if (isset($route) && preg_match('/admin_cellar/', $route))class="active"@endif><a href="{{ route('admin_cellar_list') }}">Caves</a></li>
        <li @if (isset($route) && preg_match('/admin_user/', $route))class="active"@endif><a href="{{ route('admin_user_list') }}">Utilisateurs</a></li>
        <li @if (isset($route) && preg_match('/admin_technician/', $route))class="active"@endif><a href="{{ route('admin_technician_list') }}">Techniciens</a></li>
        <li @if (isset($route) && preg_match('/admin_guest/', $route))class="active"@endif><a href="{{ route('admin_guest_list') }}">Invités</a></li>
        <li @if (isset($route) && preg_match('/admin_sale/', $route))class="active"@endif><a href="{{ route('admin_sale_list') }}">Ventes de vins</a></li>
        <li @if (isset($route) && preg_match('/admin_accessories_sale/', $route))class="active"@endif><a href="{{ route('admin_accessories_sale_list') }}">Ventes d'accessoires</a></li>
        <li @if (isset($route) && preg_match('/admin_content/', $route))class="active"@endif><a href="{{ route('admin_content_list') }}">Actualités</a></li>
        <li @if (isset($route) && preg_match('/admin_page_content/', $route))class="active"@endif><a href="{{ route('admin_page_content_list') }}">Contenus</a></li>
        <li @if (isset($route) && preg_match('/admin_partner/', $route))class="active"@endif><a href="{{ route('admin_partner_list') }}">Partenaires</a></li>
        <li class="account logout"><a href="{{ route('admin_logout') }}"><span class="logout-icon" title="Se déconnecter"></span></a></li>
    @endif
</ul>

