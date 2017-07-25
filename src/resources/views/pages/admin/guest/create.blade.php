@extends('wine-supervisor::default')

@section('page-title') Créer un invité < Administration | WineSupervisor @endsection

@section('page-content')

    @include('wine-supervisor::pages.admin.includes.header')

    <div class="guest-template admin-template">

        <!-- MAIN CONTENT -->
        <div class="main-content container">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>Créer un invité</h1>
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

                <form action="{{ route('admin_guest_create_handler') }}" method="POST">

                    <div class="form-group">
                        <label for="last_name">Nom</label>
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" />
                    </div>

                    <div class="form-group">
                        <label for="first_name">Prénom</label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" />
                    </div>

                    <div class="form-group">
                        <label for="access_start_date">Date de début d'accès</label>
                        <input type="text" name="access_start_date" id="access_start_date" value="{{ old('access_start_date') }}" class="datepicker" />
                    </div>

                    <div class="form-group">
                        <label for="access_end_date">Date de fin d'accès</label>
                        <input type="text" name="access_end_date" id="access_end_date" value="{{ old('access_end_date') }}" class="datepicker" />
                    </div>

                    <div class="form-group">
                        <label for="login">Login</label>
                        <input type="text" name="login" id="login" value="{{ old('login') }}" required />
                    </div>

                    <div class="form-group">
                        <label for="login">Mot de passe</label>
                        <input type="password" name="password" id="password" value="" autocomplete="new-password" required />
                    </div>

                    <div class="form-group">
                        <label for="password_confirm">Confirmation du mot de passe</label>
                        <input type="password" name="password_confirm" id="password_confirm" autocomplete="new-password" value="********" />
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" value="{{ old('email') }}" />
                    </div>

                    <div class="form-group">
                        <label for="phone">Téléphone</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" />
                    </div>

                    <div class="form-group">
                        <label for="company">Société</label>
                        <input type="text" name="company" id="company" value="{{ old('company') }}" />
                    </div>

                    <div class="form-group">
                        <label for="address">Adresse</label>
                        <input type="text" name="address" id="address" value="{{ old('address') }}" />
                    </div>

                    <div class="form-group">
                        <label for="address2">Complément d'adresse</label>
                        <input type="text" name="address2" id="address2" value="{{ old('address2') }}" />
                    </div>

                    <div class="form-group">
                        <label for="zipcode">Code postal</label>
                        <input type="text" name="zipcode" id="zipcode" value="{{ old('zipcode') }}" />
                    </div>

                    <div class="form-group">
                        <label for="city">Ville</label>
                        <input type="text" name="city" id="city" value="{{ old('city') }}" />
                    </div>

                    <div class="form-group">
                        <label for="country">Pays</label>
                        <select name="country" id="country" required>
                            @foreach (\Webaccess\WineSupervisorLaravel\Tools\CountriesTool::getCountriesList() as $key => $label)
                                <option value="{{ $key }}" @if (old('country') == $key)selected="selected"@endif @if (!old('country') && $key == 'FR')selected="selected"@endif>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="submit-container">
                        <input type="submit" value="Valider" />
                    </div>

                    {{ csrf_field() }}
                </form>

                <a class="button red-button back-button" href="{{ route('admin_guest_list') }}">Retour</a>
            </div>
            <!-- PAGE CONTENT -->

        </div>
        <!-- MAIN CONTENT -->

    </div>
@stop