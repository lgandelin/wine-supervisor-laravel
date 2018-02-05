@extends('wine-supervisor::default')

@section('page-title'){{ trans('wine-supervisor::club_premium.informations.meta_title') }}@endsection

@section('page-content')

    <div class="club-premium-template">
        @include('wine-supervisor::pages.user.includes.header')

        <!-- BANNER -->
        <div class="banner">
            <h1><img class="logo-club-premium" src="{{ asset('img/club-premium/logo-club-avantage.png') }}" width="350" height="205" alt="Aux membres du Club Avantage" /></h1>
        </div>
        <!-- BANNER -->

        <div class="main-content container" id="top">

            <!-- LEFT NAVIGATION -->
            <nav class="left-navigation">
                @include('wine-supervisor::pages.club-premium.includes.menu')
            </nav>
            <!-- LEFT NAVIGATION -->

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>{{ trans('wine-supervisor::club_premium.informations.page_title') }}</h1>
                <p>{{ trans('wine-supervisor::club_premium.informations.page_header') }}</p>
            </div>
            <!-- PAGE HEADER -->

            <!-- PAGE CONTENT -->
            <div class="page-content text-content">
                <section>
                    <div class="left-image"><img src="{{ asset('img/club-premium/left-image.jpg') }}" width="541" height="361" /></div>
                    <div class="text">
                        <?php include base_path() . '/contents/' . App::getLocale() . '/club-avantage/qu-est-ce-que-le-club-avantage.html' ?>
                    </div>
                </section>

                @if ($programme_des_ventes)
                    <section>
                        @if ($programme_des_ventes->image)
                            <div class="right-image" style="margin-top:1rem"><img src="{{ asset(env('WS_UPLOADS_FOLDER') . 'contents/' . $programme_des_ventes->id . '/' . $programme_des_ventes->image) }}" width="541" height="457" /></div>
                        @endif

                        <div class="text" style="padding-top: 0rem;">
                            @if (App::getLocale() == 'fr')
                                {!! $programme_des_ventes->text !!}
                            @elseif (App::getLocale() == 'en')
                                {!! $programme_des_ventes->text_en !!}
                            @endif
                        </div>
                    </section>
                @endif

            </div>
            <!-- PAGE CONTENT -->

        </div>

        @include('wine-supervisor::partials.legal-notices')
    </div>

@stop