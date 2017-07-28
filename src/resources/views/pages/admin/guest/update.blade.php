@extends('wine-supervisor::default')

@section('page-title') Editer un invité < Administration | WineSupervisor @endsection

@section('page-content')

    @include('wine-supervisor::pages.admin.includes.header')

    <div class="guest-template admin-template">

        <!-- MAIN CONTENT -->
        <div class="main-content container">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>Editer un invité</h1>
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
                        <label for="last_name">Nom</label>
                        <input type="text" name="last_name" id="last_name" value="{{ $guest->last_name }}" />
                    </div>

                    <div class="form-group">
                        <label for="first_name">Prénom</label>
                        <input type="text" name="first_name" id="first_name" value="{{ $guest->first_name }}" />
                    </div>

                    <div class="form-group">
                        <label for="access_start_date">Date de début d'accès <span class="required">*</span></label>
                        <input type="text" name="access_start_date" id="access_start_date" value="@if ($guest->access_start_date){{ \DateTime::createFromFormat('Y-m-d', $guest->access_start_date)->format('d/m/Y') }}@endif" class="datepicker" />
                    </div>

                    <div class="form-group">
                        <label for="access_end_date">Date de fin d'accès <span class="required">*</span></label>
                        <input type="text" name="access_end_date" id="access_end_date" value="@if ($guest->access_end_date){{ \DateTime::createFromFormat('Y-m-d', $guest->access_end_date)->format('d/m/Y') }}@endif" class="datepicker" />
                    </div>

                    <div class="form-group">
                        <label for="login">Login <span class="required">*</span></label>
                        <input type="text" name="login" id="login" value="{{ $guest->login }}" />
                    </div>

                    <div class="form-group">
                        <label for="login">Mot de passe <span class="required">*</span></label>
                        <input type="password" name="password" id="password" value="********" autocomplete="new-password" required />
                    </div>

                    <div class="form-group">
                        <label for="password_confirm">Confirmation du mot de passe <span class="required">*</span></label>
                        <input type="password" name="password_confirm" id="password_confirm" autocomplete="new-password" value="********" required />
                    </div>

                    <div class="form-group">
                        <label for="email">Email <span class="required">*</span></label>
                        <input type="text" name="email" id="email" value="{{ $guest->email }}" required />
                    </div>

                    <div class="form-group">
                        <label for="phone">Téléphone</label>
                        <input type="text" name="phone" id="phone" value="{{ $guest->phone }}" />
                    </div>

                    <div class="form-group">
                        <label for="company">Société</label>
                        <input type="text" name="company" id="company" value="{{ $guest->company }}" />
                    </div>

                    <div class="form-group">
                        <label for="address">Adresse</label>
                        <input type="text" name="address" id="address" value="{{ $guest->address }}" />
                    </div>

                    <div class="form-group">
                        <label for="address2">Complément d'adresse</label>
                        <input type="text" name="address2" id="address2" value="{{ $guest->address2 }}" />
                    </div>

                    <div class="form-group">
                        <label for="zipcode">Code postal</label>
                        <input type="text" name="zipcode" id="zipcode" value="{{ $guest->zipcode }}" />
                    </div>

                    <div class="form-group">
                        <label for="city">Ville</label>
                        <input type="text" name="city" id="city" value="{{ $guest->city }}" />
                    </div>

                    <div class="form-group">
                        <label for="country">Pays</label>
                        <select name="country" id="country" required>
                            @foreach (\Webaccess\WineSupervisorLaravel\Tools\CountriesTool::getCountriesList() as $key => $label)
                                <option value="{{ $key }}" @if ($guest->country == $key)selected="selected"@endif @if (!$guest->country && $key == 'FR')selected="selected"@endif>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <i class="legend"><span class="required">*</span> : champs obligatoires</i>

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