@extends('wine-supervisor::default')

@section('page-content')

    @include('wine-supervisor::pages.admin.includes.header')

    <div class="content-template admin-template">

        <!-- MAIN CONTENT -->
        <div class="main-content container">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>Créer une actualité</h1>
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


                <form action="{{ route('admin_content_create_handler') }}" method="POST" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="title">Titre</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" />
                    </div>

                    <div class="form-group" style="display:none;">
                        <label for="slug">URI</label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug') }}" />
                    </div>

                    <div class="form-group">
                        <label for="text">Texte</label>
                        <textarea class="editor" name="text" id="text">{{ old('text') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="publication_date">Date de publication</label>
                        <input type="text" name="publication_date" id="publication_date" value="@if (old('publication_date')){{ \DateTime::createFromFormat('Y-m-d', old('publication_date'))->format('d/m/Y') }}@endif" class="datepicker" />
                    </div>

                    <div class="form-group">
                        <label for="image">Image (350x273)</label>
                        <input style="display:none" type="text" name="image" id="image" value="" />

                        <input type="file" name="image_file" style="display:block; margin-top: 2rem; float:left; width: 50%; "/>
                    </div>

                    <div class="submit-container">
                        <input type="submit" value="Valider" />
                    </div>

                    <a class="button red-button back-button" href="{{ route('admin_content_list') }}">Retour</a>
                    {{ csrf_field() }}
                </form>

            </div>
            <!-- PAGE CONTENT -->

        </div>
        <!-- MAIN CONTENT -->

    </div>

    <script>
        $(document).ready(function() {
            CKEDITOR.replace( 'text' );
        });
    </script>
@stop
