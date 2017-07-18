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

                    <div class="form-group" style="display:none;">
                        <label for="slug">URI</label>
                        <input type="text" name="slug" id="slug" value="{{ $content->slug }}" />
                    </div>

                    <div class="form-group">
                        <label for="text">Texte</label>
                        <textarea class="editor" name="text" id="text">{{ $content->text }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="publication_date">Date de publication</label>
                        <input type="text" name="publication_date" id="publication_date" value="{{ \DateTime::createFromFormat('Y-m-d', $content->publication_date)->format('d/m/Y') }}" class="datepicker" />
                    </div>

                    <div class="form-group">
                        <label for="image">Image</label>
                        <input disabled style="float:left; width: 50%;" type="text" name="image" id="image" value="{{ $content->image }}" />

                        @if (isset($content->image))
                            <img style="float:right; margin-left: 10%; width: 40%; height: auto" class="thumbnail" src="{{ asset($content->image) }}" />
                        @endif
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

