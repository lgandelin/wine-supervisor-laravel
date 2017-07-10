<ul>
    @if (isset($is_technician) && $is_technician)
        <li @if (isset($route) && $route == 'technician_update_account')class="active"@endif><a href="{{ route('technician_update_account') }}">Gérer mon compte</a></li>
        <li><a href="{{ route('supervision') }}">Supervision</a></li>
        <li class="account logout">
            <a href="{{ route('user_logout') }}"><span class="logout-icon" title="Se déconnecter"></span></a>
        </li>
    @elseif (isset($is_user) && $is_user)
        <li @if (isset($route) && $route == 'user_update_account')class="active"@endif><a href="{{ route('user_update_account') }}">Gérer mon compte</a></li>
        <li @if (isset($route) && preg_match('/club_premium/', $route))class="active"@endif><a href="{{ route('club_premium') }}">Club Avantage</a></li>
        <li><a href="{{ route('supervision') }}">Supervision</a></li>
        <li class="account logout">
            <a href="{{ route('user_logout') }}"><span class="logout-icon" title="Se déconnecter"></span></a>
        </li>
    @else
        <li @if (isset($route) && preg_match('/club_premium/', $route))class="active"@endif><a href="{{ route('club_premium') }}">Club Avantage</a></li>
        <li @if (isset($route) && $route == 'user_signup')class="active"@endif><a href="{{ route('user_signup') }}">Créer un compte</a></li>
        <li class="account">
            <span class="account-icon"></span>
            <form class="login form-horizontal" role="form" method="POST" action="{{ route('user_login_handler') }}">
                <div class="input-login">
                    <input type="text" name="login" />
                </div>

                <div class="input-password">
                    <input type="password" name="password" autocomplete="off" />
                </div>

                <input type="submit" value="{{ trans('wine-supervisor::login.login') }}" />
                <a class="forgotten-password" href="{{ route('forgotten_password') }}">{{ trans('wine-supervisor::login.forgotten_password') }}</a>

                {!! csrf_field() !!}
            </form>
        </li>
    @endif
</ul>