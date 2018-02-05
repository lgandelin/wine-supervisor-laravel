@extends('wine-supervisor::default')

@section('page-title') Editer une vente < Administration | WineSupervisor @endsection

@section('page-content')

    @include('wine-supervisor::pages.admin.includes.header')

    <div class="sale-template admin-template">

        <!-- MAIN CONTENT -->
        <div class="main-content container">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>Editer une vente</h1>
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

                <form action="{{ route('admin_sale_update_handler') }}" method="POST" enctype="multipart/form-data">

                    <div class="submit-container" style="margin-top: 0;">
                        <input type="submit" value="Valider" />
                        <a target="_blank" class="button preview-button" href="{{ route('sale_preview', ['uuid' => $sale->id]) }}">Prévisualiser</a>
                    </div>

                    <h3><strong>Informations générales</strong></h3><br>

                    <div class="form-group">
                        <label for="is_active">Mettre en ligne</label>
                        <div class="radio"><input type="radio" name="is_active" value="1" @if ($sale->is_active == true)checked="checked"@endif /> Oui</div>
                        <div class="radio"><input type="radio" name="is_active" value="0" @if (!$sale->is_active)checked="checked"@endif /> Non</div>
                    </div>

                    <div class="form-group">
                        <label for="title">Titre <img class="lang-flag" src="{{ asset('img/generic/flags/fr.jpg') }}" width="25" height="20" /></label>
                        <input type="text" name="title" id="title" value="{{ $sale->title }}" />
                    </div>

                    <div class="form-group">
                        <label for="title_en">Titre <img class="lang-flag" src="{{ asset('img/generic/flags/en.jpg') }}" width="25" height="20" /></label>
                        <input type="text" name="title_en" id="title_en" value="{{ $sale->title_en }}" />
                    </div>

                    <div class="form-group" style="display: none;">
                        <label for="description">Description</label>
                        <textarea class="editor" name="description" id="description">{{ $sale->description }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="start_date">Date de début</label>
                        <input type="text" name="start_date" id="start_date" value="@if ($sale->start_date){{ \DateTime::createFromFormat('Y-m-d', $sale->start_date)->format('d/m/Y') }}@endif" class="datepicker" />
                    </div>

                    <div class="form-group">
                        <label for="end_date">Date de fin</label>
                        <input type="text" name="end_date" id="end_date" value="@if ($sale->end_date){{ \DateTime::createFromFormat('Y-m-d', $sale->end_date)->format('d/m/Y') }}@endif" class="datepicker" />
                    </div>

                    <div class="form-group">
                        <label for="comments">Commentaires <img class="lang-flag" src="{{ asset('img/generic/flags/fr.jpg') }}" width="25" height="20" /></label>
                        <textarea name="comments" id="comments">@if ($sale->comments){{ $sale->comments }}@endif</textarea>
                    </div>

                    <div class="form-group">
                        <label for="comments_en">Commentaires <img class="lang-flag" src="{{ asset('img/generic/flags/en.jpg') }}" width="25" height="20" /></label>
                        <textarea name="comments_en" id="comments_en">@if ($sale->comments_en){{ $sale->comments_en }}@endif</textarea>
                    </div>

                    <div class="form-group">
                        <label for="text_color">Couleur du texte</label>
                        <div class="radio"><input type="radio" name="text_color" value="white" @if ($sale->text_color == 'white')checked="checked"@endif /> Blanc</div>
                        <div class="radio"><input type="radio" name="text_color" value="black" @if ($sale->text_color == 'black')checked="checked"@endif /> Noir</div>
                    </div>

                    <div class="form-group">
                        <label for="link_history">URL quand vente passée</label>
                        <input type="text" name="link_history" id="link_history" value="{{ $sale->link_history }}" />
                    </div>

                    <div class="form-group">
                        <label for="image">Image (1140x585)</label>
                        <input style="display: none;" type="text" name="image" id="image" value="{{ $sale->image }}" />

                        @if ($sale->image)
                            <img style="float:right; width: 40%; margin-left: 10%;" class="thumbnail" src="{{ asset(env('WS_UPLOADS_FOLDER') . 'sales/' . $sale->id . '/0/' . $sale->image) }}" />
                        @endif
                        
                        <input type="file" name="image_file" style="display:block; margin-top: 2rem; float:left; width: 50%; "/>

                    </div>

                    @for($i = 0; $i < 10; $i++)
                        <section style="clear: both; border-bottom: 1px solid #333; margin-bottom: 3rem; padding-bottom: 1rem; margin-top: 10rem;">
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
                                <label for="text_en[]">Texte <img class="lang-flag" src="{{ asset('img/generic/flags/en.jpg') }}" width="25" height="20" /></label>
                                <textarea class="editor" name="wine_text_en[]" id="text_en_{{ $i }}">@if (isset($sale->wines[$i]) && isset($sale->wines[$i]->text_en)){{ $sale->wines[$i]->text_en }}@endif</textarea>
                            </div>

                            <div class="form-group" style="overflow: hidden;">
                                <label for="image[]">Image de fond (1140x585)</label>
                                <input style="display: none;" type="text" name="wine_image[]" value="@if (isset($sale->wines[$i]) && isset($sale->wines[$i]->image)){{ $sale->wines[$i]->image }}@endif" />
                                <input type="file" name="image_wine_background_{{ $i }}" style="display:block; margin-top: 2rem; float:left; width: 50%; "/>

                                @if (isset($sale->wines[$i]) && isset($sale->wines[$i]->image))
                                    <img style="float:left; margin-left: 10%; width: 40%" class="thumbnail" src="{{ asset(env('WS_UPLOADS_FOLDER') . 'sales/' . $sale->id . '/' . ($i+1) . '/' . $sale->wines[$i]->image) }}" />
                                @endif
                            </div>

                            <div class="form-group" style="overflow: hidden;">
                                <label for="bottle_image[]">Image de la bouteille (181x550)</label>
                                <input style="display:none" type="text" name="wine_bottle_image[]" value="@if (isset($sale->wines[$i]) && isset($sale->wines[$i]->bottle_image)){{ $sale->wines[$i]->bottle_image }}@endif" />
                                <input type="file" name="image_wine_bottle_{{ $i }}" style="display:block; margin-top: 2rem; float:left; width: 50%; "/>
                                
                                @if (isset($sale->wines[$i]) && isset($sale->wines[$i]->bottle_image))
                                    <img style="float:right; margin-left: 10%; width: 75px; height: auto" class="thumbnail" src="{{ asset(env('WS_UPLOADS_FOLDER') . 'sales/' . $sale->id . '/' . ($i+1) . '/' . $sale->wines[$i]->bottle_image) }}" />
                                @endif
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
                                <label for="link[]">URL de commande</label>
                                <input type="text" name="wine_link[]" value="@if (isset($sale->wines[$i]) && isset($sale->wines[$i]->link)){{ $sale->wines[$i]->link }}@endif" />
                            </div>
                        </section>
                    @endfor

                    <div class="submit-container">
                        <input type="submit" value="Valider" />
                        <a target="_blank" class="button preview-button" href="{{ route('sale_preview', ['uuid' => $sale->id]) }}">Prévisualiser</a>
                    </div>

                    <input type="hidden" name="sale_id" value="{{ $sale->id }}" />
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
            @for($i = 0; $i < 10; $i++)
                CKEDITOR.replace( 'text_{{ $i }}');
                CKEDITOR.replace( 'text_en_{{ $i }}');
            @endfor
        });
    </script>
@stop

