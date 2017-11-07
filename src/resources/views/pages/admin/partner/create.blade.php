@extends('wine-supervisor::default')

@section('page-content')

    @include('wine-supervisor::pages.admin.includes.header')

    <div class="partner-template admin-template">

        <!-- MAIN CONTENT -->
        <div class="main-content container">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>Créer un partenaire</h1>
            </div>
            <!-- PAGE HEADER -->

            <!-- PAGE CONTENT -->
            <div class="page-partner">

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


                <form action="{{ route('admin_partner_create_handler') }}" method="POST" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="is_active">Mettre en ligne</label>
                        <div class="radio"><input type="radio" name="is_active" value="1" /> Oui</div>
                        <div class="radio"><input type="radio" name="is_active" value="0" checked="checked" /> Non</div>
                    </div>

                    <div class="form-group">
                        <label for="name">Titre</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" />
                    </div>

                    <div class="form-group">
                        <label for="url">URL</label>
                        <input type="text" name="url" id="url" value="{{ old('url') }}" />
                    </div>

                    <div class="form-group">
                        <label for="position">Ordre</label>
                        <input type="text" name="position" id="position" value="{{ old('position') }}" placeholder="ex: 3" />
                    </div>

                    <div class="form-group" style="margin-bottom: 6rem;">
                        <label for="image">Image (220x150, 150x150, etc...)</label>
                        <input style="display:none" type="text" name="image" id="image" value="" />

                        <input type="file" name="image_file" style="display:block; margin-top: 2rem; float:left; width: 50%; "/>
                    </div>

                    <div class="form-group" style="clear:both">
                        <div style="display: inline-block;">
                            <label for="image_width">Largeur de l'image</label>
                            <input style="width:200px" type="text" name="image_width" id="image_width" placeholder="220" /> px
                        </div>

                        <div style="display: inline-block; margin-left: 5rem;">
                            <label for="image_width">Hauteur de l'image</label>
                            <input style="width:200px" type="text" name="image_height" id="image_height" placeholder="150" /> px
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="display_start_date">Date de début d'affichage</label>
                        <input type="text" name="display_start_date" id="display_start_date" value="@if (old('display_start_date')){{ \DateTime::createFromFormat('Y-m-d', old('display_start_date'))->format('d/m/Y') }}@endif" class="datepicker" />
                        <i>Laisser vide pour ne pas mettre de contrainte sur la date</i>
                    </div>

                    <div class="form-group">
                        <label for="display_end_date">Date de fin d'affichage</label>
                        <input type="text" name="display_end_date" id="display_end_date" value="@if (old('display_start_date')){{ \DateTime::createFromFormat('Y-m-d', old('display_start_date'))->format('d/m/Y') }}@endif" class="datepicker" />
                        <i>Laisser vide pour ne pas mettre de contrainte sur la date</i>
                    </div>

                    <div class="submit-container" style="clear:both; overflow: hidden">
                        <input type="submit" value="Valider" />
                    </div>

                    <a class="button red-button back-button" href="{{ route('admin_partner_list') }}">Retour</a>
                    {{ csrf_field() }}
                </form>

            </div>
            <!-- PAGE CONTENT -->

        </div>
        <!-- MAIN CONTENT -->

    </div>
@stop
