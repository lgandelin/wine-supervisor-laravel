<ul>
    <li class="langs">
        <a @if (App::getLocale() == 'fr') class="current" @endif href="/"><img src="{{ asset('img/generic/flags/fr.jpg') }}" width="35" height="25" /></a>
        <a @if (App::getLocale() == 'en') class="current" @endif href="/en"><img src="{{ asset('img/generic/flags/en.jpg') }}" width="35" height="25" /></a>
    </li>

    @if (isset($is_technician) && $is_technician)
        <li @if (isset($route) && $route == 'technician_update_account')class="active"@endif><a href="{{ route('technician_update_account') }}">{{ trans('wine-supervisor::menus.top_menu.my_account') }}</a></li>

        @if (isset($is_eligible_to_supervision) && $is_eligible_to_supervision)
            <li><a target="_blank" href="{{ route('supervision') }}">{{ trans('wine-supervisor::menus.top_menu.supervision') }}</a></li>
        @endif

        <li class="account logout">
            <a href="{{ route('user_logout') }}"><span class="logout-icon" title="{{ trans('wine-supervisor::menus.login.disconnect') }}"></span></a>
        </li>
    @elseif (isset($is_user) && $is_user)
        <li @if (isset($route) && $route == 'user_update_account')class="active"@endif><a href="{{ route('user_update_account') }}">{{ trans('wine-supervisor::menus.top_menu.my_account') }}</a></li>

        @if ($is_eligible_to_club_premium)
            <li @if (isset($route) && preg_match('/club_premium/', $route))class="active"@endif><a href="{{ route('club_premium') }}">{{ trans('wine-supervisor::menus.top_menu.club_premium') }}</a></li>
        @endif

        @if ($is_eligible_to_supervision)
            <li><a target="_blank" href="{{ route('supervision') }}">{{ trans('wine-supervisor::menus.top_menu.supervision') }}</a></li>
        @endif

        <li class="account logout">
            <a href="{{ route('user_logout') }}"><span class="logout-icon" title="{{ trans('wine-supervisor::menus.login.disconnect') }}"></span></a>
        </li>
    @elseif (isset($is_guest) && $is_guest)
        <li @if (isset($route) && preg_match('/club_premium/', $route))class="active"@endif><a href="{{ route('club_premium') }}">{{ trans('wine-supervisor::menus.top_menu.club_premium') }}</a></li>

        <li class="account logout">
            <a href="{{ route('user_logout') }}"><span class="logout-icon" title="{{ trans('wine-supervisor::menus.login.disconnect') }}"></span></a>
        </li>
    @else
        <li @if (isset($route) && preg_match('/club_premium/', $route))class="active"@endif><a href="{{ route('club_premium') }}">{{ trans('wine-supervisor::menus.top_menu.club_premium') }}</a></li>
        <li @if (isset($route) && $route == 'user_signup')class="active"@endif><a href="{{ route('user_signup') }}">{{ trans('wine-supervisor::menus.top_menu.signup') }}</a></li>
        <li class="account">
            <span class="account-icon"></span>
            <form class="login form-horizontal" role="form" method="POST" action="{{ route('user_login_handler') }}" style="display: none">
                <div class="input-login">
                    <input type="text" name="login" />
                </div>

                <div class="input-password">
                    <input type="password" name="password" autocomplete="off" />
                </div>

                <input type="submit" value="{{ trans('wine-supervisor::login.login.login') }}" />
                <a class="forgotten-password" href="{{ route('forgotten_password') }}">{{ trans('wine-supervisor::login.forgotten_password.forgotten_password') }}</a>

                <input type="hidden" name="route" value="{{ (isset($route) && $route) ? $route : (Request::route() ? Request::route()->getName() : '') }}" />
                {!! csrf_field() !!}
            </form>
        </li>
    @endif
</ul>