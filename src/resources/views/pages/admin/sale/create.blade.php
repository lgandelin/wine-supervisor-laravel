@extends('wine-supervisor::default')

@section('page-content')

    @include('wine-supervisor::pages.admin.includes.header')

    <div class="sale-template">

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

        <h1>Créer une vente</h1>

        <form action="{{ route('admin_sale_create_handler') }}" method="POST">

            <div>
                <label for="title">Titre</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" />
            </div>

            <div>
                <label for="jury_note">Note du jury</label>
                <input type="text" name="jury_note" id="jury_note" value="{{ old('jury_note') }}" /> / 20
            </div>

            <div>
                <label for="jury_opinion">Avis du jury</label>
                <textarea class="editor" name="jury_opinion" id="jury_opinion">{{ old('jury_opinion') }}</textarea>
            </div>

            <div>
                <label for="description">Commentaires</label>
                <textarea class="editor" name="description" id="description">{{ old('description') }}</textarea>
            </div>

            <div>
                <label for="start_date">Date de début</label>
                <input type="text" name="start_date" id="start_date" value="{{ old('start_date') }}" class="datepicker" />
            </div>

            <div>
                <label for="end_date">Date de fin</label>
                <input type="text" name="end_date" id="end_date" value="{{ old('end_date') }}" class="datepicker" />
            </div>

            <div>
                <label for="link">Lien de commande</label>
                <input type="text" name="link" id="link" value="{{ old('link') }}" />
            </div>

            <a href="{{ route('admin_sale_list') }}">Retour</a>
            <input type="submit" value="Valider" />
            {{ csrf_field() }}
        </form>

    </div>

    <script>
        $(document).ready(function() {
            CKEDITOR.replace( 'description' );
            CKEDITOR.replace( 'jury_opinion' );
        });
    </script>
@stop
