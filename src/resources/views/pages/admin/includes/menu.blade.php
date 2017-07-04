<ul>
    <li @if (isset($route) && $route == 'admin_index')class="active"@endif><a href="{{ route('admin_index') }}">Tableau de bord</a></li>
    <li @if (isset($route) && preg_match('/admin_ws/', $route))class="active"@endif><a href="{{ route('admin_ws_list') }}">WineSupervisor</a></li>
    <li @if (isset($route) && preg_match('/admin_cellar/', $route))class="active"@endif><a href="{{ route('admin_cellar_list') }}">Caves</a></li>
    <li @if (isset($route) && preg_match('/admin_technician/', $route))class="active"@endif><a href="{{ route('admin_technician_list') }}">Professionnels</a></li>
    <li @if (isset($route) && preg_match('/admin_guest/', $route))class="active"@endif><a href="{{ route('admin_guest_list') }}">Invités</a></li>
    <li @if (isset($route) && preg_match('/admin_sale/', $route))class="active"@endif><a href="{{ route('admin_sale_list') }}">Ventes</a></li>
    <li @if (isset($route) && preg_match('/admin_content/', $route))class="active"@endif><a href="{{ route('admin_content_list') }}">Actualités</a></li>
    <li class="account logout"><a href="{{ route('admin_logout') }}"><span class="logout-icon" title="Se déconnecter"></span></a></li>
</ul>

