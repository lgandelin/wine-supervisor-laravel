@extends('wine-supervisor::default')

@section('page-title') Créer une vente < Administration | WineSupervisor @endsection

@section('page-content')

    @include('wine-supervisor::pages.admin.includes.header')

    <div class="sale-template admin-template">

        <!-- MAIN CONTENT -->
        <div class="main-content container">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>Créer une vente</h1>
            </div>
            <!-- PAGE HEADER -->

            <!-- PAGE CONTENT -->
            <div class="page-content">

                @if (isset($error))
                    <div class="alert alert-danger">
                        {{ $error }}
                    </div>
                @endif

                @if (isset($confirmation))
                    <div class="alert alert-success">
                        {{ $confirmation }}
                    </div>
                @endif

                <form action="{{ route('admin_sale_create_handler') }}" method="POST">

                    <div class="form-group">
                        <label for="title">Titre</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" />
                    </div>

                    <div class="form-group" style="display: none;">
                        <label for="description">Description</label>
                        <textarea class="editor" name="description" id="description">{{ old('description') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="start_date">Date de début</label>
                        <input type="text" name="start_date" id="start_date" value="{{ old('start_date') }}" class="datepicker" />
                    </div>

                    <div class="form-group">
                        <label for="end_date">Date de fin</label>
                        <input type="text" name="end_date" id="end_date" value="{{ old('end_date') }}" class="datepicker" />
                    </div>

                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="text" name="image" id="image" value="{{ $sale->image }}" />
                        <br/>
                        <br/>
                        @if ($sale->image)
                            Image actuelle : {{ $sale->image }}<br>
                            <img class="thumbnail" src="{{ asset('img/sales/' . $sale->id . '/0/' . $sale->image) }}" />
                        @else
                            Aucune image actuellement
                        @endif
                    </div>

                    <div class="form-group">
                        @for($i = 0; $i < 10; $i++)
                            <section style="border-bottom: 1px solid #333; margin-bottom: 3rem; padding-bottom: 1rem">
                                <h3 style="font-weight: bold; margin-bottom: 1rem;">Vin n°{{ $i+1 }}</h3>
                                <div class="form-group">
                                    <label for="name[]">Nom</label>
                                    <input type="text" name="wine_name[]" value="@if (isset($sale->wines[$i]) && isset($sale->wines[$i]->name)){{ $sale->wines[$i]->name }}@endif" />
                                </div>

                                <div class="form-group">
                                    <label for="variety[]">Cépages</label>
                                    <input type="text" name="wine_variety[]" value="@if (isset($sale->wines[$i]) && isset($sale->wines[$i]->variety)){{ $sale->wines[$i]->variety }}@endif" />
                                </div>

                                <div class="form-group">
                                    <label for="text[]">Texte</label>
                                    <textarea class="editor" name="wine_text[]" id="text_{{ $i }}">@if (isset($sale->wines[$i]) && isset($sale->wines[$i]->text)){{ $sale->wines[$i]->text }}@endif</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="image[]">Image de fond</label>
                                    <input type="text" name="wine_image[]" value="@if (isset($sale->wines[$i]) && isset($sale->wines[$i]->image)){{ $sale->wines[$i]->image }}@endif" />
                                </div>

                                <div class="form-group">
                                    <label for="bottle_image[]">Image de la bouteille</label>
                                    <input type="text" name="wine_bottle_image[]" value="@if (isset($sale->wines[$i]) && isset($sale->wines[$i]->bottle_image)){{ $sale->wines[$i]->bottle_image }}@endif" />
                                </div>

                                <div class="form-group">
                                    <label for="standard_price[]">Prix standard</label>
                                    <input type="text" name="wine_standard_price[]" placeholder="ex: 12.5" value="@if (isset($sale->wines[$i]) && isset($sale->wines[$i]->standard_price)){{ $sale->wines[$i]->standard_price }}@endif" />
                                </div>

                                <div class="form-group">
                                    <label for="club_premium_price[]">Prix Club Avantage</label>
                                    <input type="text" name="wine_club_premium_price[]" placeholder="ex: 8.5" value="@if (isset($sale->wines[$i]) && isset($sale->wines[$i]->club_premium_price)){{ $sale->wines[$i]->club_premium_price }}@endif" />
                                </div>

                                <div class="form-group">
                                    <label for="link[]">Lien de commande</label>
                                    <input type="text" name="wine_link[]" value="@if (isset($sale->wines[$i]) && isset($sale->wines[$i]->link)){{ $sale->wines[$i]->link }}@endif" />
                                </div>
                            </section>
                        @endfor
                    </div>

                    <div class="submit-container">
                        <input type="submit" value="Valider" />
                    </div>

                    {{ csrf_field() }}
                </form>

                <a class="button red-button back-button" href="{{ route('admin_sale_list') }}">Retour</a>

            </div>
            <!-- PAGE CONTENT -->

        </div>
        <!-- MAIN CONTENT -->

    </div>

    <script>
        $(document).ready(function() {
            CKEDITOR.replace( 'description' );
            CKEDITOR.replace( 'jury_opinion' );
        });
    </script>
@stop
