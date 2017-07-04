<!-- HEADER -->
<header>


    <!-- TOP BAR -->
    <div class="top-bar">
        <div class="container">
            <div class="nav">
                <nav>
                    @include('wine-supervisor::pages.admin.includes.menu')
                </nav>
            </div>
        </div>
    </div>
    <!-- TOP BAR -->

    <!-- LOGO AND NAVIGATION -->
    <div class="logo-navigation">
        <div class="container">

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