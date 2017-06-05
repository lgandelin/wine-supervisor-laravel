@extends('wine-supervisor::default')

@section('page-content')
    <div class="cellar-template">

        @if (isset($error))
            <div class="alert alert-danger">
                {{ $technician->error }}
            </div>
        @endif

        @if (isset($confirmation))
            <div class="alert alert-success">
                {{ $technician->confirmation }}
            </div>
        @endif

        <h1>Editer un professionnel</h1>

        <form action="{{ route('admin_technician_update_handler') }}" method="POST">

            <div>
                <label for="company">Nom de la société</label>
                <input type="text" name="company" id="company" value="{{ $technician->company }}" disabled />
            </div>

            <div>
                <label for="registration">Immatriculation</label>
                <input type="text" name="registration" id="registration" value="{{ $technician->registration }}" disabled />
            </div>

            <div>
                <label for="phone">Téléphone</label>
                <input type="text" name="phone" id="phone" value="{{ $technician->phone }}" disabled />
            </div>

            <div>
                <label for="email">Email</label>
                <input type="text" name="email" id="email" value="{{ $technician->email }}" disabled />
            </div>

            <div>
                <label for="login">Login</label>
                <input type="text" name="login" id="login" value="{{ $technician->login }}" disabled />
            </div>

            <div>
                <label for="address">Adresse</label>
                <input type="text" name="address" id="address" value="{{ $technician->address }}" disabled />
            </div>

            <div>
                <label for="zipcode">Code postal</label>
                <input type="text" name="zipcode" id="zipcode" value="{{ $technician->zipcode }}" disabled />
            </div>

            <div>
                <label for="city">Ville</label>
                <input type="text" name="city" id="city" value="{{ $technician->city }}" disabled />
            </div>

            <div>
                <label for="city">Statut</label>
                <input type="radio" name="status" @if ($technician->status === Webaccess\WineSupervisorLaravel\Models\Technician::STATUS_ENABLED)checked="checked"@endif value="on" /> Activé
                <input type="radio" name="status"   @if (!$technician->status)checked="checked"@endif value="off" /> Désactivé
            </div>

            <a href="{{ route('admin_technician_list') }}">Retour</a>
            <input type="submit" value="Valider" />
            <input type="hidden" name="technician_id" value="{{ $technician->id }}" />
            {{ csrf_field() }}
        </form>

    </div>
@stop