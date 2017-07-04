<!-- HEADER -->
<header>


    <!-- TOP BAR -->
    <div class="top-bar">
        <div class="container">
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
                    <li><a href="@if (isset($route) && $route != 'index'){{ route('index') }}@endif#wine-supervisor">WineSupervisor</a></li>
                    <li><a href="@if (isset($route) && $route != 'index'){{ route('index') }}@endif#club-avantage">Le Club</a></li>
                    <li><a href="@if (isset($route) && $route != 'index'){{ route('index') }}@endif#actualites">Actualités</a></li>
                    <li><a href="@if (isset($route) && $route != 'index'){{ route('index') }}@endif#nos-partenaires">Nos partenaires</a></li>
                    <li><a href="@if (isset($route) && $route != 'index'){{ route('index') }}@endif#top">Contact</a></li>
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