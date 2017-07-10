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

                <form action="{{ route('admin_sale_update_handler') }}" method="POST">

                    <div class="form-group">
                        <label for="title">Titre</label>
                        <input type="text" name="title" id="title" value="{{ $sale->title }}" />
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="editor" name="description" id="description">{{ $sale->description }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="start_date">Date de début</label>
                        <input type="text" name="start_date" id="start_date" value="{{ \DateTime::createFromFormat('Y-m-d', $sale->start_date)->format('d/m/Y') }}" class="datepicker" />
                    </div>

                    <div class="form-group">
                        <label for="end_date">Date de fin</label>
                        <input type="text" name="end_date" id="end_date" value="{{ \DateTime::createFromFormat('Y-m-d', $sale->end_date)->format('d/m/Y') }}" class="datepicker" />
                    </div>

                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" name="image" id="image" value="{{ $sale->image }}" />
                        <br/>
                        <br/>
                        @if ($sale->image)
                            Image actuelle : {{ $sale->image }}<br>
                            <img class="thumbnail" src="{{ asset('img/sales/' . $sale->id . '/0/' . $sale->image) }}" />
                        @else
                            Aucune image actuellement
                        @endif
                    </div>

                    <div class="submit-container">
                        <input type="submit" value="Valider" />
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
            CKEDITOR.replace( 'jury_opinion' );
        });
    </script>
@stop

