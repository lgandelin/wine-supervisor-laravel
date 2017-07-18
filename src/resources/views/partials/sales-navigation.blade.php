<ul class="sales-navigation">
    @foreach ($sales as $i => $sale)
        <li data-slider="{{ ($i+1) }}" @if ($i == 0)class="active"@endif>
            <span class="sale-background"><img src="{{ asset('img/sales/' . $sale->id . '/0/' . $sale->image) }}" /></span>
            <span class="sale-name">
                @if (new DateTime() <= DateTime::createFromFormat('Y-m-d', $sale->end_date) && new DateTime() >= DateTime::createFromFormat('Y-m-d', $sale->start_date))
                    En cours
                @else
                    {{ strftime('%d %B', DateTime::createFromFormat('Y-m-d', $sale->start_date)->getTimestamp()) }} -
                    {{ strftime('%d %B', DateTime::createFromFormat('Y-m-d', $sale->end_date)->getTimestamp()) }}
                @endif
            </span>
        </li>
    @endforeach
</ul>