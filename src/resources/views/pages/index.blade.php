@extends('wine-supervisor::default')

@section('page-title'){{ trans('wine-supervisor::home.meta_title') }}@endsection

@section('page-content')
    <div class="home-template">

        @include('wine-supervisor::pages.user.includes.header')

        <!-- BANNER -->
        <div class="banner" id="top">
            <h2>
                <span class="title">{{ trans('wine-supervisor::home.banner_title') }}</span>
            </h2>
        </div>
        <!-- BANNER -->

        <!-- BOX -->
        <div class="box" id="wine-supervisor">
            <div class="container">
                <h2 class="title"><img class="logo-wine-supervisor-ii" src="{{ asset('img/home/box/logo-winesupervisor-ii.png') }}" width="450" height="100" alt="WineSupervisor" /></h2>
                
                <?php include base_path() . '/contents/' . App::getLocale() . '/home/wine-supervisor.html' ?>

                <div class="buttons">
                    <a href="http://friax.fr/winesupervisor" target="_blank" class="btn red-button btn-discover">{{ trans('wine-supervisor::home.buttons.discover') }}</a>
                    @if (!$is_user && !$is_technician && !$is_guest)
                        <a href="{{ route('user_login') }}?route=index" class="btn red-button btn-supervision">{{ trans('wine-supervisor::home.buttons.login') }}</a>
                    @elseif ($is_eligible_to_supervision)
                        <a href="{{ route('supervision') }}" target="_blank" class="btn red-button btn-supervision">{{ trans('wine-supervisor::home.buttons.supervision') }}</a>
                    @endif
                </div>

                <img class="box-image" src="{{ asset('img/home/box/box.png') }}" width="390" height="453" alt="WineSupervisor" />
            </div>
        </div>
        <!-- BOX -->

        <!-- CLUB -->
        <div class="club" id="club-avantage">
            <div class="container">
                <h2 class="title">{{ trans('wine-supervisor::home.club_premium.title') }}</h2>
            </div>
        </div>
        <!-- CLUB -->

        <div class="club-contents">
            <div class="container">
                <div class="image">
                    <img src="{{ asset('img/club-premium/logo-club-avantage.png') }}" alt="Wine Supervisor - Club Avantage" width="300" height="205" />
                </div>
                <div class="text">
                    <?php include base_path() . '/contents/' . App::getLocale() . '/home/club-avantage.html' ?>
                </div>

                <a href="{{ route('club_premium') }}" class="btn red-button">{{ trans('wine-supervisor::home.club_premium.discover_club_premium') }}</a>
            </div>
        </div>

        <!-- SALES -->
        <div class="sales">

            @include('wine-supervisor::partials.sales-slider', ['sales' => $sales, 'current_sale' => $current_sale])

            <div class="container">
                <div class="sales-navigation-wrapper">
                    <div class="sales-navigation-arrows"></div>
                    @include('wine-supervisor::partials.sales-navigation', ['sales' => $sales, 'current_sale' => $current_sale])
                </div>
            </div>
        </div>
        <!-- SALES -->

        <!-- NEWS -->
        @if ($contents)
            <div class="news" id="actualites">
                <div class="container">
                    <h2 class="title">{{ trans('wine-supervisor::home.news') }}</h2>

                    <div class="news-slider-dots"></div>
                    <ul class="news-slider">
                        @foreach ($contents as $content)
                            <li>
                                @if ($content->image)<img class="image" src="{{ asset(env('WS_UPLOADS_FOLDER') . 'contents/' . $content->id . '/' . $content->image) }}" alt="{{ $content->title }}" width="350" height="273" />@endif
                                <div class="content">
                                    @if ($content->publication_date)<span class="date">{{ strftime('%d %B %Y', DateTime::createFromFormat('Y-m-d', $content->publication_date)->getTimestamp()) }}</span>@endif
                                    @if (App::getLocale() == 'en')
                                        @if ($content->title_en)<h3>{{ $content->title_en }}</h3>@endif
                                        @if ($content->text_en)<p>{!! $content->text_en !!}</p>@endif
                                    @else
                                        @if ($content->title)<h3>{{ $content->title }}</h3>@endif
                                        @if ($content->text)<p>{!! $content->text !!}</p>@endif
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        <!-- NEWS -->


        <!-- OUR PARTNERS -->
        @if ($partners)
            <div class="our-partners" id="nos-partenaires">
                <div class="container">
                    <h2 class="title">{{ trans('wine-supervisor::home.partners') }}</h2>

                    <div class="partners-slider-arrows"></div>
                    <ul class="partners-slider">

                        @for($i = 0; $i < 3; $i++)
                            @foreach ($partners as $partner)
                                <li><a href="{{ $partner->url }}" target="_blank"><img class="partner" src="{{ asset('uploads/partners/' . $partner->id . '/' . $partner->image) }}" alt="{{ $partner->name }}" @if ($partner->image_width)width="{{ $partner->image_width }}"@endif @if ($partner->image_height)height="{{ $partner->image_height }}"@endif /></a></li>
                            @endforeach
                        @endfor
                    </ul>
                </div>
            </div>
        @endif
        <!-- OUR PARTNERS -->

        @include('wine-supervisor::partials.legal-notices')
    </div>
@stop