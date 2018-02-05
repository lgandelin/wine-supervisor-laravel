@if ($sales && sizeof($sales) > 0)
    @foreach ($sales as $index => $sale)
        <div class="container @if ((isset($current_sale) && ($index+1) == $current_sale))first @endif ">
            <div class="slider-container">
                <div class="sales-slider-arrows sales-slider-arrows-{{ ($index+1) }}"></div>
                <ul class="sales-slider sales-slider-{{ ($index+1) }}" data-slider="{{ ($index+1) }}">

                    @if (isset($sale->image))
                        <li>
                            <div class="background" style="background-image: url({{ asset(env('WS_UPLOADS_FOLDER') . 'sales/' . $sale->id . '/0/' . $sale->image) }})"></div>
                        </li>
                    @endif

                    @if (is_array($sale->wines) && sizeof($sale->wines) > 0)
                        @foreach ($sale->wines as $i => $wine)
                            <li>
                                <div class="background" style="background-image:url({{ asset(env('WS_UPLOADS_FOLDER') . 'sales/' . $sale->id . '/' . ($i+1) . '/' . $wine->image) }})"></div>
                                <img class="bottle" src="{{ asset(env('WS_UPLOADS_FOLDER') . 'sales/' . $sale->id . '/' . ($i+1) . '/' . $wine->bottle_image) }}" alt="{{ $wine->name }}" />
                                <div class="content">
                                    @if (($is_user || $is_guest) && $is_eligible_to_club_premium)
                                        @if ($sale->is_active)
                                            @if (App::getLocale() == 'en' && $sale->comments_en)
                                                <div class="sale-comments">{!! nl2br($sale->comments_en) !!}</div>
                                            @elseif (App::getLocale() == 'fr' && $sale->comments)
                                                <div class="sale-comments">{!! nl2br($sale->comments) !!}</div>
                                            @endif
                                        @endif
                                    @endif

                                    @if (isset($wine->variety))<span class="sale-subtitle">{{ $wine->variety }}</span>@endif
                                    @if (isset($wine->name))<h3 class="sale-name">{{ $wine->name }}</h3>@endif

                                    @if (App::getLocale() == 'en')
                                        {!! $wine->text_en !!}
                                    @else
                                        {!! $wine->text !!}
                                    @endif
                                </div>

                                @if (($is_user || $is_guest) && $is_eligible_to_club_premium)
                                    @if ($wine->club_premium_price && $sale->is_active)
                                        @if (new DateTime() <= DateTime::createFromFormat('Y-m-d', $sale->end_date) && new DateTime() >= DateTime::createFromFormat('Y-m-d', $sale->start_date))
                                            <span class="sale-price">
                                                <span class="club_premium_price_label">{{ trans('wine-supervisor::sales_slider.club_premium_price') }}</span>
                                                <span class="prices">
                                                    @if ($wine->standard_price)<span class="standard">{{ $wine->standard_price }}€</span> -> @endif
                                                    <span class="club_premium">{{ $wine->club_premium_price }}€</span>
                                                </span>
                                            </span>
                                        @endif
                                    @endif
                                @endif

                                @if ($sale->is_active)
                                    @if (new DateTime() > DateTime::createFromFormat('Y-m-d', $sale->end_date))
                                        @if ($sale->link_history)
                                            <a target="_blank" href="{{ $sale->link_history }}" class="button">{{ trans('wine-supervisor::sales_slider.website_access') }}</a>
                                        @endif
                                    @elseif ((!$is_user && !$is_guest) || !$is_eligible_to_club_premium)
                                        <a href="{{ route('user_login_handler') }}?route=club_premium_current_sales" class="button">{{ trans('wine-supervisor::sales_slider.sales_access') }}</a>
                                    @elseif ($wine->link)
                                        <a target="_blank" href="{{ $wine->link }}" class="button">{{ trans('wine-supervisor::sales_slider.order') }}</a>
                                    @endif
                                @endif
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    @endforeach
@endif

<script>
    var current_sale_slide = {{ ($current_sale-1) }};
</script>