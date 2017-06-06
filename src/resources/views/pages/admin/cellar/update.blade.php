@extends('wine-supervisor::default')

@section('page-content')
    <div class="cellar-template">

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

        <h1>Editer une cave</h1>

        <form action="{{ route('admin_cellar_update_handler') }}" method="POST">

            <div>
                <label for="id">ID</label>
                <input type="text" name="id" id="id" value="{{ $cellar->id }}" disabled />
            </div>

            <a href="{{ route('admin_cellar_list') }}">Retour</a>
            <input type="submit" value="Valider" />
            <input type="hidden" name="cellar_id" value="{{ $cellar->id }}" />
            {{ csrf_field() }}
        </form>

    </div>
@stop