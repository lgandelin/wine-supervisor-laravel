@extends('wine-supervisor::default')

@section('page-content')

    <h1>Club Avantages</h1>

    @foreach ($sales as $sale)
        <div class="sale">
            <h2>{{ $sale->title }}</h2>

            <strong>Note :</strong> {{ $sale->jury_note }} / 20 <br/>
            <strong>Avis du jury :</strong> {!! $sale->jury_opinion !!}
            <strong>Commentaires : </strong> {!! $sale->description !!}

            @if ($sale->link)
                <a href="{{ $sale->link }}" target="_blank">COMMANDER</a>
            @endif

            <hr/>
        </div>
    @endforeach

@stop