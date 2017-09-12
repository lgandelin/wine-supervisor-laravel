<!-- HEADER -->
<header>


    <!-- TOP BAR -->
    <div class="top-bar">
        <div class="container">
            @if (isset($first_name) && $first_name)
                <span class="welcome">@if (isset($route) && preg_match('/club_premium/', $route)){{ trans('wine-supervisor::menus.top_menu.good_tasting') }}@else{{ trans('wine-supervisor::menus.top_menu.welcome') }}@endif, <span class="first-name">{{ $first_name }}</span></span>
            @endif

            <div class="nav">
                <nav>
                    @include('wine-supervisor::pages.user.includes.menu')
                </nav>
            </div>
        </div>
    </div>
    <!-- TOP BAR -->

    <!-- LOGO AND NAVIGATION -->
    <div class="logo-navigation">
        <div class="container">
            <span class="hamburger"></span>
            <nav>
                <ul>
                    <li><a href="@if (isset($route) && $route == 'index')@else{{ route('index') }}@endif#top">{{ trans('wine-supervisor::menus.main_menu.home') }}</a></li>
                    <li><a href="@if (isset($route) && $route == 'index')@else{{ route('index') }}@endif#club-avantage">{{ trans('wine-supervisor::menus.main_menu.club') }}</a></li>
                    <li><a href="@if (isset($route) && $route == 'index')@else{{ route('index') }}@endif#actualites">{{ trans('wine-supervisor::menus.main_menu.news') }}</a></li>
                    <li><a href="@if (isset($route) && $route == 'index')@else{{ route('index') }}@endif#nos-partenaires">{{ trans('wine-supervisor::menus.main_menu.partners') }}</a></li>
                    <li><a href="http://friax.fr/faq" target="_blank">{{ trans('wine-supervisor::menus.main_menu.faq') }}</a></li>
                    <li><a href="{{ route('contact') }}">{{ trans('wine-supervisor::menus.main_menu.contact') }}</a></li>
                </ul>
            </nav>

            <h1 class="logo">
                <a href="{{ route('index') }}">
                    <img src="{{ asset('img/header/logo-wine-supervisor.png') }}" width="308" height="67" alt="Logo WineSupervisor" />
                </a>
            </h1>
        </div>
    </div>
    <!-- LOGO AND NAVIGATION -->

</header>
<!-- HEADER -->