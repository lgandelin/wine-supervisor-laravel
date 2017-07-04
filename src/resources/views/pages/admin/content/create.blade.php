@extends('wine-supervisor::default')

@section('page-content')

    @include('wine-supervisor::pages.admin.includes.header')

    <div class="content-template admin-template">

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

        <h1>Créer un contenu</h1>

        <form action="{{ route('admin_content_create_handler') }}" method="POST">

            <div>
                <label for="title">Titre</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" />
            </div>

            <div>
                <label for="slug">URI</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug') }}" />
            </div>

            <div>
                <label for="text">Texte</label>
                <textarea class="editor" name="text" id="text">{{ old('text') }}</textarea>
            </div>

            <a href="{{ route('admin_content_list') }}">Retour</a>
            <input type="submit" value="Valider" />
            {{ csrf_field() }}
        </form>

    </div>

    <script>
        $(document).ready(function() {
            CKEDITOR.replace( 'text' );
        });
    </script>
@stop
