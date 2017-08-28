@if (isset($sale))
    <div class="container @if ($index == 1)first @endif ">
        <div class="slider-container">
            <div class="sales-slider-arrows sales-slider-arrows-@if (isset($index)){{ $index }}@else{{ '1' }}@endif"></div>
            <ul class="sales-slider sales-slider-@if (isset($index)){{ $index }}@else{{ '1' }}@endif" data-slider="@if (isset($index)){{ $index }}@else{{ '1' }}@endif">

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
                                    @if ($sale->is_active && $sale->comments)
                                        <div class="sale-comments">{!! nl2br($sale->comments) !!}</div>
                                    @endif
                                @endif

                                @if (isset($wine->variety))<span class="sale-subtitle">{{ $wine->variety }}</span>@endif
                                @if (isset($wine->name))<h3 class="sale-name">{{ $wine->name }}</h3>@endif

                                {!! $wine->text !!}
                            </div>

                            @if (($is_user || $is_guest) && $is_eligible_to_club_premium)
                                @if ($wine->club_premium_price && $sale->is_active)
                                    <span class="sale-price">
                                        <span class="club_premium_price_label">Prix Club Avantage</span>
                                        <span class="prices">
                                            @if ($wine->standard_price)<span class="standard">{{ $wine->standard_price }}€</span> -> @endif
                                            <span class="club_premium">{{ $wine->club_premium_price }}€</span>
                                        </span>
                                    </span>
                                @endif
                            @endif

                            @if ($sale->is_active)
                                @if ((!$is_user && !$is_guest) || !$is_eligible_to_club_premium)
                                    <a href="{{ route('user_login_handler') }}?route=club_premium_current_sales" class="button">Accès vente</a>
                                @elseif ($wine->link)
                                    <a target="_blank" href="{{ $wine->link }}" class="button">Commander</a>
                                @endif
                            @endif
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
@endif