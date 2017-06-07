@extends('wine-supervisor::default')

@section('page-content')
    <div class="content-template">

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

        <h1>Editer un contenu</h1>

        <form action="{{ route('admin_content_update_handler') }}" method="POST">

            <div>
                <label for="title">Titre</label>
                <input type="text" name="title" id="title" value="{{ $content->title }}" />
            </div>

            <div>
                <label for="slug">URI</label>
                <input type="text" name="slug" id="slug" value="{{ $content->slug }}" />
            </div>

            <div>
                <label for="text">Texte</label>
                <textarea class="editor" name="text" id="text">{{ $content->text }}</textarea>
            </div>

            <a href="{{ route('admin_content_list') }}">Retour</a>
            <input type="submit" value="Valider" />
            <input type="hidden" name="content_id" value="{{ $content->id }}" />
            {{ csrf_field() }}
        </form>

    </div>

    <script>
        $(document).ready(function() {
            CKEDITOR.replace( 'text' );
        });
    </script>
@stop

