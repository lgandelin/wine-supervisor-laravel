<ul class="sales-navigation">
    @if (isset($last_sale) && $last_sale)
            <li data-slider="0">
                <span class="sale-background"><img src="{{ asset(env('WS_UPLOADS_FOLDER') . 'sales/' . $last_sale->id . '/0/' . $last_sale->image) }}" /></span>
                <span class="sale-name @if ($last_sale->text_color){{ $last_sale->text_color }}@endif">
                    @if ($last_sale->start_date){{ strftime('%d %B', DateTime::createFromFormat('Y-m-d', $last_sale->start_date)->getTimestamp()) }} -@endif
                    @if ($last_sale->end_date){{ strftime('%d %B', DateTime::createFromFormat('Y-m-d', $last_sale->end_date)->getTimestamp()) }}@endif
                    {{ strftime('%Y', DateTime::createFromFormat('Y-m-d', $last_sale->end_date)->getTimestamp()) }}
                </span>
            </li>
    @endif

    @foreach ($sales as $i => $sale)
        <li data-slider="{{ ($i+1) }}" @if ($i == 0)class="active"@endif>
            <span class="sale-background"><img src="{{ asset(env('WS_UPLOADS_FOLDER') . 'sales/' . $sale->id . '/0/' . $sale->image) }}" /></span>
            <span class="sale-name @if ($sale->text_color){{ $sale->text_color }}@endif">
                @if (new DateTime() <= DateTime::createFromFormat('Y-m-d', $sale->end_date) && new DateTime() >= DateTime::createFromFormat('Y-m-d', $sale->start_date))
                    {{ trans('wine-supervisor::sales_slider.current') }}
                @elseif (new DateTime() < DateTime::createFromFormat('Y-m-d', $sale->start_date))
                    {{ trans('wine-supervisor::sales_slider.upcoming') }}
                @else
                    @if ($sale->start_date){{ strftime('%d %B', DateTime::createFromFormat('Y-m-d', $sale->start_date)->getTimestamp()) }} -@endif
                    @if ($sale->end_date){{ strftime('%d %B', DateTime::createFromFormat('Y-m-d', $sale->end_date)->getTimestamp()) }}@endif
                    {{ strftime('%Y', DateTime::createFromFormat('Y-m-d', $sale->end_date)->getTimestamp()) }}
                @endif
            </span>
        </li>
    @endforeach
</ul>