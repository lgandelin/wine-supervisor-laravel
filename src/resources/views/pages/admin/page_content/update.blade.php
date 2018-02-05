@extends('wine-supervisor::default')

@section('page-title') Editer un contenu < Administration | WineSupervisor @endsection

@section('page-content')

    @include('wine-supervisor::pages.admin.includes.header')

    <div class="content-template admin-template">

        <!-- MAIN CONTENT -->
        <div class="main-content container">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>Editer un contenu</h1>
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

                <form action="{{ route('admin_page_content_update_handler') }}" method="POST" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="title">Titre <img class="lang-flag" src="{{ asset('img/generic/flags/fr.jpg') }}" width="25" height="20" /></label>
                        <input type="text" name="title" id="title" value="{{ $content->title }}" />
                    </div>

                    <div class="form-group">
                        <label for="text">Texte <img class="lang-flag" src="{{ asset('img/generic/flags/fr.jpg') }}" width="25" height="20" /></label>
                        <textarea class="editor" name="text" id="text">{{ $content->text }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="text_en">Texte <img class="lang-flag" src="{{ asset('img/generic/flags/en.jpg') }}" width="25" height="20" /></label>
                        <textarea class="editor" name="text_en" id="text_en">{{ $content->text_en }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="image">Image</label>
                        <input style="display:none" type="text" name="image" id="image" value="{{ $content->image }}" />

                        @if (isset($content->image) && $content->image)
                            <img style="float:right; margin-left: 10%; width: 40%; height: auto" class="thumbnail" src="{{ asset(env('WS_UPLOADS_FOLDER') . 'contents/' . $content->id . '/' . $content->image) }}" />
                        @endif

                        <input type="file" name="image_file" style="display:block; margin-top: 2rem; float:left; width: 50%; "/>
                    </div>

                    <div class="submit-container">
                        <input type="submit" value="Valider" />
                    </div>

                    <input type="hidden" name="page_content_id" value="{{ $content->id }}" />
                    {{ csrf_field() }}
                </form>

                <a class="button red-button back-button" href="{{ route('admin_page_content_list') }}">Retour</a>
            </div>
            <!-- PAGE CONTENT -->

        </div>
        <!-- MAIN CONTENT -->
    </div>

    <script>
        $(document).ready(function() {
            CKEDITOR.replace( 'text' );
            CKEDITOR.replace( 'text_en' );
        });
    </script>
@stop
