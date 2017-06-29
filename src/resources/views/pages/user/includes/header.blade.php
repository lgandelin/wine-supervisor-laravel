<!-- HEADER -->
<header>


    <!-- TOP BAR -->
    <div class="top-bar">
        <div class="container">
            <div class="nav">
                <nav>
                    <ul>
                        @include('wine-supervisor::pages.user.includes.menu')
                    </ul>
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
                    <li><a href="#wine-supervisor">WineSupervisor</a></li>
                    <li><a href="#club-avantage">Le Club</a></li>
                    <li><a href="#actualites">Actualités</a></li>
                    <li><a href="#nos-partenaires">Nos partenaires</a></li>
                    <li><a href="#top">Contact</a></li>
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