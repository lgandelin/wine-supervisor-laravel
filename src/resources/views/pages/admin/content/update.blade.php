@extends('wine-supervisor::default')

@section('page-title') Editer une actualité < Administration | WineSupervisor @endsection

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

                <form action="{{ route('admin_content_update_handler') }}" method="POST">

                    <div class="form-group">
                        <label for="title">Titre</label>
                        <input type="text" name="title" id="title" value="{{ $content->title }}" />
                    </div>

                    <div class="form-group">
                        <label for="slug">URI</label>
                        <input type="text" name="slug" id="slug" value="{{ $content->slug }}" />
                    </div>

                    <div class="form-group">
                        <label for="text">Texte</label>
                        <textarea class="editor" name="text" id="text">{{ $content->text }}</textarea>
                    </div>

                    <div class="submit-container">
                        <input type="submit" value="Valider" />
                    </div>

                    <input type="hidden" name="content_id" value="{{ $content->id }}" />
                    {{ csrf_field() }}
                </form>

                <a class="button red-button back-button" href="{{ route('admin_content_list') }}">Retour</a>
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

