<!-- HEADER -->
<header>


    <!-- TOP BAR -->
    <div class="top-bar">
        <div class="container">
            @if (isset($first_name) && $first_name)
                <span class="welcome">@if (isset($route) && preg_match('/club_premium/', $route)){{'Bonne dégustation'}}@else{{'Bienvenue'}}@endif, <span class="first-name">{{ $first_name }}</span></span>
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
            <nav>
                <ul>
                    <li><a href="@if (isset($route) && $route != 'index'){{ route('index') }}@endif#top">Accueil</a></li>
                    <li><a href="@if (isset($route) && $route != 'index'){{ route('index') }}@endif#club-avantage">Le Club</a></li>
                    <li><a href="@if (isset($route) && $route != 'index'){{ route('index') }}@endif#actualites">Actualités</a></li>
                    <li><a href="@if (isset($route) && $route != 'index'){{ route('index') }}@endif#nos-partenaires">Nos partenaires</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
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