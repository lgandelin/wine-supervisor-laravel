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

            <h2>Infos cave</h2>

            <div>
                <label for="id_ws">Adresse Mak</label>
                <input type="text" name="id_ws" id="id_ws" value="{{ $cellar->id_ws }}" disabled />
            </div>

            <div>
                <label for="technician_id">ID Professionnel</label>
                <input type="text" name="technician_id" id="technician_id" value="{{ $cellar->technician_id }}" />
            </div>

            <div>
                <label for="name">Nom de la cave (optionnel)</label>
                <input type="text" name="name" id="name" value="{{ $cellar->name }}"/>
            </div>

            <div>
                <label for="serial_number">N° de série</label>
                <input type="text" name="serial_number" id="serial_number" value="{{ $cellar->serial_number }}" />
            </div>

            <div>
                <label for="address">Adresse</label>
                <input type="text" name="address" id="address" value="{{ $cellar->address }}"/>
            </div>

            <div>
                <label for="zipcode">Code postal</label>
                <input type="text" name="zipcode" id="zipcode" value="{{ $cellar->zipcode }}"/>
            </div>

            <div>
                <label for="city">Ville</label>
                <input type="text" name="city" id="city" value="{{ $cellar->city }}"/>
            </div>


            <h2>Infos utilisateur</h2>

            <div>
                <label for="last_name">Nom</label>
                <input type="text" name="last_name" id="last_name" value="{{ $cellar->user->last_name }}" disabled />
            </div>

            <div>
                <label for="first_name">Prénom</label>
                <input type="text" name="first_name" id="first_name" value="{{ $cellar->user->first_name }}" disabled />
            </div>

            <div>
                <label for="email">Email</label>
                <input type="text" name="email" id="email" value="{{ $cellar->user->email }}" disabled />
            </div>

            <div>
                <label for="login">Login</label>
                <input type="text" name="login" id="login" value="{{ $cellar->user->login }}" disabled />
            </div>

            <div>
                <label for="opt_in">Inscrit à la newsletter</label>
                <input type="checkbox" name="opt_in" id="opt_in" @if ($cellar->user->opt_in === true || $cellar->user->opt_in === null)checked="checked"@endif disabled />
            </div>

            <a href="{{ route('admin_cellar_list') }}">Retour</a>
            <input type="submit" value="Valider" />
            <input type="hidden" name="cellar_id" value="{{ $cellar->id }}" />
            {{ csrf_field() }}
        </form>

    </div>
@stop