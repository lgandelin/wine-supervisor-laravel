@extends('wine-supervisor::default')

@section('page-title') Editer un invité < Administration | WineSupervisor @endsection

@section('page-content')

    @include('wine-supervisor::pages.admin.includes.header')

    <div class="guest-template admin-template">

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

                <form action="{{ route('admin_guest_update_handler') }}" method="POST">

                    <div class="form-group">
                        <label for="first_name">Prénom</label>
                        <input type="text" name="first_name" id="first_name" value="{{ $guest->first_name }}" />
                    </div>

                    <div class="form-group">
                        <label for="last_name">Nom</label>
                        <input type="text" name="last_name" id="last_name" value="{{ $guest->last_name }}" />
                    </div>

                    <div class="form-group">
                        <label for="access_start_date">Date de début d'accès</label>
                        <input type="text" name="access_start_date" id="access_start_date" value="{{ \DateTime::createFromFormat('Y-m-d', $guest->access_start_date)->format('d/m/Y') }}" class="datepicker" />
                    </div>

                    <div class="form-group">
                        <label for="access_end_date">Date de fin d'accès</label>
                        <input type="text" name="access_end_date" id="access_end_date" value="{{ \DateTime::createFromFormat('Y-m-d', $guest->access_end_date)->format('d/m/Y') }}" class="datepicker" />
                    </div>

                    <div class="form-group">
                        <label for="login">Login</label>
                        <input type="text" name="login" id="login" value="{{ $guest->login }}" />
                    </div>

                    <div class="form-group">
                        <label for="login">Mot de passe</label>
                        <input type="password" name="password" id="password" value="" autocomplete="new-password" />
                        <i>Laisser vide pour ne pas modifier le mot de passe</i>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" value="{{ $guest->email }}" />
                    </div>

                    <div class="form-group">
                        <label for="phone">Téléphone</label>
                        <input type="text" name="phone" id="phone" value="{{ $guest->phone }}" />
                    </div>

                    <div class="form-group">
                        <label for="address">Adresse</label>
                        <input type="text" name="address" id="address" value="{{ $guest->address }}" />
                    </div>

                    <div class="form-group">
                        <label for="zipcode">Code postal</label>
                        <input type="text" name="zipcode" id="zipcode" value="{{ $guest->zipcode }}" />
                    </div>

                    <div class="form-group">
                        <label for="city">Ville</label>
                        <input type="text" name="city" id="city" value="{{ $guest->city }}" />
                    </div>

                    <div class="submit-container">
                        <input type="submit" value="Valider" />
                    </div>

                    <input type="hidden" name="guest_id" value="{{ $guest->id }}" />
                    {{ csrf_field() }}
                </form>

                <a class="button red-button back-button" href="{{ route('admin_guest_list') }}">Retour</a>
            </div>
            <!-- PAGE CONTENT -->

        </div>
        <!-- MAIN CONTENT -->

    </div>
@stop