<ul class="sales-navigation">
    @foreach ($sales as $index => $sale)
        <li data-slider="{{ ($index+1) }}" @if (($index+1) == $current_sale)class="active"@endif>
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