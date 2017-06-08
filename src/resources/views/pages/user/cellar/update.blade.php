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

        <h2>Informations générales</h2>

        <form action="{{ route('user_cellar_update_handler') }}" method="POST">

            <div>
                <label for="id_ws">Adresse MAK</label>
                <input type="text" name="id_ws" id="id_ws" value="{{ $cellar->id_ws }}" disabled />
            </div>

            <div>
                <label for="subscription_type">Type d'abonnement</label>
                <select name="subscription_type" id="subscription_type">
                    <option value="{{ Webaccess\WineSupervisorLaravel\Models\Subscription::DEFAULT_SUBSCRIPTION }}" @if ($cellar->subscription_type == Webaccess\WineSupervisorLaravel\Models\Subscription::DEFAULT_SUBSCRIPTION)selected="selected"@endif>Standard</option>
                    <option value="{{ Webaccess\WineSupervisorLaravel\Models\Subscription::PREMIUM_SUBSCRIPTION}}" @if ($cellar->subscription_type == Webaccess\WineSupervisorLaravel\Models\Subscription::PREMIUM_SUBSCRIPTION)selected="selected"@endif>Premium</option>
                    <option value="{{ Webaccess\WineSupervisorLaravel\Models\Subscription::FREE_SUBSCRIPTION}}" @if ($cellar->subscription_type == Webaccess\WineSupervisorLaravel\Models\Subscription::FREE_SUBSCRIPTION)selected="selected"@endif>Gratuit</option>
                </select>
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

            <a href="{{ route('user_cellar_list') }}">Retour</a>
            <input type="submit" value="Valider" />
            <input type="hidden" name="cellar_id" value="{{ $cellar->id }}" />
            {{ csrf_field() }}
        </form>

        <h2>SAV</h2>

        <p>Si vous avez changé votre carte, veuillez renseignez ci-dessous l'adresse MAK de votre nouvelle carte.</p>

        <form action="{{ route('user_cellar_sav_handler') }}" method="POST">
            <div>
                <label for="id_ws">Nouvelle adresse MAK</label>
                <input type="text" name="id_ws" id="id_ws" />
            </div>

            <a href="{{ route('user_cellar_list') }}">Retour</a>
            <input type="submit" value="Valider" />
            <input type="hidden" name="cellar_id" value="{{ $cellar->id }}" />
            {{ csrf_field() }}
        </form>

        <h2>Suppression</h2>

        <p>ATTENTION : Valider ce formulaire entrainera la suppression de votre cave dans le système.</p>

        <form action="{{ route('user_cellar_delete_handler') }}" method="POST">
            <div>
                <label for="reason">Raison de la suppression</label>
                <select name="reason" id="reason">
                    <option value="board_out_of_order">Carte HS</option>
                    <option value="other">Autre</option>
                </select>
            </div>

            <a href="{{ route('user_cellar_list') }}">Retour</a>
            <input type="submit" value="Valider" />
            <input type="hidden" name="cellar_id" value="{{ $cellar->id }}" />
            {{ csrf_field() }}
        </form>

    </div>
@stop